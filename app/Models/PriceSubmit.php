<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceSubmit extends Model
{
    use HasFactory;

    protected $table = 'price_submits';

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

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
