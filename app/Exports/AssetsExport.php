<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssetsExport implements FromView
{

    public function view(): View
    {
        return view('assets.export', [
            'assets' => Asset::all(),
            'title' => 'Group Ranches'
        ]);
    }
}
