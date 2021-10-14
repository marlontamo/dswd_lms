<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostEvaluationSurveyQuestions extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'pesq_id';
    protected $fillable = ['pes_id','peq_id','date_created','added_by'];

    protected $casts = [
        'prerequisite' => 'array',
    ];

    protected $table = 'post_evaluation_survey_questions';

    protected $guarded = ['pesq_id'];

}
