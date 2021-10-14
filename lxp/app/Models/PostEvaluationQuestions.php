<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostEvaluationQuestions extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'peq_id';
    protected $fillable = ['question','sme','date_created','added_by'];

    protected $casts = [
        'prerequisite' => 'array',
    ];

    protected $table = 'post_evaluation_questions';

    protected $guarded = ['peq_id'];

}
