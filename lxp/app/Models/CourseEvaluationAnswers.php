<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEvaluationAnswers extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'pea_id';
    protected $fillable = ['course_id','user_id','pes_id','peq_id','question','answer','date_created'];

    protected $casts = [
        'prerequisite' => 'array',
    ];

    protected $table = 'course_evaluation_answers';

    protected $guarded = ['pea_id'];

}
