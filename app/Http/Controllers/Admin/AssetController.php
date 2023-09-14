<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AssetsExport;
use App\Http\Controllers\Controller;
use App\Imports\AssetsImport;
use App\Models\Area;
use App\Models\Asset;
use App\Models\AssetUse;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
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
        if (!Auth::user()->can('assets:list')) {
            abort(403);
        }

        $title = "Group Ranch";
        $assets  = Asset::all();
        return view('assets.index', compact('title', 'assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('assets:create')) {
            abort(403);
        }

        $title = "Group Ranch";
        $uses = AssetUse::all();

        return view('assets.create',compact('title', 'uses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('assets:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
            'total_acres' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Group Ranch";

        $asset = Asset::create($request->except(['_token']));

        if($asset){

            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        if (!Auth::user()->can('assets:update')) {
            abort(403);
        }

        $title = "Group Ranch";
        $uses = AssetUse::all();
        return view('assets.edit', compact('title','asset', 'uses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Asset $asset)
    {
        if (!Auth::user()->can('assets:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
            'total_acres' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Group Ranch";

        //$land->name = $request->name;

        if($asset->update($request->except(['_token']))){
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
        if (!Auth::user()->can('assets:import')) {
            abort(403);
        }

        $title = "Group Ranch";
        $uses = AssetUse::all();
        return view('assets.import', compact('title', 'uses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {

        if (!Auth::user()->can('assets:import')) {
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
            Excel::import(new AssetsImport(), $actualPath);

            return back()->with('success', 'Asset Import Successfull');

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
        if (!Auth::user()->can('assets:export')) {
            abort(403);
        }

        return Excel::download(new AssetsExport(), 'Group Ranch '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/GroupRanchImportSample.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('assets:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Group Ranch";

        $asset = Asset::find($request->id);

        if($asset->delete()){
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }
}
