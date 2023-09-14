<?php


namespace App\Http\Controllers\Admin;

use App\Exports\MembersExport;
use App\Exports\SubAssetsExport;
use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Area;
use App\Models\Asset;
use App\Models\AssetUse;
use App\Models\Member;
use App\Models\SubAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;

class ReportController extends Controller
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

        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $title = "Reports";


        $pieCharts = $this->getPieChartData();
        $barCharts = $this->getBarCharData();
        $catPieCharts = $this->getCategoryPieCharData();


        return view('reports.index', compact('title', 'pieCharts', 'barCharts', 'catPieCharts'));
    }


    public function getPieChartData(): array
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $pieCharts = [];

        $labels = ["Allocated", "Unallocated"];

        $colors = ["#00a65a", "#c1c7d1"];

        $assets = Asset::all();

        foreach ($assets as $asset){

            $allocations = $asset::with('subassets.member')->first();

            $allocated = 0;
            foreach ($allocations->subassets as $allocation){

                $allocated+=$allocation->acres;

            }

            $data = [round($allocated,2), round($asset->total_acres - $allocated,2)];

            $pieCharts[] = ['name' => $asset->name, 'id' => $asset->id, 'labels' => $labels,  'colors' => $colors,  'data' => $data];
        }


        return $pieCharts;
    }

    public function getBarCharData(): array
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $barCharts = [];

        $uses = AssetUse::all();

        $assets = Asset::all();

        foreach ($assets as $asset){
            $labels = [];

            $colors = [];

            $data = [];

            $allocations = $asset::with('subassets.member','subassets.area')->first();

            foreach ($uses as $use){

                $labels[] = $use->name;
                $colors[] = $this->rand_color();

                $allocated = 0;
                foreach ($allocations->subassets as $allocation){

                    if($allocation->area->asset_use_id == $use->id){
                        $allocated+=$allocation->acres;
                    }

                }
                $data[] = round($allocated,2);

            }

            $barCharts[] = ['name' => $asset->name, 'id' => $asset->id, 'labels' => $labels,  'colors' => $colors,  'data' => $data];
        }

        return $barCharts;

    }

    public function getCategoryPieCharData(): array
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $barCharts = [];

        $uses = AssetUse::all();

        $assets = Asset::all();

        foreach ($assets as $asset){
            $labels = [];

            $colors = [];

            $data = [];

            $allocations = $asset::with('subassets.member','subassets.area')->first();

            foreach ($uses as $use){

                $labels[] = $use->name;
                $colors[] = $this->rand_color();

                $allocated = 0;
                foreach ($allocations->subassets as $allocation){

                    if($allocation->area->asset_use_id == $use->id){
                        $allocated+=$allocation->acres;
                    }

                }
                $data[] = round($allocated,2);

            }

            $barCharts[] = ['name' => $asset->name, 'id' => $asset->id, 'labels' => $labels,  'colors' => $colors,  'data' => $data];
        }

        return $barCharts;

    }

    function rand_color(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function showMembersReports(Request $request)
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $title = "Members Reports";
        
        $uses = AssetUse::with('areas')->get();
        return view('reports.members', compact('title', 'uses'));
    }

    public function getMembersReports(Request $request)
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $type = $request->type;
        $area = $request->area;

        $query = "";


        if (!empty($area)) {
            $query .= "sub_assets.area_id = ".$area;
        }
        
        if (empty($type)) {
            $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                    'members.email', 'members.sex', 'members.kra')->get();
        }else{
            if ($type=="allocated") {
                $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                    ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                        'members.email', 'members.sex', 'members.kra')->whereNotNull('sub_assets.member_id')->whereRaw($query)->groupBy('members.id')->get();
            }else{
                $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                    ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                        'members.email', 'members.sex', 'members.kra')->whereNull('sub_assets.member_id')->groupBy('members.id')->get();
            }
        }

        // Fetch records
        $records = $members;
        // Total records
        $totalRecords = Member::all()->count();
        $totalRecordsWithFilter = $members->count();

        $data_arr = array();

        foreach($records as $record){

            $data_arr[] = array(
                "mcs" => "MCS/".$record->id,
                "membership_number" => $record->membership_number,
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "id_no" => $record->id_no,
                "phone" => $record->phone,
                "email" => $record->email,
                "sex" => $record->sex,
                "kra" => $record->kra,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function excelMembersReport(Request $request){

        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $type = $request->type;
        $area = $request->area_id;
        
        $query = "";


        if (!empty($area)) {
            $query .= "sub_assets.area_id = ".$area;
        }

        if (empty($type)) {
            $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                    'members.email', 'members.sex', 'members.kra')->get();
        }else{
            if ($type=="allocated") {
                $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                    ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                        'members.email', 'members.sex', 'members.kra')->whereNotNull('sub_assets.member_id')->whereRaw($query)->groupBy('members.id')->get();
            }else{
                $members = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
                    ->select(DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone',
                        'members.email', 'members.sex', 'members.kra')->whereNull('sub_assets.member_id')->groupBy('members.id')->get();
            }
        }

        $title = "";
        $type=="allocated" ? $title = 'Allocated' : $title = 'Unallocated';

        return Excel::download(new MembersExport($members), $title.' Members '.date('Y-m-d').'.xlsx');
    }


    public function showSubAssetsReports(Request $request)
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $title = "Parcels Reports";
        $uses = AssetUse::with('areas')->get();
        return view('reports.subassets', compact('title', 'uses'));
    }

    public function getSubAssetsReports(Request $request)
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $type = $request->type;
        $area = $request->area;

        $query = "";


        if ($type=="allocated") {
            $query .= "sub_assets.member_id IS NOT NULL and ";
        }else{
            $query .= "sub_assets.member_id IS NULL and ";
        }

        if (!empty($area)) {
            $query .= "sub_assets.area_id = ".$area;
        }


        $subassets = SubAsset::leftJoin('areas', 'areas.id', '=', 'sub_assets.area_id')->leftJoin('asset_uses', 'asset_uses.id', '=', 'areas.asset_use_id')
            ->select(DB::raw('ROUND(sub_assets.acres/2.4710538146717,2) as hectares'),'areas.name as area_name','asset_uses.name as asset_uses_name','sub_assets.id', 'sub_assets.member_id', 'sub_assets.survey_no', 'sub_assets.parcel_no', DB::raw('ROUND(sub_assets.acres,2) as acres'), 'sub_assets.area_id')
            ->whereRaw($query)->get();


        // Fetch records
        $records = $subassets;
        // Total records
        $totalRecords = SubAsset::all()->count();
        $totalRecordsWithFilter = $subassets->count();

        $data_arr = array();

        foreach($records as $record){

            $data_arr[] = array(
                "uses" => $record->asset_uses_name,
                "area" => $record->area_name,
                "hectares" => $record->hectares,
                "acres" => $record->acres,
                "survey_no" => $record->survey_no,
                "parcel_no" => $record->parcel_no,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function excelSubAssetsReport(Request $request){

        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $type = $request->type;
        $category = $request->asset_use_id;
        $area = $request->area_id;

        $query = "";


        if ($type=="allocated") {
            $query .= "sub_assets.member_id IS NOT NULL and ";
        }else{
            $query .= "sub_assets.member_id IS NULL and ";
        }

        if (!empty($category)) {
            $query .= "sub_assets.asset_use_id = ".$category." and ";
        }

        if (!empty($area)) {
            $query .= "sub_assets.area_id = ".$area;
        }

        $subassets = SubAsset::leftJoin('areas', 'areas.id', '=', 'sub_assets.area_id')->leftJoin('asset_uses', 'asset_uses.id', '=', 'areas.asset_use_id')
            ->select(DB::raw('ROUND(sub_assets.acres/2.4710538146717,2) as hectares'),'areas.name as area_name','asset_uses.name as asset_uses_name','sub_assets.id', 'sub_assets.member_id', 'sub_assets.survey_no', 'sub_assets.parcel_no', DB::raw('ROUND(sub_assets.acres,2) as acres'), 'sub_assets.area_id')
            ->whereRaw($query)->get();

        $title = "";
        $type=="allocated" ? $title = 'Allocated' : $title = 'Unallocated';

        return Excel::download(new SubAssetsExport($subassets), $title.' Parcels '.date('Y-m-d').'.xlsx');
    }
    
    public function showSummaryReports(Request $request)
    {
        if (!Auth::user()->can('reports:read')) {
            abort(403);
        }

        $title = "Summary Reports";

        $datas = array();

        $areas  = Area::all();
        $uses = AssetUse::all();
        $asset = Asset::find(1);

        foreach ($uses as $use){
            $data = array();
            foreach ($use->areas as $area){
                $totalAcres = SubAsset::where('area_id', $area->id)->sum('acres');
                $totalParcel = SubAsset::where('area_id', $area->id)->count();
                $totalParcelIssued = SubAsset::where('area_id', $area->id)->whereNotNull('member_id')->count();
                $totalParcelUnissued = SubAsset::where('area_id', $use->id)->whereNull('member_id')->count();
    
                $data[] = ['area' => $area->name,  'total_acres' => round($totalAcres,2),
                'total_parcels' => $totalParcel, 'total_issued' => $totalParcelIssued, 'total_unissued' => $totalParcelUnissued];
            }
            
            $datas[] = ['category' => $use->name, 'datas' => $data];
        }

        //dd($datas);
        
        return view('reports.summary', compact('title',  'datas', 'asset'));
    }
}
