<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Area;
use App\Models\Asset;
use App\Models\AssetUse;
use App\Models\Member;
use App\Models\Sector;
use App\Models\SubAsset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $members = Member::all();
        $users = User::all();
        $assets = Asset::all();
        $subassets = SubAsset::all();
        $areas = Area::all();
        $allocations = SubAsset::has('member')->get();
        $uses = AssetUse::all();

        return view('dashboard.index', compact('members','users', 'assets', 'subassets', 'areas', 'allocations', 'uses'));
    }
}
