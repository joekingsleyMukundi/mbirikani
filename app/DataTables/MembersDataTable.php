<?php

namespace App\DataTables;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MembersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            ->filterColumn('mcs', function($query, $keyword) {
                $query->where(DB::raw('CONCAT("MCS/",members.id)'),"LIKE" , "%".$keyword."%");
            })
            ->filterColumn('nop', function($query, $keyword) {

            })
            ->addColumn('pic', function($row){
                
                $img = "";
                
                if($row->pic){
                    $img = '<img height="50" src="'.$row->pic.'">';
                }else{
                    $img = '<img height="50" src="https://mbirikanisociety.com/uploads/members/1661760609516.png">';
                }
                
                return $img;
            })
            ->addColumn('actions', function($row){
                $btn = "";
                if (Auth::user()->can('members:update')) {
                    $btn = '<a href="'.route('dashboard.members.edit', $row->id).'" class="m-1 btn btn-info btn-sm"><i class="fa fa-pen"></i></a>';
                }
                if (Auth::user()->can('members:read')) {
                    $btn = $btn.'<a href="'.route('dashboard.members.profile', $row->id).'" class="m-1 btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                }
                if (Auth::user()->can('members:delete')) {
                    $btn = $btn.'<button class="m-1 btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-id="'.$row->id.'" data-name="'.$row->name.'"><i class="fa fa-trash"></i></button>';
                }

                return $btn;
            })->rawColumns(['pic','actions']);
    }
    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $posts = Member::leftJoin('sub_assets', 'members.id', '=', 'sub_assets.member_id')
            ->select(DB::raw('CAST(members.membership_number as SIGNED) AS casted_column'), DB::raw('CONCAT("MCS/",members.id) as mcs'),'members.id', 'members.membership_number', 'members.first_name', 'members.last_name', 'members.id_no', 'members.phone', 'members.pic',
                'members.email', 'members.sex', 'members.kra',
                DB::raw('COUNT(sub_assets.member_id) as nop'))->groupBy('members.id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('members-table')
                    ->columns($this->getColumns())
                    ->addTableClass('table-bordered table-striped nowrap')
                    ->minifiedAjax()
                    ->dom('frtip')
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {

        return [
            Column::computed('pic')->title('Picture')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('mcs')->title("MGR Co-op Society Membership No"),
            Column::make('membership_number')->title("MGR Membership No"),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('id_no')->title('National ID'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('sex'),
            Column::make('kra'),
            Column::make('nop')->title('Number Of Parcels'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Members_' . date('YmdHis');
    }
}
