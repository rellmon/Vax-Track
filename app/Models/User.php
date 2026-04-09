<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'active'];
    protected $hidden   = ['password'];

    public function schedules() { return $this->hasMany(Schedule::class, 'created_by_user_id'); }
    public function vaccineRecords() { return $this->hasMany(VaccineRecord::class, 'user_id'); }
    public function auditLogs() { return $this->hasMany(AuditLog::class, 'user_id'); }
}
