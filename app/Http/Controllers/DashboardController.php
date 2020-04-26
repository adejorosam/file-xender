<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    //
    public function dashboard(){
        $user = Auth::user();
        // dd($user);
        $files = Document::where('user_id', $user->id)->get();
        $data = array('files' => $files , 'user'=>$user );
        return view('user.dashboard', $data);
    }

    public function profile(){
        return view('user.profile');
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $request->user()->fill([
            'password' => Hash::make($request->input('password'))
        ]);
        $user->save();
        return redirect('/dashboard')->with('success', 'Profile successfully updated');
    }
}
