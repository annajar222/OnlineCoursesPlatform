<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Vote;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /*
    ---------------------------------------------------------------------------------------------------------------------------------
                                                        MANAGE COURSES
    */

    // ONLEY IF USER IS LOGGED IN
    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        // GET ALL COURSES
        $courses = Course::with('user')
        //COUNT HOW MANY PARTICIPANT THE COURSE HAS
        ->select('courses.*',DB::raw(
            '(SELECT COUNT(DISTINCT(user_id))
            FROM completions
            INNER JOIN episodes ON completions.episode_id = episodes.id
            WHERE episodes.course_id = courses.id
            ) AS participants'
        ))
        //GET COURSES WITH COUNTING EPISODES AND VOTES(LIKES) ALSO BRING THE COURSE CATEGORY.
        ->withCount('episodes','votes')->with('category')->latest()->paginate(10);
        //GET ALL CATEGORIES
        $categories = Category::select('id','title')->get();
        //NOW RENDER THE VIEW.
        return Inertia::render('Courses/Index',[
            'courses' => $courses,
            'categories' => $categories,
        ]);
    
    }

    public function show($id)
    {
        //GET COURSE WITH THE ID = $id
        $course = Course::where('id',$id)->with('episodes','category')->first();
        // WITH COMMENTS
        $comments = $course->comments;
        //AND THE EPISODES THAT THE CONNECTED USER WATCHED.
        $watched = auth()->user()->episodes;
        return Inertia::render('Courses/Show',[
            'course' => $course,
            'watched' => $watched,
            'comments' => $comments
        ]);
    }

    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');
        $user = auth()->user();
        /* 
        The many-to-many relationship provides a toggle method which "toggles" the attachment status of the given related model IDs. 
        If the given ID is currently attached,
        it will be detached. Likewise, if it is currently detached, it will be attached
        */
        $user->episodes()->toggle($id);
        //RETURN THE USER EPISODES SO WE CAN USE IT AGAIN.
        return $user->episodes;
    }

    //SIMPLY RETURN THE VIEW WITH ALL CATEGORIES.
    public function newCourse(){
        $categories = Category::select('id','title')->get();
        return Inertia::render('Courses/Create',[
            'categories' => $categories
        ]);
    }

    public function store(Request $request){
        
        $request->validate([
            'title' => 'required|max:60',
            'description' => 'required',
            'category_id'=> 'required',
            'episodes' => ['array','required'],
            'episodes.*.title' => ' required|max:60',
            'episodes.*.description' => ' required',
            'episodes.*.video_url' => 'required'
        ]);
        
        //FIRST WE WILL VALIDATE THE VEDIO URL FOR ALL EPISODES
        foreach($request->input('episodes') as $episode)
        {
            $episode['video_url'] = $this->YoutubeID($episode['video_url']);
            if($episode['video_url'] === false)
            {
                return Redirect::route('courses.create')->with('message','Please put a valide url.');
            }
        }

        //AFTER VALIDATION THE REQUEST STORE THE COURSE
        $course = Course::create($request->all());
        // AND THEN WE WILL STORE THE COURSE EPISODES
        foreach($request->input('episodes') as $episode)
        {
            $episode['course_id'] = $course->id;
            $episode['video_url'] = $this->YoutubeID($episode['video_url']);
            Episode::create($episode);
        }

        return Redirect::route('courses.create')->with('message','Course Created Successfully.');
    }


    //SIMPLY RETURN THE VIEW WITH THE COURSE AND THE EPISODES SO WE CAN EDIT IT.
    public function edit(int $id){
        $course = Course::where('id',$id)->with('episodes')->first();
        $this->authorize('update',$course);
        $categories = Category::select('id','title')->get();
        return Inertia::render('Courses/EditCourse',[
            'course' => $course,
            'categories' => $categories,
        ]);
    } 


    //NOW UPDATE THE COURSE.
    public function update(Request $request){
        $request->validate([
            'title' => 'required|max:60',
            'description' => 'required',
            'category_id'=> 'required',
            'episodes' => ['array','required'],
            'episodes.*.title' => ' required:max:60',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => ' required'
        ]);
        $course = Course::where('id',$request->id)->with('episodes')->first();
        $this->authorize('update',$course);
        
        //FIRST WE WILL VALIDATE THE VEDIO URL FOR ALL EPISODES.
        foreach($request->input('episodes') as $episode)
        {
            $episode['video_url'] = $this->YoutubeID($episode['video_url']);
            if($episode['video_url'] === false)
            {
                return Redirect::route('courses.create')->with('message','Please put a valide url.');
            }
        }
        
        //UPDATE THE COURSE + DELETE COURSE EPISODES
        $course->update($request->all());
        $course->episodes()->delete();
        //AND THEN WE WILL STORE THE NEW EPISODES.
        foreach($request->episodes as $episode){
            $episode['course_id'] = $course->id;
            $episode['video_url'] = $this->YoutubeID($episode['video_url']);
            Episode::create($episode);
        }

        return Redirect::route('dashboard')->with('message','Course Updated successfully.');
    }


    //DELETE THE COURSE WITH: EPISODES,COMMENTS
    public function delete(int $id){
        $course = Course::where('id',$id)->with('episodes')->first();
        $this->authorize('delete',$course);
        $course->episodes()->delete();
        $course->comments()->delete();
        $course->delete();
        return Redirect::route('dashboard')->with('message','Course Has been deleted.');
    }

    // NOW THE COURSE VOTES
    public function Vote(Request $request)
    {
        // FIRST WE CHECK IF THE USER HAS ALREDY LIKED THE COURSE OR NOT
        // THE USER CA NOT LIKE THE COURSE 2 OR >2 TIMES.
        $check = Vote::where('user_id',auth()->user()->id)->where('course_id',$request->course_id)->first();
        if($check){
            return false;
        }
        //THEN SUBMIT THE VOTE TO VOTES TABLE.
        $vote = new Vote();
        $vote->user_id = auth()->user()->id;
        $vote->course_id = $request->course_id;
        $vote->save();
        return true;
    }

    // SIMPLY BRING ALL USER VOTES.
    public function userVotes(){
        return auth()->user()->votes;
    }

    // THIS PRIVATE FUNCTION WILL RETURN THE URL VEDIO ID SO WE CAN USE IT IN THE STORE AND UPDATE FUNCTION.
    private function YoutubeID($url)
    {
        if(strlen($url) > 11)
        {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
            {
                return $match[1];
            }
            else
                return false;
        }

        return $url;
    }

}
