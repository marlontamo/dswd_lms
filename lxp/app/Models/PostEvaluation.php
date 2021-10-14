<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostEvaluation extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'pes_id';
    protected $fillable = ['title','description','date_created','created_by'];

    protected $casts = [
        'prerequisite' => 'array',
    ];

    protected $table = 'post_evaluation_survey';

    protected $guarded = ['pes_id'];

}
