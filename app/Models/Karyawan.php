<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected static function booted(){
        static::creating(function($model){
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::saving(function($model){
            $model->updated_by = Auth::id();
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gajis(){
        return $this->hasMany(Gaji::class);
    }

    public function kasbons(){
        return $this->hasMany(Kasbon::class);
    }

    public function reimburses(){
        return $this->hasMany(Reimburse::class);
    }

    public function tunjanganHariRayas(){
        return $this->hasMany(TunjanganHariRaya::class);
    }
}
