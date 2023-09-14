<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Area;
use App\Models\Asset;
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
        $this->middleware('auth:member');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allocations  = Auth::user()->allocations;
        return view('member.dashboard.index', compact('allocations'));
    }
}
