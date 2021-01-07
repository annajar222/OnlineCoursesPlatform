<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    
    /*
    ---------------------------------------------------------------------------------------------------------------------------------
                                                        MANAGE ADMIN ACTIONS
    */

    //ONLEY IF USER CONNECTED
    public function __construct()
    {
        $this->middleware('auth');
    }


    //PRING ALL USERS
    public function mangeProfiles()
    {
        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_admin)
        {
            $users = User::select('id','name','email','created_at','is_admin')->orderBy('created_at','DESC')->withCount('courses')->get();
            return Inertia::render('Admin/Profiles',[
                'users' => $users,
            ]);
        }

        //IF USER NOT ADMIN, THEN:
        return Redirect::route('dashboard')->with('message','This action in unauthorized');
    }


    // DELETE THE COURSE WITH EPISODES AND COMMENTS.
    public function deleteCourse(int $id)
    {
        $course = Course::where('id',$id)->with('episodes')->first();
        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_admin)
        {
            $course->episodes()->delete();
            $course->comments()->delete();
            $course->delete();
            return Redirect::route('dashboard')->with('message','Course Has been deleted.');
        }
        $this->authorize('delete',$course);
        return Redirect::route('dashboard')->with('message','This action in unauthorized.');
    }

    public function deleteUser($id)
    {
        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_admin)
        {
            $user = User::find($id);
            //IF USER IS PARENTaDMIN
            if($user->is_parentAdmin)
            {
                return Redirect::route('admin.profiles')->with('message','You can not delete a parent admin.');
            }
            //IF USER HAS COURSES AND EPISODES DELETE THEM THEN DELETE THE USER.
            if($user->courses()->count()){
                foreach($user->courses() as $course)
                {
                    $course->episodes()->delete();
                }
                $user->courses()->delete();
                //ALSO IF USER HAS VOTES DELETE THEM.
                $user->votes()->delete();
                DB::table('completions')->where('user_id',$user->id)->delete();
            }
            if($user->delete())
            {
                //IF USER DELETED THEN:
                return Redirect::route('admin.profiles')->with('message','User Has Been Deleted.');
            }

        }
    }


    //ADD A NEW ADMIN
    public function addAdmin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
        ]);

        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_parentAdmin)
        {
            $user = User::where('email', '=', $request->input('email'))->first();
            if($user === null)
            {
                return Redirect::route('admin.profiles')->with('message','This email does not exist');
            }
            //IF THE USER ALREDY AN ADMIN
            if($user->is_admin)
            {
                return Redirect::route('admin.profiles')->with('message','The user with email '.$user->email.' is alredy an admin.');
            }
            $user->is_admin = true;
            $user->save();
            return Redirect::route('admin.profiles')->with('message','The user with email '.$user->email.' is a new admin.');
        }
    }


    //ADD A NEW CATEGORY
    public function addCategory(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:60'
        ]);

        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_admin)
        {   

            $category = Category::where('title',$request->title)->first();
            //IF CATEGORY ALREDY EXSITST THEN:
            if($category)
            {
                return Redirect::route('dashboard')->with('message','Category Alredy exsists.');
            }
            if(Category::create($request->all()))
            {
                return Redirect::route('dashboard')->with('message','New category created.');
            }
            else{
                return Redirect::route('dashboard')->with('message','There was an error try again.');
            }
        }
        
    }

    public function deleteCategory($id)
    {
        //ONLEY IF THE USER IS ADMIN.
        if(auth()->user()->is_admin)
        {
            //FIND THE CCATEGORY
            $category = Category::find($id);
            //SETT EVERY COUSE THAT HAS THE CATEGORY NAME TO NULL.
            foreach ($category->courses() as $course) {
                $course->update(['category_id' => NULL]);
            }
            //THEN DELETE THE CATEGORY.
            $category->delete();
            return Redirect::route('dashboard')->with('message','Category has been deleted.');
        }
        return Redirect::route('dashboard')->with('message','There is an error try again.');
    }
}
