<?php

namespace App\Models\Event;

use App\Models\Event\Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event_categories extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function events(){
        return $this->hasMany(Events::class,'category_id','id');
    }

}
