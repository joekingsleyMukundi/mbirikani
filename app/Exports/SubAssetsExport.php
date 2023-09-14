<?php

namespace App\Exports;

use App\Models\SubAsset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubAssetsExport implements FromView
{


    public $subassets;

    public function __construct($subassets)
    {
        $this->subassets = $subassets;
    }

    public function view(): View
    {
        return view('subassets.export', [
            'subassets' => $this->subassets,
            'title' => 'Parcels'
        ]);
    }
}
