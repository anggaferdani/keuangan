<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reimburse extends Model
{
    use HasFactory;

    protected $table = 'reimburses';

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

    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function file(){
        return $this->belongsTo(File::class, 'file_id');
    }
}
