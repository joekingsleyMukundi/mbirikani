<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MembersExport implements FromView
{

    public $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function view(): View
    {
        return view('members.export', [
            'members' => $this->members,
            'title' => 'Members'
        ]);
    }
}
