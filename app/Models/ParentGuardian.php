<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ParentGuardian extends Model {
    protected $table    = 'parent_guardians';
    protected $fillable = ['first_name','last_name','phone','email','address','username','password'];
    protected $hidden   = ['password'];

    public function children() { return $this->hasMany(Child::class, 'parent_id'); }
    public function getFullNameAttribute() { return $this->first_name . ' ' . $this->last_name; }
}
