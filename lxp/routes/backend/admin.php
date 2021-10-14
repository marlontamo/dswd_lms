<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Auth\User\AccountController;
use App\Http\Controllers\Backend\Auth\User\ProfileController;
use \App\Http\Controllers\Backend\Auth\User\UpdatePasswordController;
use \App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Admin\PostEvalController;
use App\Http\Controllers\Backend\Admin\PostEvalQuestionController;
use App\User;
/*
 * All route names are prefixed with 'admin.'.
 */

Route::group(['middleware' => 'preventBackHistory'], function() {
    //===== General Routes =====//
    Route::redirect('/', '/user/dashboard', 301);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::group(['middleware' => 'role:teacher|superadmin|admin'], function () {
        Route::resource('enrollees', 'EnrolledController');
        Route::get('get-enrollees-data', ['uses' => 'EnrolledController@getData', 'as' => 'enrollees.get_data']);
        Route::get('get-courses', ['uses' => 'EnrolledController@getCourses', 'as' => 'enrollees.get_courses']);
        Route::get('enrollees_test_result', ['uses' => 'EnrolledController@getTestResult', 'as' => 'enrollees.test_answers']);
    });
    Route::group(['middleware' => 'role:superadmin|admin'], function () {

        //===== Event Routes =====//
        Route::resource('event', 'Admin\EventController');
        // Route::post('save_event', 'Admin\EventController@store');
        Route::post('save_event', 'Admin\EventController@store');


        //===== Teachers Routes =====//
        Route::resource('teachers', 'Admin\TeachersController');
        Route::get('get-teachers-data', ['uses' => 'Admin\TeachersController@getData', 'as' => 'teachers.get_data']);
        Route::post('teachers_mass_destroy', ['uses' => 'Admin\TeachersController@massDestroy', 'as' => 'teachers.mass_destroy']);
        Route::post('teachers_restore/{id}', ['uses' => 'Admin\TeachersController@restore', 'as' => 'teachers.restore']);
        Route::delete('teachers_perma_del/{id}', ['uses' => 'Admin\TeachersController@perma_del', 'as' => 'teachers.perma_del']);
        Route::post('teacher/status', ['uses' => 'Admin\TeachersController@updateStatus', 'as' => 'teachers.status']);


        //===== FORUMS Routes =====//
        Route::resource('forums-category', 'Admin\ForumController');
        Route::get('forums-category/status/{id}', 'Admin\ForumController@status')->name('forums-category.status');


        //===== Settings Routes =====//
        Route::get('settings/general', ['uses' => 'Admin\ConfigController@getGeneralSettings', 'as' => 'general-settings']);

        Route::post('settings/general', ['uses' => 'Admin\ConfigController@saveGeneralSettings'])->name('general-settings');

        // Route::get('settings/social', ['uses' => 'Admin\ConfigController@getSocialSettings'])->name('social-settings');

        // Route::post('settings/social', ['uses' => 'Admin\ConfigController@saveSocialSettings'])->name('social-settings');

        Route::get('contact', ['uses' => 'Admin\ConfigController@getContact'])->name('contact-settings');

        Route::get('footer', ['uses' => 'Admin\ConfigController@getFooter'])->name('footer-settings');


        //===== Slider Routes =====/
        Route::resource('sliders', 'Admin\SliderController');
        Route::get('sliders/status/{id}', 'Admin\SliderController@status')->name('sliders.status', 'id');
        Route::post('sliders/save-sequence', ['uses' => 'Admin\SliderController@saveSequence', 'as' => 'sliders.saveSequence']);
        Route::post('sliders/status', ['uses' => 'Admin\SliderController@updateStatus', 'as' => 'sliders.status']);


        //===== Sponsors Routes =====//
        Route::resource('sponsors', 'Admin\SponsorController');
        Route::get('get-sponsors-data', ['uses' => 'Admin\SponsorController@getData', 'as' => 'sponsors.get_data']);
        Route::post('sponsors_mass_destroy', ['uses' => 'Admin\SponsorController@massDestroy', 'as' => 'sponsors.mass_destroy']);
        Route::get('sponsors/status/{id}', 'Admin\SponsorController@status')->name('sponsors.status', 'id');
        Route::post('sponsors/status', ['uses' => 'Admin\SponsorController@updateStatus', 'as' => 'sponsors.status']);

        //===== Expertise Routes =====//
        Route::group(['prefix' => 'expertise'], function () {
            Route::get('/create', 'Admin\ExpertiseController@create');
            Route::post('/create', 'Admin\ExpertiseController@store');
            Route::get('delete/{id}', 'Admin\ExpertiseController@destroy')->name('expertise.delete');
            Route::get('edit/{id}', 'Admin\ExpertiseController@edit')->name('expertise.edit');
            Route::post('edit/{id}', 'Admin\ExpertiseController@update');
            Route::get('view/{id}', 'Admin\ExpertiseController@show');
        });
        Route::resource('expertise', 'Admin\ExpertiseController');
        Route::get('get-expertise-data', ['uses' => 'Admin\ExpertiseController@getData', 'as' => 'expertise.get_data']);
        // Route::get('get-sponsors-data', ['uses' => 'Admin\SponsorController@getData', 'as' => 'sponsors.get_data']);
        // Route::post('sponsors_mass_destroy', ['uses' => 'Admin\SponsorController@massDestroy', 'as' => 'sponsors.mass_destroy']);
        // Route::get('sponsors/status/{id}', 'Admin\SponsorController@status')->name('sponsors.status', 'id');
        // Route::post('sponsors/status', ['uses' => 'Admin\SponsorController@updateStatus', 'as' => 'sponsors.status']);

        //===== FAQs Routes =====//
        Route::resource('faqs', 'Admin\FaqController');
        Route::get('get-faqs-data', ['uses' => 'Admin\FaqController@getData', 'as' => 'faqs.get_data']);
        Route::post('faqs_mass_destroy', ['uses' => 'Admin\FaqController@massDestroy', 'as' => 'faqs.mass_destroy']);
        Route::get('faqs/status/{id}', 'Admin\FaqController@status')->name('faqs.status');
        Route::post('faqs/status', ['uses' => 'Admin\FaqController@updateStatus', 'as' => 'faqs.status']);


        //====== Contacts Routes =====//
        Route::resource('contact-requests', 'ContactController');
        Route::get('get-contact-requests-data', ['uses' => 'ContactController@getData', 'as' => 'contact_requests.get_data']);

        //==== Remove Locale FIle ====//
        // Route::post('delete-locale', function () {
        //     \Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

        //     \Illuminate\Support\Facades\File::deleteDirectory(public_path('../resources/lang/' . request('locale')));
        // })->name('delete-locale');


        //==== Update Theme Routes ====//
        Route::get('update-theme', 'UpdateController@index')->name('update-theme');
        Route::post('update-theme', 'UpdateController@updateTheme')->name('update-files');
        Route::post('list-files', 'UpdateController@listFiles')->name('list-files');

        //===Trouble shoot ====//
        Route::get('troubleshoot', 'Admin\ConfigController@troubleshoot')->name('troubleshoot');


        //==== API Clients Routes ====//
        // Route::prefix('api-client')->group(function () {
        //     Route::get('all', 'Admin\ApiClientController@all')->name('api-client.all');
        //     Route::post('generate', 'Admin\ApiClientController@generate')->name('api-client.generate');
        //     Route::post('status', 'Admin\ApiClientController@status')->name('api-client.status');
        // });


        //==== Sitemap Routes =====//
        Route::get('sitemap', 'SitemapController@getIndex')->name('sitemap.index');
        Route::post('sitemap', 'SitemapController@saveSitemapConfig')->name('sitemap.config');
        Route::get('sitemap/generate', 'SitemapController@generateSitemap')->name('sitemap.generate');


        // Route::post('translations/locales/add', 'LangController@postAddLocale');
        // Route::post('translations/locales/remove', 'LangController@postRemoveLocaleFolder')->name('delete-locale-folder');

    });


    //Common - Shared Routes for Teacher and Super Administrator
    Route::group(['middleware' => 'role:superadmin|teacher|admin'], function () {

        //====== Reports Routes =====//
        Route::get('report/sales', ['uses' => 'ReportController@getSalesReport', 'as' => 'reports.sales']);
        Route::get('report/students', ['uses' => 'ReportController@getStudentsReport', 'as' => 'reports.students']);

        Route::get('get-course-reports-data', ['uses' => 'ReportController@getCourseData', 'as' => 'reports.get_course_data']);
        Route::get('get-bundle-reports-data', ['uses' => 'ReportController@getBundleData', 'as' => 'reports.get_bundle_data']);
        Route::get('get-students-reports-data', ['uses' => 'ReportController@getStudentsData', 'as' => 'reports.get_students_data']);

        Route::get('menu-manager', ['uses' => 'MenuController@index'])->name('menu-manager');
    });

    Route::group(['middleware' => 'role:superadmin|admin'], function () {

        //====== Reports Routes =====//
        Route::get('post-evaluation-survey', [PostEvalController::class, 'index'])->name('post-evaluation-survey');
        // Route::get('get-postevaluation-data', ['uses' => 'PostEvalController@getPostEvalData', 'as' => 'postevaluation.get_posteval_data']);
        Route::get('get-postevaluation-data', [PostEvalController::class, 'getPostEvalData'])->name('postevaluation.get_posteval_data');
        Route::get('add-posteval', [PostEvalController::class, 'create'])->name('postevaluation.add_posteval');
        Route::post('store-posteval', [PostEvalController::class, 'store'])->name('postevaluation.store_posteval');
        Route::get('edit-posteval/{id}', [PostEvalController::class, 'edit'])->name('postevaluation.edit_posteval');
        Route::post('update-posteval/{id}', [PostEvalController::class, 'update'])->name('postevaluation.update_posteval');
        Route::get('remove-posteval/{id}', [PostEvalController::class, 'destroy'])->name('postevaluation.remove_posteval');


        //post evaluation questions
        Route::get('post-evaluation-questions', [PostEvalQuestionController::class, 'index'])->name('post-evaluation-questions');
        Route::get('get-postevaluationquestion-data', [PostEvalQuestionController::class, 'getPostEvalQuestionData'])->name('postevaluationquestion.get_postevalquestion_data');
        Route::get('add-postevalquestion', [PostEvalQuestionController::class, 'create'])->name('postevaluationquestion.add_postevalquestion');

        Route::post('store-postevalquestion', [PostEvalQuestionController::class, 'store'])->name('postevaluationquestion.store_postevalquestion');
        Route::get('edit-postevalquestion/{id}', [PostEvalQuestionController::class, 'edit'])->name('postevaluationquestion.edit_postevalquestion');
        Route::post('update-postevalquestion/{id}', [PostEvalQuestionController::class, 'update'])->name('postevaluationquestion.update_postevalquestion');
        Route::get('remove-postevalquestion/{id}', [PostEvalQuestionController::class, 'destroy'])->name('postevaluationquestion.remove_postevalquestion');


    });



    //===== Categories Routes =====//
    Route::resource('categories', 'Admin\CategoriesController');
    Route::get('get-categories-data', ['uses' => 'Admin\CategoriesController@getData', 'as' => 'categories.get_data']);
    Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
    Route::post('categories_restore/{id}', ['uses' => 'Admin\CategoriesController@restore', 'as' => 'categories.restore']);
    Route::delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoriesController@perma_del', 'as' => 'categories.perma_del']);

    // Video Routes

    Route::resource('video', 'Admin\VideoController');




    //===== Courses Routes =====//
    Route::resource('courses', 'Admin\CoursesController');
    Route::get('get-courses-data', ['uses' => 'Admin\CoursesController@getData', 'as' => 'courses.get_data']);
    Route::post('courses_mass_destroy', ['uses' => 'Admin\CoursesController@massDestroy', 'as' => 'courses.mass_destroy']);
    Route::post('courses_restore/{id}', ['uses' => 'Admin\CoursesController@restore', 'as' => 'courses.restore']);
    Route::delete('courses_perma_del/{id}', ['uses' => 'Admin\CoursesController@perma_del', 'as' => 'courses.perma_del']);
    Route::post('course-save-sequence', ['uses' => 'Admin\CoursesController@saveSequence', 'as' => 'courses.saveSequence']);
    Route::get('course-publish/{id}', ['uses' => 'Admin\CoursesController@publish', 'as' => 'courses.publish']);


    //===== Lessons Routes =====//
    Route::resource('lessons', 'Admin\LessonsController');
    Route::get('get-lessons-data', ['uses' => 'Admin\LessonsController@getData', 'as' => 'lessons.get_data']);
    Route::post('lessons_mass_destroy', ['uses' => 'Admin\LessonsController@massDestroy', 'as' => 'lessons.mass_destroy']);
    Route::post('lessons_restore/{id}', ['uses' => 'Admin\LessonsController@restore', 'as' => 'lessons.restore']);
    Route::delete('lessons_perma_del/{id}', ['uses' => 'Admin\LessonsController@perma_del', 'as' => 'lessons.perma_del']);


    //===== Questions Routes =====//
    Route::resource('questions', 'Admin\QuestionsController');
    Route::get('get-questions-data', ['uses' => 'Admin\QuestionsController@getData', 'as' => 'questions.get_data']);
    Route::post('questions_mass_destroy', ['uses' => 'Admin\QuestionsController@massDestroy', 'as' => 'questions.mass_destroy']);
    Route::post('questions_restore/{id}', ['uses' => 'Admin\QuestionsController@restore', 'as' => 'questions.restore']);
    Route::delete('questions_perma_del/{id}', ['uses' => 'Admin\QuestionsController@perma_del', 'as' => 'questions.perma_del']);


    //===== Questions Options Routes =====//
    Route::resource('questions_options', 'Admin\QuestionsOptionsController');
    Route::get('get-qo-data', ['uses' => 'Admin\QuestionsOptionsController@getData', 'as' => 'questions_options.get_data']);
    Route::post('questions_options_mass_destroy', ['uses' => 'Admin\QuestionsOptionsController@massDestroy', 'as' => 'questions_options.mass_destroy']);
    Route::post('questions_options_restore/{id}', ['uses' => 'Admin\QuestionsOptionsController@restore', 'as' => 'questions_options.restore']);
    Route::delete('questions_options_perma_del/{id}', ['uses' => 'Admin\QuestionsOptionsController@perma_del', 'as' => 'questions_options.perma_del']);


    //===== Tests Routes =====//
    Route::resource('tests', 'Admin\TestsController');
    Route::get('get-tests-data', ['uses' => 'Admin\TestsController@getData', 'as' => 'tests.get_data']);
    Route::post('tests_mass_destroy', ['uses' => 'Admin\TestsController@massDestroy', 'as' => 'tests.mass_destroy']);
    Route::post('tests_restore/{id}', ['uses' => 'Admin\TestsController@restore', 'as' => 'tests.restore']);
    Route::delete('tests_perma_del/{id}', ['uses' => 'Admin\TestsController@perma_del', 'as' => 'tests.perma_del']);

    //===== Events Routes =====//
    Route::resource('events', 'Admin\EventController');
    Route::get('get-events-data', ['uses' => 'Admin\EventController@getData', 'as' => 'events.get_data']);
    Route::post('event_mass_destroy', ['uses' => 'Admin\EventController@massDestroy', 'as' => 'event.mass_destroy']);
    Route::post('event_restore/{id}', ['uses' => 'Admin\EventController@restore', 'as' => 'event.restore']);
    Route::delete('event_perma_del/{id}', ['uses' => 'Admin\EventController@perma_del', 'as' => 'event.perma_del']);
    Route::get('event-publish/{id}', ['uses' => 'Admin\EventController@publish', 'as' => 'event.publish']);

    Route::get('eventparticipants', ['uses' => 'Admin\EventController@participants', 'as' => 'eventparticipants']);
    Route::get('get-event-data', ['uses' => 'Admin\EventController@getParticipants', 'as' => 'event.get_participants']);

    Route::get('eventcategory', ['uses' => 'Admin\EventController@category', 'as' => 'eventcategory']);
    Route::get('get-eventcat-data', ['uses' => 'Admin\EventController@getCatData', 'as' => 'event.get_cat_data']);
    Route::post('eventcat_mass_destroy', ['uses' => 'Admin\EventController@cat_massDestroy', 'as' => 'event.cat_mass_destroy']);
    Route::post('eventcat_restore/{id}', ['uses' => 'Admin\EventController@cat_restore', 'as' => 'eventcategory.restore']);
    Route::post('eventcat_perma_del/{id}', ['uses' => 'Admin\EventController@cat_perma_del', 'as' => 'eventcategory.perma_del']);

    Route::get('eventcat_edit/{id}', ['uses' => 'Admin\EventController@cat_edit', 'as' => 'event.cat_edit']);
    Route::put('eventcat_update/{id}', ['uses' => 'Admin\EventController@cat_update', 'as' => 'event.cat_update']);

    Route::get('eventcat_create', ['uses' => 'Admin\EventController@cat_create', 'as' => 'event.cat_create']);
    Route::post('eventcat_store', ['uses' => 'Admin\EventController@cat_store', 'as' => 'event.cat_store']);

    Route::delete('eventcat_destroy/{id}', ['uses' => 'Admin\EventController@cat_destroy', 'as' => 'event.cat_destroy']);

    Route::delete('eventcat_perma_del/{id}', ['uses' => 'Admin\EventController@cat_perma_del', 'as' => 'event.cat_perma_del']);

    Route::resource('eventacts','Admin\EventActController');
    Route::get('get-acts-data', ['uses' => 'Admin\EventActController@getData', 'as' => 'eventacts.get_data']);
    Route::post('eventact_mass_destroy', ['uses' => 'Admin\EventActController@massDestroy', 'as' => 'eventacts.mass_destroy']);
    Route::post('eventact_restore/{id}', ['uses' => 'Admin\EventActController@restore', 'as' => 'eventacts.restore']);
    Route::delete('eventact_perma_del/{id}', ['uses' => 'Admin\EventActController@perma_del', 'as' => 'eventacts.perma_del']);

    
    Route::get('downloadCourseExcel/{id}', ['uses' => 'Admin\CoursesController@downloadExcel', 'as' => 'course.downloadExcel']);

    Route::get('downloadExcel/{id}', ['uses' => 'Admin\EventActController@downloadExcel', 'as' => 'eventacts.downloadExcel']);
    Route::get('dlAttendance/{id}', ['uses' => 'Admin\EventActController@dlAttendance', 'as' => 'eventacts.dlAttendance']);



    //===== Media Routes =====//
    Route::post('media/remove', ['uses' => 'Admin\MediaController@destroy', 'as' => 'media.destroy']);


    //===== User Account Routes =====//
    Route::group(['middleware' => ['auth', 'password_expires']], function () {
        Route::get('account', [AccountController::class, 'index'])->name('account');
        Route::patch('account/{email?}', [UserPasswordController::class, 'update'])->name('account.post');
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });


    Route::group(['middleware' => 'role:teacher'], function () {
        //====== Review Routes =====//
        Route::resource('reviews', 'ReviewController');
        Route::get('get-reviews-data', ['uses' => 'ReviewController@getData', 'as' => 'reviews.get_data']);
    });


    Route::group(['middleware' => 'role:student'], function () {

        //==== Certificates ====//
        Route::get('certificates', 'CertificateController@getCertificates')->name('certificates.index');
        Route::post('certificates/generate', 'CertificateController@generateCertificate')->name('certificates.generate');
        Route::get('certificates/download', ['uses' => 'CertificateController@download', 'as' => 'certificates.download']);

        Route::get('certificates/test', 'CertificateController@testCertificate')->name('certificates.test');
    });


    //==== Messages Routes =====//
    Route::get('messages', ['uses' => 'MessagesController@index', 'as' => 'messages']);
    Route::post('messages/getData', ['uses' => 'MessagesController@getData', 'as' => 'messages.getData']);
    Route::post('messages/unread', ['uses' => 'MessagesController@getUnreadMessages', 'as' => 'messages.unread']);
    Route::post('messages/send', ['uses' => 'MessagesController@send', 'as' => 'messages.send']);
    Route::post('messages/reply', ['uses' => 'MessagesController@reply', 'as' => 'messages.reply']);


    //======= Blog Routes =====//
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/create', 'Admin\BlogController@create');
        Route::post('/create', 'Admin\BlogController@store');
        Route::get('delete/{id}', 'Admin\BlogController@destroy')->name('blogs.delete');
        Route::get('edit/{id}', 'Admin\BlogController@edit')->name('blogs.edit');
        Route::post('edit/{id}', 'Admin\BlogController@update');
        Route::get('view/{id}', 'Admin\BlogController@show');
        //        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
        Route::post('{id}/storecomment', 'Admin\BlogController@storeComment')->name('storeComment');
    });
    Route::resource('blogs', 'Admin\BlogController');
    Route::get('get-blogs-data', ['uses' => 'Admin\BlogController@getData', 'as' => 'blogs.get_data']);
    Route::post('blogs_mass_destroy', ['uses' => 'Admin\BlogController@massDestroy', 'as' => 'blogs.mass_destroy']);


    //======= Pages Routes =====//
    Route::resource('pages', 'Admin\PageController');
    Route::get('get-pages-data', ['uses' => 'Admin\PageController@getData', 'as' => 'pages.get_data']);
    Route::post('pages_mass_destroy', ['uses' => 'Admin\PageController@massDestroy', 'as' => 'pages.mass_destroy']);
    Route::post('pages_restore/{id}', ['uses' => 'Admin\PageController@restore', 'as' => 'pages.restore']);
    Route::delete('pages_perma_del/{id}', ['uses' => 'Admin\PageController@perma_del', 'as' => 'pages.perma_del']);
});