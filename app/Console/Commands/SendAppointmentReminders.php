<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Child;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send {--hours=24 : Number of hours to look ahead for appointments}';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Send appointment reminder emails to parents for upcoming appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = (int) $this->option('hours');
        
        $this->info("Checking for appointments in the next {$hours} hour(s)...");

        // Find appointments scheduled for the next X hours
        $startTime = now();
        $endTime = now()->addHours($hours);

        $upcomingAppointments = Schedule::with(['child.parent', 'vaccine'])
            ->whereNull('deleted_at')
            ->where('appointment_date', '>=', $startTime->toDateString())
            ->where('appointment_date', '<=', $endTime->toDateString())
            ->where('status', '!=', 'Cancelled')
            ->where('status', '!=', 'Completed')
            ->get();

        if ($upcomingAppointments->isEmpty()) {
            $this->info('No upcoming appointments found.');
            return Command::SUCCESS;
        }

        $this->info("Found " . $upcomingAppointments->count() . " upcoming appointment(s).");

        $sentCount = 0;
        $failedCount = 0;

        foreach ($upcomingAppointments as $schedule) {
            // Skip if no parent or parent has no email
            if (!$schedule->child->parent || !$schedule->child->parent->email) {
                $this->warn("Skipping appointment {$schedule->id}: No parent email found.");
                $failedCount++;
                continue;
            }

            try {
                // Send reminder email
                Mail::to($schedule->child->parent->email)
                    ->send(new AppointmentReminder($schedule));

                $this->line("✓ Reminder sent to {$schedule->child->parent->email} for {$schedule->child->first_name}");
                
                Log::info('Appointment reminder email sent', [
                    'schedule_id' => $schedule->id,
                    'parent_id' => $schedule->child->parent->id,
                    'email' => $schedule->child->parent->email,
                    'appointment_date' => $schedule->appointment_date,
                ]);

                $sentCount++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder for appointment {$schedule->id}: {$e->getMessage()}");
                
                Log::error('Appointment reminder email failed', [
                    'schedule_id' => $schedule->id,
                    'parent_id' => $schedule->child->parent->id,
                    'email' => $schedule->child->parent->email,
                    'error' => $e->getMessage(),
                ]);

                $failedCount++;
            }
        }

        $this->info("\n📊 Summary:");
        $this->line("✓ Sent: {$sentCount}");
        $this->line("✗ Failed: {$failedCount}");

        return Command::SUCCESS;
    }
}
