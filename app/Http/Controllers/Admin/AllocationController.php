<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AllocationDataTable;
use App\DataTables\MembersDataTable;
use App\Exports\AllocationsExport;
use App\Http\Controllers\Controller;
use App\Imports\AllocationsImport;
use App\Models\AssetUse;
use App\Models\SubAsset;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Maatwebsite\Excel\Facades\Excel;

class AllocationController extends Controller
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
    public function index(AllocationDataTable $dataTable)
    {
        if (!Auth::user()->can('allocations:list')) {
            abort(403);
        }

        $title = "Allotments";

        return $dataTable->render('allocations.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('allocations:create')) {
            abort(403);
        }

        $title = "Allotments";
        $subassets = SubAsset::all();
        $members  = Member::all();
        return view('allocations.create',compact('title', 'subassets', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('allocations:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'member_id' =>  'required|min:1',
            'subasset_id' =>  'required|min:1',
            'parcel_no' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Allotments";

        $subasset = SubAsset::find($request->subasset_id);

        $subasset->parcel_no = $request->parcel_no;
        $subasset->member_id = $request->member_id;

        if($subasset->save()){

            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubAsset  $subasset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(SubAsset $subasset)
    {
        if (!Auth::user()->can('allocations:update')) {
            abort(403);
        }

        $title = "Allotments";
        $subassets = SubAsset::all();
        $members  = Member::all();
        return view('allocations.edit', compact('title','subasset', 'subassets', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubAsset  $subasset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SubAsset $subasset)
    {
        if (!Auth::user()->can('allocations:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'member_id' =>  'required|min:1',
            'subasset_id' =>  'required|min:1',
            'parcel_no' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Allotments";

        $subasset->parcel_no = $request->parcel_no;
        $subasset->member_id = $request->member_id;

        if($subasset->save()){
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
        if (!Auth::user()->can('allocations:import')) {
            abort(403);
        }

        $title = "Allotments";
        $uses = AssetUse::with('areas')->get();
        return view('allocations.import', compact('title', 'uses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {

        if (!Auth::user()->can('allocations:import')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'importFile' =>  'required|min:1',
            'asset_use_id' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }


        $path = $request->file('importFile')->store('temp');
        $actualPath=storage_path('app').'/'.$path;

        $import = new AllocationsImport($request->asset_use_id);
        $import->import($actualPath);

        $errors = array();
        foreach ($import->failures() as $failure) {
            $failure->row(); // row that went wrong
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.

            $values = "";
            foreach($failure->values() as $key => $value){
                $values .= strtoupper(str_replace('_', ' ', $key)) . " " . $value . " ";
            }


            array_push($errors,$values . " ERROR : " . $failure->errors()[0]);
        }

        if (count($errors) > 0){
            return back()->with('import_errors', $errors);
        }else{
            return back()->with('success', 'Allotment Import Successful');
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
        if (!Auth::user()->can('allocations:export')) {
            abort(403);
        }

        return Excel::download(new AllocationsExport(), 'Allotments '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/AllotmentsImportSample.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('allocations:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Allotments";

        $subasset = SubAsset::find($request->id);

        if($subasset->delete()){
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }
}
