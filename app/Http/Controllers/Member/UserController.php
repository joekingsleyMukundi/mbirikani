<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function profile()
    {
        $title = "Profile";

        return view('member.profile', compact('title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {

        $validator  =   Validator::make($request->all(), [
            'current_password'     =>  'required|min:8',
            'password'     =>  'required|min:8',
            'confirm_password'     =>  'required|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $current_password = Auth::user()->password;
        if(Hash::check($request['current_password'], $current_password))
        {
            if($request['password']==$request['confirm_password']){
                $user_id = Auth::user()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request['new_password']);
                $obj_user->save();
                return redirect()->back()->with(['success' => 'Password changed successfully']);
            }else{
                return redirect()->back()->with(['error' => 'Passwords don\'t match']);
            }

        }else{
            return redirect()->back()->with(['error' => 'Wrong current password']);
        }
    }
}
