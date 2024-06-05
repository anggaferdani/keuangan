<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

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

    public function statusBelongsTo(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function endUser(){
        return $this->belongsTo(EndUser::class, 'end_user_id');
    }

    public function priceSubmits(){
        return $this->hasMany(PriceSubmit::class);
    }

    public function priceDevelopers(){
        return $this->hasMany(PriceDeveloper::class);
    }

    public function paidProjects(){
        return $this->hasMany(PaidProject::class);
    }
}
