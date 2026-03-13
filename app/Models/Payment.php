<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Payment extends Model {
    use SoftDeletes, Auditable;
    
    protected $fillable = ['child_id','schedule_id','amount','method','status','payment_date','notes'];
    protected $casts    = ['amount' => 'float'];
    protected $dates = ['deleted_at'];
    
    public function child()    { return $this->belongsTo(Child::class); }
    public function schedule() { return $this->belongsTo(Schedule::class); }
}
