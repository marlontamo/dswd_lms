<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    protected $table = 'activity_rating';
    protected $guarded=[];
    public $timestamps = true;   
}
