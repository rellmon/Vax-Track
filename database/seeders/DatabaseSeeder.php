<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ParentGuardian;
use App\Models\Child;
use App\Models\Vaccine;
use App\Models\Schedule;
use App\Models\VaccineRecord;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'     => 'Dr. Admin',
            'username' => 'admin',
            'email'    => 'admin@vacctrack.ph',
            'password' => Hash::make('admin'),
            'role'     => 'Admin',
        ]);

        // Demo doctor account
        User::create([
            'name'     => 'Dr. Samson Cruz',
            'username' => 'samsonclinic',
            'email'    => 'zllmntzr@gmail.com',
            'password' => Hash::make('admin123'),
            'role'     => 'doctor',
        ]);

        // Parents
        $parent1 = ParentGuardian::create([
            'first_name' => 'Maria', 'last_name' => 'Cruz',
            'phone' => '09171234567', 'email' => 'maria@example.com',
            'address' => '123 Mabini St, Pasig City',
            'username' => 'parent', 'password' => Hash::make('parent'),
        ]);
        $parent2 = ParentGuardian::create([
            'first_name' => 'Jose', 'last_name' => 'Reyes',
            'phone' => '09182345678', 'email' => 'jose@example.com',
            'address' => '45 Rizal Ave, Pasig City',
            'username' => 'parent2', 'password' => Hash::make('parent'),
        ]);
        $parent3 = ParentGuardian::create([
            'first_name' => 'Ana', 'last_name' => 'Santos',
            'phone' => '09193456789', 'email' => 'ana@example.com',
            'address' => '78 Ortigas Ave, Pasig City',
            'username' => 'parent3', 'password' => Hash::make('parent'),
        ]);

        // Children
        $child1 = Child::create(['first_name'=>'Liam','last_name'=>'Cruz','dob'=>'2024-06-15','gender'=>'Male','blood_type'=>'O+','parent_id'=>$parent1->id,'address'=>'123 Mabini St, Pasig City','notes'=>'No allergies reported.']);
        $child2 = Child::create(['first_name'=>'Sofia','last_name'=>'Reyes','dob'=>'2023-11-02','gender'=>'Female','blood_type'=>'A+','parent_id'=>$parent2->id,'address'=>'45 Rizal Ave, Pasig City','notes'=>'Penicillin allergy.']);
        $child3 = Child::create(['first_name'=>'Noah','last_name'=>'Santos','dob'=>'2024-02-20','gender'=>'Male','blood_type'=>'B+','parent_id'=>$parent3->id,'address'=>'78 Ortigas Ave, Pasig City','notes'=>'']);

        // Vaccines
        $bcg = Vaccine::create(['name'=>'BCG','type'=>'Birth','stock'=>50,'price'=>350,'manufacturer'=>'Serum Institute','description'=>'Bacillus Calmette–Guérin vaccine for tuberculosis prevention.','active'=>true]);
        $hepb = Vaccine::create(['name'=>'Hepatitis B','type'=>'Birth','stock'=>45,'price'=>420,'manufacturer'=>'GlaxoSmithKline','description'=>'Protection against hepatitis B virus infection.','active'=>true]);
        $dpt = Vaccine::create(['name'=>'DPT-HepB-Hib','type'=>'6 weeks','stock'=>30,'price'=>680,'manufacturer'=>'Sanofi Pasteur','description'=>'Combination vaccine — diphtheria, pertussis, tetanus, hepatitis B, Hib.','active'=>true]);
        $opv = Vaccine::create(['name'=>'OPV','type'=>'6 weeks','stock'=>60,'price'=>180,'manufacturer'=>'WHO/Unicef','description'=>'Oral polio vaccine (live attenuated).','active'=>true]);
        $pcv = Vaccine::create(['name'=>'PCV','type'=>'6 weeks','stock'=>20,'price'=>3200,'manufacturer'=>'Pfizer','description'=>'Pneumococcal conjugate vaccine.','active'=>true]);
        $mmr = Vaccine::create(['name'=>'MMR','type'=>'12 months','stock'=>25,'price'=>950,'manufacturer'=>'MSD','description'=>'Measles, mumps, rubella combination vaccine.','active'=>true]);

        // Schedules
        $s1 = Schedule::create(['child_id'=>$child1->id,'vaccine_id'=>$dpt->id,'appointment_date'=>now()->addDays(2)->format('Y-m-d'),'appointment_time'=>'09:00','status'=>'Scheduled','notes'=>'Second DPT dose','sms_sent'=>true]);
        $s2 = Schedule::create(['child_id'=>$child2->id,'vaccine_id'=>$mmr->id,'appointment_date'=>now()->addDays(4)->format('Y-m-d'),'appointment_time'=>'10:30','status'=>'Scheduled','notes'=>'MMR booster','sms_sent'=>false]);
        $s3 = Schedule::create(['child_id'=>$child3->id,'vaccine_id'=>$opv->id,'appointment_date'=>now()->format('Y-m-d'),'appointment_time'=>'08:00','status'=>'Completed','notes'=>'','sms_sent'=>true]);
        $s4 = Schedule::create(['child_id'=>$child1->id,'vaccine_id'=>$pcv->id,'appointment_date'=>now()->subDays(3)->format('Y-m-d'),'appointment_time'=>'11:00','status'=>'Completed','notes'=>'','sms_sent'=>true]);

        // Vaccine records
        VaccineRecord::create(['child_id'=>$child1->id,'vaccine_id'=>$pcv->id,'date_given'=>now()->subDays(3)->format('Y-m-d'),'dose_number'=>1,'notes'=>'Given without issues','administered_by'=>'Dr. Admin']);
        VaccineRecord::create(['child_id'=>$child3->id,'vaccine_id'=>$opv->id,'date_given'=>now()->format('Y-m-d'),'dose_number'=>1,'notes'=>'','administered_by'=>'Dr. Admin']);

        // Payments
        Payment::create(['child_id'=>$child1->id,'schedule_id'=>$s4->id,'amount'=>3200,'method'=>'Cash','status'=>'Paid','payment_date'=>now()->subDays(3)->format('Y-m-d'),'notes'=>'PCV dose 1']);
        Payment::create(['child_id'=>$child3->id,'schedule_id'=>$s3->id,'amount'=>180,'method'=>'Cash','status'=>'Paid','payment_date'=>now()->format('Y-m-d'),'notes'=>'OPV']);
    }
}
