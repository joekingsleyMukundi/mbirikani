<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function general()
    {
        if (!Auth::user()->can('settings:general')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "General Settings";

        return view('settings.general', compact('title', 'secondarytitle'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generalStore(Request $request)
    {
        if (!Auth::user()->can('settings:general')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name'     =>  'required|min:8',
            'phone'     =>  'required|min:8',
            'email'     =>  'required|min:8',
            'location'     =>  'required|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $data = [
            'business_name' => $request->name,
            'business_phone' => $request->phone,
            'business_email' => $request->email,
            'business_location' => $request->location,
        ];

        if ($request->hasFile('logo')) {
            $picture = $request->file('logo');
            $file_extension = $picture->getClientOriginalExtension();
            $file_name = time().rand(99,999).'.'.$file_extension;
            $path = public_path() . '/uploads/logos/';
            $file_path = $picture->move($path, $file_name);

            $data += ['logo' => '/uploads/logos/' . $file_name];
        }

        $response = Setting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()->back()->with('success', 'General Settings saved successfully');
    }
}
