<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        $user = Auth::user();
        $myfiles = Document::where('user_id', $user->id)->get();
        $data = array('files' => $myfiles , 'user'=>$user );
        return view('user.dashboard', $data);
    }

    public function profile(){
        return view('user.profile');
    }
}
