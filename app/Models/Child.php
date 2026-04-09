<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use Carbon\Carbon;

class Child extends Model {
    use SoftDeletes, Auditable;
    
    protected $fillable = ['first_name','last_name','dob','gender','blood_type','address','notes','parent_id'];
    protected $casts    = [
        'dob' => 'datetime',
    ];

    public function parent()         { return $this->belongsTo(ParentGuardian::class, 'parent_id'); }
    public function schedules()      { return $this->hasMany(Schedule::class); }
    public function vaccineRecords() { return $this->hasMany(VaccineRecord::class); }
    public function payments()       { return $this->hasMany(Payment::class); }

    public function getFullNameAttribute() { return $this->first_name . ' ' . $this->last_name; }
    public function getAgeAttribute() {
        $months = (int) Carbon::parse($this->dob)->diffInMonths(now());
        return $months < 24 ? $months . ' mo' : floor($months/12) . ' yr';
    }
}
