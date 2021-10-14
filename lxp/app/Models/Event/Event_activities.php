<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Mtownsend\ReadTime\ReadTime;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\Media;


/**
 * Class Lesson
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property string $activity_image
 * @property text $short_text
 * @property text $full_text
 * @property integer $position
 * @property tinyInteger $published
 * @property string $downloadable_files
 */
class Event_activities extends Model
{
    use SoftDeletes;

    protected $table = 'event_activities';

    protected $fillable = ['id','title', 'slug', 'activity_image','act_posters', 'short_text', 'full_text', 'sequence', 'published', 'event_id','activity_date','link', 'downloadable_files'];

    protected $appends = ['image'];

    protected $casts = [
        'smes' => 'array',
      ];


    public static function boot()
    {
        parent::boot();
        
        static::deleting(function ($eventact) { // before delete() method call this
            if ($eventact->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $eventact->activity_image))) {
                    File::delete(public_path('/storage/uploads/' . $eventact->activity_image));
                    File::delete(public_path('/storage/uploads/thumb/' . $eventact->activity_image));
                }

                $posters = json_decode($eventact->act_posters);
                foreach ($posters as $item) {
                    if (File::exists(public_path('/storage/uploads/' . $item))) {
                        File::delete(public_path('/storage/uploads/' . $item));
                    }
                }

                $media = $eventact->media;
                foreach ($media as $item) {
                    if (File::exists(public_path('/storage/uploads/' . $item->name))) {
                        File::delete(public_path('/storage/uploads/' . $item->name));
                    }
                }
                $eventact->media()->delete();
            }

        });
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setEventIdAttribute($input)
    {
        $this->attributes['event_id'] = $input ? $input : null;
    }

    
    public function getImageAttribute()
    {
        if ($this->attributes['activity_image'] != NULL) {
            return url('storage/uploads/'.$this->activity_image);
        }
        return NULL;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setSequenceAttribute($input)
    {
        $this->attributes['sequence'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setActivityDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['activity_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['activity_date'] = null;
        }
    }

    public function events()
    {
        return $this->belongsTo(Events::class,'event_id','id');
    }

    public function eventactUsers()
    {
        return $this->belongsToMany(User::class, 'eventact_users','eventact_id','user_id')->withTimestamps();
    }    
    
    public function isCompleted()
    {
        $isCompleted = $this->eventactUsers()->where('user_id', \Auth::id())->count();
        if ($isCompleted > 0) {
            return true;
        }
        return false;
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
    
    public function downloadableMedia()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed', 'eventact_pdf'];

        return $this->morphMany(Media::class, 'model')
            ->whereNotIn('type', $types);
    }

    public function mediaPDF()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('type', '=', 'eventact_pdf');
    }
}
