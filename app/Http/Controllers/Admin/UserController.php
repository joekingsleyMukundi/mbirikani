<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;


class UserController extends Controller
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
    public function index()
    {
        if (!Auth::user()->can('users:list')) {
            abort(403);
        }

        $title = "Staff";
        $users  = User::all();
        return view('users.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('users:create')) {
            abort(403);
        }

        $title = "Staff";
        $roles = Role::all();
        return view('users.create',compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('users:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'first_name' =>  'required|min:1',
            'last_name' =>  'required|min:1',
            'email' =>  'required|min:1',
            'phone' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Staff";

        if ($request->hasFile('pic')) {
            $picture = $request->file('pic');
            $file_extension = $picture->getClientOriginalExtension();
            $file_name = time().rand(99,999).'.'.$file_extension;
            $path = public_path() . '/uploads/users/';
            $file_path = $picture->move($path, $file_name);

            $request->merge(["pic" => '/uploads/users/' . $file_name]);
        }

        $request->merge(["password"=>Hash::make("password")]);

        $user = User::create($request->except(['_token']));

        if($user){
            $user->assignRole(Role::findById($request->role_id)->name);

            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!Auth::user()->can('users:update')) {
            abort(403);
        }

        $title = "Staff";
        $roles = Role::all();
        return view('users.edit', compact('title','user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->can('users:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'first_name' =>  'required|min:1',
            'last_name' =>  'required|min:1',
            'email' =>  'required|min:1',
            'phone' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Staff";

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->hasFile('pic')) {
            $picture = $request->file('pic');
            $file_extension = $picture->getClientOriginalExtension();
            $file_name = time().rand(99,999).'.'.$file_extension;
            $path = public_path() . '/uploads/users/';
            $file_path = $picture->move($path, $file_name);

            $user->pic =  '/uploads/users/' . $file_name;
        }

        if($user->save()){
            foreach ($user->getRoleNames() as $role){
                $user->removeRole($role);
            }
            $user->assignRole(Role::findById($request->role_id)->name);

            return redirect()->back()->with('success', $title . ' updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if (!Auth::user()->can('users:import')) {
            abort(403);
        }

        $title = "Staff";
        $roles = Role::all();
        return view('users.import', compact('title', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {

        if (!Auth::user()->can('users:import')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'role_id' =>  'required|min:1',
            'importFile' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }


        $path = $request->file('importFile')->store('temp');
        $actualPath=storage_path('app').'/'.$path;

        try {
            Excel::import(new UsersImport($request->role_id), $actualPath);

            return back()->with('success', 'User Import Successful');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = "";
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.


                $values = "";
                foreach($failure->values() as $key => $value){
                    $values .= strtoupper(str_replace('_', ' ', $key)) . " " . $value . " ";
                }
                
                
                $errors = $errors . "ROW : " . $failure->row() . " VALUES :" . $values . " ERROR : " . $failure->errors()[0];
            }

            return back()->with('error', $errors);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        if (!Auth::user()->can('users:export')) {
            abort(403);
        }

        return Excel::download(new UsersExport(), 'Staff '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/UserImportSample.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('users:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Staff";

        $user = User::find($request->id);
        if($user->delete()){
            foreach ($user->getRoleNames() as $role){
                $user->removeRole($role);
            }
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function profile()
    {
        if (!Auth::user()->can('users:read')) {
            abort(403);
        }

        $title = "Profile";
        return view('users.profile', compact('title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
        if (!Auth::user()->can('users:update')) {
            abort(403);
        }

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
