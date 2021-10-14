<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class ParticipantGroupModel extends Model
{
    protected $table = 'participant_group';
    //protected $guarded=[];
    protected $fillable = [
                              
                              'title'
                            ];
    public $timestamps = TRUE;
    
}
