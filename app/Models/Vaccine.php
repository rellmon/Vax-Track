<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Vaccine extends Model {
    use SoftDeletes, Auditable;
    
    protected $fillable = ['name','type','stock','price','manufacturer','description','active'];
    protected $casts    = ['active' => 'boolean', 'price' => 'float'];
    protected $dates = ['deleted_at'];
    
    public function schedules()      { return $this->hasMany(Schedule::class); }
    public function vaccineRecords() { return $this->hasMany(VaccineRecord::class); }
}
