<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobdesk extends Model
{
    use HasFactory;

    protected $table = 'jobdesks';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function statusBelongsTo(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
