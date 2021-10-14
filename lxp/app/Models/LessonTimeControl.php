<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class LessonTimeControl extends Model
{
	protected $table = 'lesson_time_control';
	protected $fillable = ['user_id','lesson_id','time_first_visit','time_stop','time_spent'];

}
