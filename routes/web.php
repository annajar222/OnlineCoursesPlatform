<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*----------------------------------------------------------------------------------------
                                        THE LANDING PAGE.
*/

// In this route we just say: return the 'landing' page.
Route::get('/', function () {
    return view('welcome');
});

// With this route we can post the user email with the help of the contact form in the landing page.
Route::post('/','App\Http\Controllers\EmailController@index')->name('send.mail');
/* ---------------------------------------------END OF LANDING PAGE ROUTES----------------------------------------------*/


/*----------------------------------------------------------------------------------------
                                        IF USER CONNECTED/LOGGEDIN
                                                    THEN:
*/
Route::group(['auth:sanctum','verified'],function(){
    
    
/*----------------------------------------------------------------------------------------
                                        MANAGE DASHBOARDS*/

    // Simply Redirect the user to the right dashboard, if user is admin:AdminDashboard else normalUser:Dashboard
    Route::get('/dashboard','App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
/* ---------------------------------------------END OF MANAGE DASHBOARDS ROUTES----------------------------------------------*/




/*----------------------------------------------------------------------------------------
                                        MANAGE COURSES
*/

    //Create a new course.
    Route::get('/new-course','App\Http\Controllers\CourseController@newCourse')->name('courses.create');



    
    // Get all courses by index function in the CourseController.
    Route::get('/Courses','App\Http\Controllers\CourseController@index')->name('courses.index');
    


    // Simply show the course that has the id - {id} using the show function in the CourseController.
    Route::get('/Course/{id}','App\Http\Controllers\CourseController@show')->name('courses.show');
    


/* 
        Now in this route we just say if the user clicked the button (by the button I mean the progressButton componen),
        you make a post request to the CourseController in the toggleProgress function.
*/
    Route::post('/toggleProgress','App\Http\Controllers\CourseController@toggleProgress')->name('courses.toggleProgress');
    


    // In this route we just submit a new course to the store function.
    Route::post('/Courses','App\Http\Controllers\CourseController@store'); 
    
    
    
    //Now before the update we need to get the course and its episodes.
    Route::get('/Courses/edit/{id}','App\Http\Controllers\CourseController@edit');

    
    
    //Then after editing the course, the update function will handle everything. 
    Route::patch('/Courses/{id}','App\Http\Controllers\CourseController@update');
    
    
    
    //Delete the course with id - {id} , "But Onley if the user is a normal user, then we use this route".
    Route::delete('/Course/delete/{id}','App\Http\Controllers\CourseController@delete');

/* ---------------------------------------------END OF MANAGE COURSES ROUTES----------------------------------------------*/




/*----------------------------------------------------------------------------------------
                                        MANAGE COMMENTS
*/
    
    //post a new comment.
    Route::post('/store/comment','App\Http\Controllers\CommentController@store');

    
    
    // delete comment.
    Route::delete('/delete/comment/{comment}','App\Http\Controllers\CommentController@deleteComment');
/* ---------------------------------------------END OF MANAGE COMMENTS ROUTES----------------------------------------------*/



/*----------------------------------------------------------------------------------------
                                        MANAGE COURSE VOTES
*/

    // Now if a course has vote or a 'like', submit this vote to database using Vote function.
    Route::post('/vote/course','App\Http\Controllers\CourseController@Vote');

    
    
    //Get the user Votes, but only if the user logged in.
    Route::get('/get/user/votes','App\Http\Controllers\CourseController@userVotes');
/* ---------------------------------------------END OF MANAGE COURSE VOTES ROUTES----------------------------------------------*/



/*----------------------------------------------------------------------------------------
                                        ADMIN SIDE : ADMIN ACTION
    */
    // If the user is Admin then we delete the course in another Controller "AdminController".
    Route::delete('/Course/delete/byAdmin/{id}','App\Http\Controllers\AdminController@deleteCourse');

    
    
    // Manage all accounts by the admin, onley if it is admin.
    Route::get('/manage/profiles','App\Http\Controllers\AdminController@mangeProfiles')->name('admin.profiles');

    
    
    //Add a new admin by email, This action can be done only by the admin.
    Route::post('/admin/add','App\Http\Controllers\AdminController@addAdmin');

    
    
    //delete a user, This action can be done only by the admin.
    Route::delete('/delete/user/{id}','App\Http\Controllers\AdminController@deleteUser');

    
    
    //Add a new category,This action can be done only by the admin.
    Route::post('/add/category','App\Http\Controllers\AdminController@addCategory');

    
    
    //delete a category,This action can be done only by the admin.
    Route::delete('/delete/category/{id}','App\Http\Controllers\AdminController@deleteCategory');

    
    
    //show the admin all emails,This action can be done only by the admin.
    Route::get('/emails','App\Http\Controllers\EmailController@getEmails')->name('show.emails');

    
    
    //Delete an email,This action can be done only by the admin.
    Route::delete('/delete/mail/{id}','App\Http\Controllers\EmailController@delteMail');
/* ---------------------------------------------END OF THE ADMIN SIDE ROUTES----------------------------------------------*/
});

/* ---------------------------------------------DONE----------------------------------------------*/