<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MembersDataTable;
use App\Exports\MembersExport;
use App\Http\Controllers\Controller;
use App\Imports\MembersImport;
use App\Imports\UsersImport;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class MemberController extends Controller
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
    public function index(MembersDataTable $dataTable)
    {
        if (!Auth::user()->can('members:list')) {
            abort(403);
        }

        $title = "Members";

        return $dataTable->render('members.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('members:create')) {
            abort(403);
        }

        $title = "Members";

        return view('members.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('members:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'first_name' =>  'required|min:1',
            'last_name' =>  'required|min:1',
            'password' =>  'required|min:1',
            'id_no' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Members";

        if ($request->hasFile('pic')) {
            $picture = $request->file('pic');
            $file_extension = $picture->getClientOriginalExtension();
            $file_name = time().rand(99,999).'.'.$file_extension;
            $path = public_path() . '/uploads/members/';
            $file_path = $picture->move($path, $file_name);
            $request->merge(['pic' => '/uploads/members/' . $file_name]);
        }

        $request->merge(['password' => Hash::make($request->password)]);

        if(Member::create($request->except(['_token', 'pic']))){

            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        if (!Auth::user()->can('members:update')) {
            abort(403);
        }

        $title = "Members";

        return view('members.edit', compact('title','member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Member $member)
    {
        if (!Auth::user()->can('members:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'first_name' =>  'required|min:1',
            'last_name' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Members";

        if($request->password){
            $request->merge(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('pic')) {
            $picture = $request->file('pic');
            $file_extension = $picture->getClientOriginalExtension();
            $file_name = time().rand(99,999).'.'.$file_extension;
            $path = public_path() . '/uploads/members/';
            $file_path = $picture->move($path, $file_name);

            $member->pic =  '/uploads/members/' . $file_name;
        }

        if($member->update($request->except(['_token', 'pic']))){

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
        if (!Auth::user()->can('members:import')) {
            abort(403);
        }

        $title = "Members";

        return view('members.import', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {

        if (!Auth::user()->can('member:import')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'importFile' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $path = $request->file('importFile')->store('temp');
        $actualPath=storage_path('app').'/'.$path;

        try {

            //Disable memory_limit by setting it to minus 1.
            ini_set("memory_limit", -1);

            //Disable the time limit by setting it to 0.
            set_time_limit(0);
            Excel::import(new MembersImport(), $actualPath);

            return back()->with('success', 'Member Import Successful');

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
        if (!Auth::user()->can('members:export')) {
            abort(403);
        }

        return Excel::download(new MembersExport(Member::all()), 'Members '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/MemberImportSample.xlsx'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('members:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Members";

        $member = Member::find($request->id);
        if($member->delete()){
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function profile(Member $member)
    {
        if (!Auth::user()->can('members:read')) {
            abort(403);
        }

        $title = "Profile";
        return view('members.profile', compact('title', 'member'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        if (!Auth::user()->can('members:update')) {
            abort(403);
        }

        $title = "Password";
        return view('members.password', compact('title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        if (!Auth::user()->can('members:update')) {
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
                $obj_user = Member::find($user_id);
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
