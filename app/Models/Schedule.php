<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Schedule extends Model {
    use SoftDeletes, Auditable;
    
    protected $fillable = ['child_id','vaccine_id','appointment_date','appointment_time','status','notes','sms_sent'];
    protected $casts    = ['sms_sent' => 'boolean'];
    protected $dates = ['deleted_at'];

    public function child()   { return $this->belongsTo(Child::class); }
    public function vaccine() { return $this->belongsTo(Vaccine::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}
