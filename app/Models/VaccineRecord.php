<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class VaccineRecord extends Model {
    use SoftDeletes, Auditable;
    
    protected $fillable = ['child_id','vaccine_id','date_given','dose_number','notes','administered_by'];
    protected $casts    = [
        'date_given' => 'datetime',
    ];
    
    public function child()   { return $this->belongsTo(Child::class); }
    public function vaccine() { return $this->belongsTo(Vaccine::class); }
}
