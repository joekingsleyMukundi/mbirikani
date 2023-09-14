<?php

namespace App\Exports;

use App\Models\SubAsset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllocationsExport implements FromView
{

    public function view(): View
    {
        return view('allocations.export', [
            'allocations' => SubAsset::with('area.uses','member')->whereNotNull('sub_assets.parcel_no')->get(),
            'title' => 'Allotments'
        ]);
    }
}
