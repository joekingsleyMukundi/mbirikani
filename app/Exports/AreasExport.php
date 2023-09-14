<?php

namespace App\Exports;

use App\Models\Area;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AreasExport implements FromView
{

    public function view(): View
    {
        return view('areas.export', [
            'areas' => Area::all(),
            'title' => 'Areas'
        ]);
    }
}
