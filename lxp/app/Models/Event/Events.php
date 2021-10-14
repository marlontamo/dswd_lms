<?php

namespace App\Models\Event;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * Class Events
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property string $event_image
 * @property string $start_date
 * @property tinyInteger $published
 */
class Events extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = ['title', 'slug', 'description', 'event_poster', 'event_image', 'start_date', 'end_date', 'published','category_id'];

    protected $appends = ['image'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($events) { // before delete() method call this
            if ($events->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $events->event_image))) {
                    File::delete(public_path('/storage/uploads/' . $events->event_image));
                    File::delete(public_path('/storage/uploads/thumb/' . $events->event_image));
                }

                $posters = json_decode($events->event_poster);
                foreach ($posters as $item) {
                    if (File::exists(public_path('/storage/uploads/' . $item))) {
                        File::delete(public_path('/storage/uploads/' . $item));
                    }
                }
            }
        });
    }


    public function getImageAttribute()
    {
        if ($this->event_poster != null) {
            return url('storage/uploads/'.$this->event_poster);
        }
        return NULL;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants','event_id','user_id')->withPivot(['reason','office','odsu','org']);
    }

    public function activities()
    {
        return $this->hasMany(Event_activities::class,'event_id','id')->orderBy('sequence','asc');
    }

    public function progress()
    {
        $main_event_activities = $this->activities()->pluck('id');

        $completed_activities = auth()->user()->eventActivities()->where('event_id', $this->id)->pluck('eventact_id');
        if ($completed_activities->count() > 0) {
            return intval($completed_activities->count() / $main_event_activities->count() * 100);
        } else {
            return 0;
        }
    }

    public function category()
    {
        return $this->belongsTo(Event_categories::class,'category_id','id');
    }

}
