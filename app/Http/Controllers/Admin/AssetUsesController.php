<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AssetUsesExport;
use App\Http\Controllers\Controller;
use App\Imports\AssetUsesImport;
use App\Imports\SectorsImport;
use App\Models\AssetUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AssetUsesController extends Controller
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
        if (!Auth::user()->can('uses:list')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Land Categories";
        $uses  = AssetUse::all();
        return view('uses.index', compact('title', 'uses', 'secondarytitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('uses:create')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Land Categories";
        return view('uses.create',compact('title', 'secondarytitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('uses:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Land Categories";

        $use = AssetUse::create($request->except(['_token']));

        if($use){

            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetUse  $use
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(AssetUse $use)
    {
        if (!Auth::user()->can('uses:update')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Land Categories";
        return view('uses.edit', compact('title','use', 'secondarytitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetUse  $use
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AssetUse $use)
    {
        if (!Auth::user()->can('uses:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Land Categories";

        $use->name = $request->name;

        if($use->save()){
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
        if (!Auth::user()->can('uses:import')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Land Categories";
        return view('uses.import', compact('title', 'secondarytitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {

        if (!Auth::user()->can('uses:import')) {
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
            Excel::import(new AssetUsesImport(), $actualPath);

            return back()->with('success', 'Use Import Successful');

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
        if (!Auth::user()->can('uses:export')) {
            abort(403);
        }

        return Excel::download(new AssetUsesExport(), 'Land Categories '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/AssetUseImportSample.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('uses:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Land Categories";

        $use = AssetUse::find($request->id);

        if($use->delete()){
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }
}
