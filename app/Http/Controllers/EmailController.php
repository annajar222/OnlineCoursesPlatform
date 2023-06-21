<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EmailController extends Controller
{
    /*
    ---------------------------------------------------------------------------------------------------------------------------------
                                                        MANAGE ADMIN ACTIONS
                                                                (EMAILS)
    */

    //ONLEY IF USER CONNECTED
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index']]);
    }


    // I NAMED IT INDEX FOR SECURITY
    // THIS FUNCTION WILL STORE THE EMAIL THAT USER SUBMITS, EVEN IF USER NOT LOGGED IN.
    public function index(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        
        $mail = DB::insert('insert into email (firstname,lastname,email,message) values(?,?,?,?)',[$request->firstname,$request->lastname,$request->email,$request->message]);
        if($mail){
            //IF EMMAIL HAS BEEN STORED THAN RETURN USER TO THE LANDDING PAGE.
            return view('welcome');
        }
    }


    //NOW IF THE USER IS ADMIN PRINGs ALL EMAIL SO THE ADMIN CAN READ THEM.
    public function getEmails()
    {
        if(auth()->user()->is_admin)
        {
            $emails = DB::select('select * from email');

            return Inertia::render('Admin/Emails',[
                'emails' => $emails
            ]);
        }
    }


    //THIS FUCNTION WILL DELETE AN EMAIL.
    public function delteMail($id)
    {
        if(auth()->user()->is_admin){
            $delete = DB::table('email')->where('id', '=', $id)->delete();
            if($delete)
            {
                return Redirect::route('show.emails')->with('message','email deleted.');
            }
        }
    }
}
