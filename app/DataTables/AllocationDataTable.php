<?php

namespace App\DataTables;

use App\Models\AssetUse;
use App\Models\SubAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AllocationDataTable extends DataTable
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
            ->filterColumn('area_name', function($query, $keyword) {
                $query->where('areas.name',"LIKE" , "%".$keyword."%");
            })
            ->filterColumn('uses_name', function($query, $keyword) {
                $query->where('asset_uses.name',"LIKE" , "%".$keyword."%");
            })
            ->filterColumn('member_name', function($query, $keyword) {
                $query->where('members.first_name',"LIKE" ,"%".$keyword."%")->orWhere('members.last_name',"LIKE" , "%".$keyword."%");
            })
            ->filterColumn('hectares', function($query, $keyword) {

            })
            ->addColumn('actions', function($row){
                $btn = "";
                if (Auth::user()->can('allocations:update')) {
                    $btn = '<a href="'.route('dashboard.allocations.edit', $row->id).'" class="m-1 btn btn-info btn-sm"><i class="fa fa-pen"></i></a>';
                }
                if (Auth::user()->can('members:read')) {
                    $btn = $btn.'<a href="'.route('dashboard.members.profile', $row->member_id).'" class="m-1 btn btn-info btn-sm"><i class="fa fa-user"></i></a>';
                }
                if (Auth::user()->can('allocations:delete')) {
                    $btn = $btn.'<button class="m-1 btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-id="'.$row->id.'" data-name="'.$row->id.' '.$row->id.'"><i class="fa fa-trash"></i></button>';
                }

                return $btn;
            })->rawColumns(['member_name','actions']);
    }
    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $posts = SubAsset::join('members', 'sub_assets.member_id', '=', 'members.id')
            ->join('areas', 'sub_assets.area_id', '=', 'areas.id')
            ->join('asset_uses', 'areas.asset_use_id', '=', 'asset_uses.id')
            ->join('assets', 'sub_assets.asset_id', '=', 'assets.id')
            ->select('sub_assets.id', 'sub_assets.member_id', 'sub_assets.survey_no', 'sub_assets.parcel_no', 'sub_assets.asset_id',
                'sub_assets.area_id', 'areas.name as area_name', 'asset_uses.name as uses_name', 'assets.name as asset_name', 'members.first_name', 'members.last_name',
                DB::raw('ROUND(sub_assets.acres, 2) as acres'), DB::raw('ROUND(sub_assets.acres/2.4710538146717, 2) as hectares'),
                DB::raw('CONCAT(members.first_name," ",members.last_name) as member_name'))->whereNotNull('sub_assets.parcel_no');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('allocations-table')
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
            //Column::make('asset_name')->title('Group Ranch'),
            Column::make('uses_name')->title('Land Category'),
            Column::make('area_name')->title('Area'),
            Column::make('hectares'),
            Column::make('acres'),
            Column::make('survey_no'),
            Column::make('member_name')->title('Member'),
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
        return 'Allocations_' . date('YmdHis');
    }
}
