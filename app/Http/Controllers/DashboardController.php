<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /*
    ---------------------------------------------------------------------------------------------------------------------------------
                                                        MANAGE (DASHBOARDS)
                                                            
    */

    //ONLEY IF USER CONNECTED
    public function __construct()
    {
        $this->middleware('auth');
    }


    public  function dashboard(){

        // SO IF THE USER IS ADMIN THEN PRING ALL COURSES, SO THE ADMIN CAN MANAGE ALL COURSES.
        if(auth()->user()->is_admin)
        {
            $courses = Course::with('user')
            ->select('courses.*',DB::raw(
                '(SELECT COUNT(DISTINCT(user_id))
                FROM completions
                INNER JOIN episodes ON completions.episode_id = episodes.id
                WHERE episodes.course_id = courses.id
                ) AS participants'
            ))
            ->withCount('episodes')->with('category')->latest()->get();
            $categories = Category::select('id','title')->get();
            return Inertia::render('Dashboard/AdminDashboard',[
                'courses' => $courses,
                'categories' => $categories,
            ]);
        }
        //IF USER NOT AN ADMIN (NORMAL USER), GET JUST THE CONNECTED USER COURSES(COURSES THAT HE CREATED).
        $courses = Course::select('courses.*',DB::raw(
            '(SELECT COUNT(DISTINCT(user_id))
            FROM completions
            INNER JOIN episodes ON completions.episode_id = episodes.id
            WHERE episodes.course_id = courses.id
            ) AS participants'
        ))
        ->where('user_id',auth()->user()->id)
        ->withCount('episodes')->with('category')->latest()->get();
        return Inertia::render('Dashboard/Dashboard',[
            'courses' => $courses,
        ]);
    }
}
