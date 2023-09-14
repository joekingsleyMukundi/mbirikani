<?php

namespace App\DataTables;
use App\Models\SubAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Html\Button;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubAssetDataTable extends DataTable
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
            ->addColumn('hectares', function($row){
               return round($row->acres/2.4710538146717,2);
            })
            ->addColumn('acres', function($row){
                return round($row->acres,2);
            })
            ->filterColumn('uses_name', function($query, $keyword) {
               
                $query->orWhere('asset_uses.name', 'like', '%'. $keyword . '%');
            })
            ->filterColumn('area_name', function($query, $keyword) {
                $query->orWhere('areas.name', 'like', '%'. $keyword . '%');
               
            })
            ->addColumn('actions', function($row){
                $btn = "";
                if (Auth::user()->can('subassets:update')) {
                    $btn = '<a href="'.route('dashboard.subassets.edit', $row->id).'" class="m-1 btn btn-info btn-sm"><i class="fa fa-pen"></i></a>';
                }
                if (Auth::user()->can('subassets:delete')) {
                    $btn = $btn.'<button class="m-1 btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-id="'.$row->id.'" data-name="'.'Survey No '.$row->survey_no.'"><i class="fa fa-trash"></i></button>';
                }

                return $btn;
            })->rawColumns(['actions']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SubAsset $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $posts = SubAsset::join('areas', 'sub_assets.area_id', '=', 'areas.id')
            ->join('asset_uses', 'areas.asset_use_id', '=', 'asset_uses.id')
            ->join('assets', 'sub_assets.asset_id', '=', 'assets.id')
            ->select('sub_assets.id', 'sub_assets.member_id', 'sub_assets.survey_no', 'sub_assets.parcel_no', 'sub_assets.asset_id',
                'sub_assets.area_id', 'areas.name as area_name', 'asset_uses.name as uses_name', 'assets.name as asset_name',
                DB::raw('ROUND(sub_assets.acres, 2) as acres'), DB::raw('ROUND(sub_assets.acres/2.4710538146717, 2) as hectares'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('subasset-table')
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
            //Column::make('asset.name')->title('Group Ranch'),
            Column::make('uses_name')->title('Land Category'),
            Column::make('area_name')->title('Area'),
            Column::make('hectares'),
            Column::make('acres'),
            Column::make('survey_no'),
            Column::make('parcel_no')->title('Title No'),
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
