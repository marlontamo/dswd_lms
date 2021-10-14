<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\PsgcController;
use App\Models\Auth\User;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Frontend\Activity;
/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */
// Route::get('/tester',function(){
//     $path = storage_path('storage/public/uploads');
//     dd($path);
// });
/**
 *$routes for activity
 */
Route::group(['middleware' => 'auth'], function (){
        Route::get('activityParticipant/{id}', 'Frontend\ActivityController@activityParticipant')->name('activity.Participant');
        Route::get('singleact/{id?}', 'Frontend\ActivityController@singleActivity')->name('singleactivity');
        Route::get('report', 'Frontend\ActivityController@report')->name('report');
        Route::get('view/{id}', 'Frontend\ActivityController@test')->name('viewActivity');
        Route::get('/participants', 'Frontend\ActivityController@participants')->name('participants');
        Route::get('/fetch', 'Frontend\ActivityController@fetchall');
        Route::get('/act/{id?}', 'Frontend\ActivityController@get_full_detail');
        Route::get('/delete/{id}', 'Frontend\ActivityController@destroy')->name('delete-activity');
        Route::get('/edit/{id}', 'Frontend\ActivityController@edit')->name('edit-activity');

        Route::get('/activities', 'Frontend\ActivityController@activityList');
        Route::get('/table_view','Frontend\ActivityController@table_view');
        Route::get('/part/{id}', 'Frontend\ActivityController@get_all_participants');
        Route::POST('/add_participant', 'Frontend\ActivityController@add_participants');
        Route::get('/activity', 'Frontend\ActivityController@index');
        Route::get('/detail', 'Frontend\ActivityController@view_detail');

        Route::post('/save_rating','Frontend\ActivityController@save_activity_rating');
        Route::post('/activity_detail_LDS', 'Frontend\ActivityController@activity_detail_LDS');
        Route::post('/activity_detail_CBS', 'Frontend\ActivityController@activity_detail_CBS');
        Route::post('/create_activity', 'Frontend\ActivityController@createActivity');
        Route::post('/activity_detail', 'Frontend\ActivityController@activity_detail');
        Route::post('/actual_number', 'Frontend\ActivityController@record_actual_number')->name('actual_number');
        Route::post('/city/','Frontend\ActivityController@get_city')->name('getcity');
});

/**
 *$routes end for activity
 */
Route::get('/sitemap-' . str_slug(config('app.name')) . '/{file?}', 'SitemapController@index');


//Route to clean up demo site
Route::get('reset-demo', function () {
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 1000);
    try {
        \Illuminate\Support\Facades\Artisan::call('refresh:site');
        return 'Refresh successful!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});



/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__ . '/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__ . '/backend/');
});

Route::group(['namespace' => 'Backend', 'prefix' => 'user', 'as' => 'admin.', 'middleware' => 'auth'], function () {

    //==== Messages Routes =====//

    Route::get('messages', ['uses' => 'MessagesController@index', 'as' => 'messages']);
    Route::get('messages/notification', ['uses' => 'MessagesController@getNotification', 'as' => 'messages.notification']);
    Route::post('messages/unread', ['uses' => 'MessagesController@getUnreadMessages', 'as' => 'messages.unread']);
    Route::post('messages/send', ['uses' => 'MessagesController@send', 'as' => 'messages.send']);
    Route::post('messages/reply', ['uses' => 'MessagesController@reply', 'as' => 'messages.reply']);

    Route::post('messages/getData', ['uses' => 'MessagesController@getData', 'as' => 'messages.getData']);
    Route::get('notification', ['uses' => 'MessagesController@notificationList', 'as' => 'notificationList']);
    Route::get('getNotificationList', ['uses' => 'MessagesController@getNotificationList', 'as' => 'getNotificationList']);
    Route::post('deleteNotification', ['uses' => 'MessagesController@deleteNotification', 'as' => 'notification.delete']);
    
    
});

Route::get('certificates', 'CertificateController@getCertificates')->name('certificates.index');
Route::post('certificates/generate', 'CertificateController@generateCertificate')->name('certificates.generate');

Route::get('category/{category}/blogs', 'BlogController@getByCategory')->name('blogs.category');
Route::get('tag/{tag}/blogs', 'BlogController@getByTag')->name('blogs.tag');
Route::get('blog/{slug?}', 'BlogController@getIndex')->name('blogs.index');
Route::post('blog/{id}/comment', 'BlogController@storeComment')->name('blogs.comment');
Route::get('blog/comment/delete/{id}', 'BlogController@deleteComment')->name('blogs.comment.delete');

Route::get('teachers', 'Frontend\HomeController@getTeachers')->name('teachers.index');
Route::get('teachers/{id}/show', 'Frontend\HomeController@showTeacher')->name('teachers.show');

Route::get('expertise', 'Frontend\HomeController@getExpertise')->name('expertise.index');
Route::get('expertise/{id}/show', 'Frontend\HomeController@showExpertise')->name('expertise.show');

//============Course Routes=================//
Route::get('courses', ['uses' => 'CoursesController@all', 'as' => 'courses.all']);
Route::get('course/{slug}', ['uses' => 'CoursesController@show', 'as' => 'courses.show']);
Route::post('course/{course_id}/rating', ['uses' => 'CoursesController@rating', 'as' => 'courses.rating']);
Route::get('category/{category}/courses', ['uses' => 'CoursesController@getByCategory', 'as' => 'courses.category']);
Route::post('courses/{id}/review', ['uses' => 'CoursesController@addReview', 'as' => 'courses.review']);
Route::get('courses/review/{id}/edit', ['uses' => 'CoursesController@editReview', 'as' => 'courses.review.edit']);
Route::post('courses/review/{id}/edit', ['uses' => 'CoursesController@updateReview', 'as' => 'courses.review.update']);
Route::get('courses/review/{id}/delete', ['uses' => 'CoursesController@deleteReview', 'as' => 'courses.review.delete']);


//============EVENTS Routes=================//
Route::get('events', ['uses' => 'EventController@index', 'as' => 'event.index']);
Route::get('events/{slug}', ['uses' => 'EventController@show', 'as' => 'event.show']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('lesson/{course_id}/{slug}/', ['uses' => 'LessonsController@show', 'as' => 'lessons.show']);
    Route::post('lesson/{slug}/test', ['uses' => 'LessonsController@test', 'as' => 'lessons.test']);
    Route::post('lesson/{slug}/retest', ['uses' => 'LessonsController@retest', 'as' => 'lessons.retest']);
    Route::post('video/progress', 'LessonsController@videoProgress')->name('update.videos.progress');
    Route::post('video/complete', 'LessonsController@videoCompleted')->name('get.video.competed');
    Route::post('lesson/progress', 'LessonsController@courseProgress')->name('update.course.progress');
    Route::post('lesson/timecontrol', 'LessonsController@timeControl')->name('update.time.control');


    Route::post('events/register', ['uses' => 'EventController@register', 'as' => 'event.register']);
    Route::post('events/eventactProgress', ['uses' => 'EventController@eventactProgress', 'as' => 'event.eventactProgress']);
    Route::post('events/surveyQuestions', ['uses' => 'EventController@surveyQuestions', 'as' => 'event.surveyQuestions']);
    Route::post('events/saveSurvey', ['uses' => 'EventController@saveSurvey', 'as' => 'event.saveSurvey']);


    Route::get('downloadeventfile', ['uses' => 'EventController@getDownload', 'as' => 'downloadeventfile']);


    Route::post('course/surveyQuestions', ['uses' => 'LessonsController@surveyQuestions', 'as' => 'course.surveyQuestions']);
    Route::post('course/saveSurvey', ['uses' => 'LessonsController@saveSurvey', 'as' => 'course.saveSurvey']);
});
//Route::post('lesson/progress', [LessonsController::class, 'courseProgress'])->name('update.course.progress');
// Route::get('lesson/timecontrol', [LessonsController::class,'timeControl'])->name('update.time.control');
//Route::get('lesson/timecontrol', ['uses' => 'LessonsController@timeControl', 'as' => 'update.time.control']);
Route::get('/search', [HomeController::class, 'searchCourse'])->name('search');
Route::get('/search-course', [HomeController::class, 'searchCourse'])->name('search-course');
Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');

Route::post('course/getnow', ['uses' => 'CoursesController@getNow', 'as' => 'course.getnow']);

Route::get('/faqs', 'Frontend\HomeController@getFaqs')->name('faqs');


/*=============== Theme blades routes ends ===================*/

Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::get('contact', 'Frontend\ContactController@index')->name('contact');
    Route::post('contact/send', 'Frontend\ContactController@send')->name('contact.send');
    Route::post('contact/sendToExpertise', 'Frontend\ContactController@sendToExpertise')->name('contact.sendToExpertise');
});


Route::get('download', ['uses' => 'Frontend\HomeController@getDownload', 'as' => 'download']);

//============= Menu  Manager Routes ===============//
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => config('menu.middleware')], function () {
    //Route::get('wmenuindex', array('uses'=>'\Harimayco\Menu\Controllers\MenuController@wmenuindex'));
    Route::post('add-custom-menu', 'MenuController@addcustommenu')->name('haddcustommenu');
    Route::post('delete-item-menu', 'MenuController@deleteitemmenu')->name('hdeleteitemmenu');
    Route::post('delete-menug', 'MenuController@deletemenug')->name('hdeletemenug');
    Route::post('create-new-menu', 'MenuController@createnewmenu')->name('hcreatenewmenu');
    Route::post('generate-menu-control', 'MenuController@generatemenucontrol')->name('hgeneratemenucontrol');
    Route::post('update-item', 'MenuController@updateitem')->name('hupdateitem');
    Route::post('save-custom-menu', 'MenuController@saveCustomMenu')->name('hcustomitem');
    Route::post('change-location', 'MenuController@updateLocation')->name('update-location');
});

Route::get('certificate-verification', 'Backend\CertificateController@getVerificationForm')->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', 'Backend\CertificateController@verifyCertificate')->name('frontend.certificates.verify');
Route::get('certificates/download', ['uses' => 'Backend\CertificateController@download', 'as' => 'certificates.download']);


Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('/{page?}', [HomeController::class, 'index'])->name('index');
});

Route::get('check/session', [LoginController::class, 'checkSingleSession'])->name('check.session');
Route::get('get/car', [PsgcController::class, 'getCarData'])->name('get.car');
Route::get('get/profloc', [PsgcController::class, 'getProfLocation'])->name('get.profloc');
Route::get('get/regions', [PsgcController::class, 'getRegions'])->name('get.regions');
Route::get('get/province', [PsgcController::class, 'getProvinces'])->name('get.province');
Route::get('get/municipalities', [PsgcController::class, 'getMunicipalities'])->name('get.municipalities');
Route::post('get/barangays', [PsgcController::class, 'getBarangays'])->name('get.barangays');

Route::post('logout/others', [LoginController::class, 'logout_others'])->name('logout.others');
