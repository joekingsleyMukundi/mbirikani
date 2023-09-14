<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubAssetDataTable;
use App\Exports\SubAssetsExport;
use App\Http\Controllers\Controller;
use App\Imports\SubAssetsImport;
use App\Models\Area;
use App\Models\Asset;
use App\Models\AssetUse;
use App\Models\SubAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubAssetController extends Controller
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
    public function index(SubAssetDataTable $dataTable)
    {
        if (!Auth::user()->can('subassets:list')) {
            abort(403);
        }

        $title = "Parcels";

        return $dataTable->render('subassets.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('subassets:create')) {
            abort(403);
        }

        $title = "Parcels";
        $assets  = Asset::all();
        $uses = AssetUse::with('areas')->get();
        return view('subassets.create',compact('title', 'assets', 'uses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('subassets:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'survey_no' =>  'required|min:1',
            'asset_id' =>  'required|min:1',
            'acres' =>  'required|min:1',
            'area_id' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Parcels";

        $subassetsacres = SubAsset::where('asset_id', $request->asset_id)->sum('acres');

        if($subassetsacres + $request->acres <= Asset::where('id', $request->asset_id)->sum('total_acres')){

            $subasset = SubAsset::create($request->except(['_token']));

            if($subasset){

                return redirect()->back()->with('success', $title . ' created successfully');
            }

            return redirect()->back()->with('error', 'Failed to create ' . $title);
        }
        return redirect()->back()->with('error', 'Failed to create ' . $title . ' Asset is depleted');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubAsset  $subasset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(SubAsset $subasset)
    {
        if (!Auth::user()->can('subassets:create')) {
            abort(403);
        }

        $title = "Parcels";
        $assets  = Asset::all();
        $uses = AssetUse::with('areas')->get();
        return view('subassets.edit', compact('title','assets', 'subasset', 'uses'));
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
        if (!Auth::user()->can('subassets:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'survey_no' =>  'required|min:1',
            'asset_id' =>  'required|min:1',
            'acres' =>  'required|min:1',
            'area_id' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Parcels";

        //$land->name = $request->name;

        $subassetsacres = SubAsset::where('asset_id', $request->asset_id)->where('id', '!=', $subasset->id)->sum('acres');

        if($subassetsacres + $request->acres <= Asset::where('id', $request->asset_id)->sum('total_acres')){

            if($subasset->update($request->except(['_token']))){
                return redirect()->back()->with('success', $title . ' updated successfully');
            }

            return redirect()->back()->with('error', 'Failed to update ' . $title);

        }
        return redirect()->back()->with('error', 'Failed to create ' . $title . ' Asset is depleted');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if (!Auth::user()->can('subassets:import')) {
            abort(403);
        }

        $title = "Parcels";
        $assets = Asset::all();
        $uses = AssetUse::with('areas')->get();
        $areas = Area::all();
        return view('subassets.import', compact('title','assets', 'uses', 'assets', 'areas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStore(Request $request)
    {
        if (!Auth::user()->can('subassets:import')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'asset_use_id' =>  'required|min:1',
            'importFile' =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }


        $path = $request->file('importFile')->store('temp');
        $actualPath=storage_path('app').'/'.$path;

        try {
            Excel::import(new SubAssetsImport(1, $request->asset_use_id, $request->area_id), $actualPath);

            return back()->with('success', 'Sub Asset Import Successfull');

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
        if (!Auth::user()->can('subassets:export')) {
            abort(403);
        }

        return Excel::download(new SubAssetsExport(SubAsset::with('area.uses')->get()), 'Parcels '.date('Y-m-d').'.xlsx');
    }

    public function downloadSample(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(public_path('import/ParcelImportSample.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('subassets:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Parcels";

        $subasset = SubAsset::find($request->id);

        if($subasset->delete()){
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }
}
