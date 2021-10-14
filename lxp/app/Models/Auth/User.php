<?php

namespace App\Models\Auth;
use QCod\Gamify\Gamify;
use App\Models\Bundle;
use App\Models\Certificate;
use App\Models\ChapterStudent;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Traits\Uuid;
use App\Models\VideoProgress;
use Illuminate\Support\Collection;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use App\Models\TeacherProfile;
use App\Models\Withdraw;
use Gerardojbaez\Messenger\Contracts\MessageableInterface;
use Gerardojbaez\Messenger\Traits\Messageable;
use Illuminate\Support\Facades\DB;

use App\Models\SwdsessionUser;
use App\Models\Psgc\Province;
use App\Models\Psgc\Municipality;
use App\Models\Event\Events;
use App\Models\Event\Event_activities;
use App\Models\Event\Eventact_users;

/**
 * Class User.
 */
class User extends Authenticatable implements MessageableInterface
{
    use HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Uuid,
        Gamify,
        Messageable;
      use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'username',
        'dob',
        'phone',
        'user_type',
        'position',
        'state', 
        'province', 
        'city',
        'gender',
        'address',
        'city',
        'pincode',
        'state',
        'country',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['last_login_at', 'deleted_at'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name','image'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
    ];

  
    public function reputations()
    {
        return $this->morphMany('QCod\Gamify\Reputation', 'subject');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student');
    }

    public function chapters()
    {
        return $this->hasMany(ChapterStudent::class,'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }


    public function getImageAttribute(){
        return $this->picture;
    }


    //Calc Watch Time
    public function getWatchTime(){
        $watch_time = VideoProgress::where('user_id','=',$this->id)->sum('progress');
        return $watch_time;

    }

    //Check Participation Percentage
    public function getParticipationPercentage(){
        $videos = Media::featured()->where('status','!=',0)->get();
        $count = $videos->count();
        $total_percentage = 0;
        if($count > 0) {
            foreach ($videos as $video) {
                $total_percentage = $total_percentage + $video->getProgressPercentage($this->id);
            }
            $percentage = $total_percentage /$count;
        }else{
            $percentage = 0;
        }
        return round($percentage,2);
    }

    //Get Certificates
    public function certificates(){
        return $this->hasMany(Certificate::class);
    }

    public function purchasedCourses(){
        $courses_id = DB::table('course_student')->where('user_id','=',$this->id)->pluck('course_id');
        $courses = Course::whereIn('id',$courses_id)->get();
        return $courses;
    }

    public function purchases(){
        $purchases = Course::where('published','=',1)->get();
        return $purchases;
    }

    public function findForPassport($user)
    {
        $user = $this->where('email', $user)->first();
        if($user->hasRole('student')){
            return $user;
        }
    }

    /**
     * Get the teacher profile that owns the user.
     */
    public function teacherProfile(){
        return $this->hasOne(TeacherProfile::class);
    }

    /**
    * Get the withdraw owns the teacher.
    */
    public function withdraws(){
        return $this->hasMany(Withdraw::class, 'user_id', 'id');
    }

    public function swdActivities()
    {
        return $this->hasMany(SwdsessionUser::class,'user_id');
    }
    
    public function provinces()
    {
        return $this->belongsTo(Province::class,'province','province_code');
    }

    
    public function municipality()
    {
        return $this->belongsTo(Municipality::class,'city','city_code');
    }

    public function Events()
    {
        return $this->hasMany(Events::class, 'event_participants');
    }    
    
    public function attendedEvents(){
        $event_id = DB::table('event_participants')->where('user_id','=',$this->id)->pluck('event_id');
        $event = Events::whereIn('id',$event_id)->get();
        return $event;
    }
    
    public function eventActivities()
    {
        return $this->hasMany(Eventact_users::class,'user_id');
    }

}
