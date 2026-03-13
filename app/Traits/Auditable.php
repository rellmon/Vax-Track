<?php
namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Session;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::recordAudit('create', $model, null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = array_diff_assoc($model->getOriginal(), $model->getAttributes());
            $newValues = array_intersect_key($model->getAttributes(), $oldValues);
            
            if (!empty($oldValues)) {
                self::recordAudit('update', $model, $oldValues, $newValues);
            }
        });

        static::restored(function ($model) {
            self::recordAudit('restore', $model, null, $model->getAttributes());
        });

        static::forceDeleted(function ($model) {
            self::recordAudit('delete', $model, $model->getOriginal(), null);
        });
    }

    private static function recordAudit(string $action, $model, ?array $oldValues, ?array $newValues)
    {
        try {
            $userType = null;
            $userId = null;

            if (Session::has('doctor_id')) {
                $userType = 'doctor';
                $userId = Session::get('doctor_id');
            } elseif (Session::has('parent_id')) {
                $userType = 'parent';
                $userId = Session::get('parent_id');
            }

            if ($userType && $userId) {
                AuditLog::create([
                    'user_type' => $userType,
                    'user_id' => $userId,
                    'action' => $action,
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'old_values' => $oldValues ? json_encode($oldValues) : null,
                    'new_values' => $newValues ? json_encode($newValues) : null,
                    'ip_address' => request()?->ip(),
                    'user_agent' => request()?->userAgent(),
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Audit log failed: ' . $e->getMessage());
        }
    }
}
