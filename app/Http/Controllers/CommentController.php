<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CommentController extends Controller
{
    /*
    ---------------------------------------------------------------------------------------------------------------------------------
                                                        MANAGE COMMENTS
    */


    // ONLEY IF USER IS LOGGED IN
    public function __construct(){
        $this->middleware('auth');
    }


    //STORE COMMENT
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->course_id = $request->courseId;
        $comment->episode_id = $request->episodeId;
        $comment->user_name = auth()->user()->name;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        //THEN GET ALL COURSE COMMENTS
        $comments = Comment::all()->where('course_id',$request->courseId);
        return $comments;
    }


    //DELETE COMMENT
    public function deleteComment($comment)
    {
        $comment = Comment::find($comment);
        //IF THE COMMENT BELONGS TO THE CONNECTED USER THEN DELETED
        //ALSO WE WANT THE ADMIN TO HAVE THE RIGHT TO DELETE THE COMMENT IF NEEDED(MANAGE COMMENETS), THAT'S WHY WE USED "|| auth()->user()->is_admin".
        
        $course = Course::find($comment->course_id);
        if(auth()->user()->id === $comment->user_id || auth()->user()->is_admin || $course->user_id === auth()->user()->id)
        {
            //DELETE COMMENT
            $comment->delete();
            //THEN REFRESH DATA AND BRING ME THE EXSISTING COMMENTS.
            $comments = Comment::all()->where('course_id',$comment->course_id);
            return $comments;
        }
        
    }
}
