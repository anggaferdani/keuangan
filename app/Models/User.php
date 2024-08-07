<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function jobdesks(){
        return $this->hasMany(Jobdesk::class);
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($permission){
        return $this->role->permissions->contains('name', $permission);
    }

    public function karyawan(){
        return $this->hasOne(Karyawan::class);
    }

    public function priceDevelopers(){
        return $this->hasMany(PriceDeveloper::class);
    }
}
