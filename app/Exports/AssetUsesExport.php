<?php

namespace App\Exports;


use App\Models\AssetUse;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssetUsesExport implements FromView
{

    public function view(): View
    {
        return view('assetuses.export', [
            'assetuses' => AssetUse::all(),
            'title' => 'Land Categories'
        ]);
    }
}
