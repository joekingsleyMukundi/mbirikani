<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AuditsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;

class LogsController extends Controller
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
    public function index(AuditsDataTable $dataTable)
    {
        if (!Auth::user()->can('audits:list')) {
            abort(403);
        }

        $title = "Audit Trail";

        return $dataTable->render('logs.index', compact('title'));
    }

}
