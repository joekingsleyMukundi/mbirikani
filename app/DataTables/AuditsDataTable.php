<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AuditsDataTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('user', function($row){
                $user = "";
                if(isset($row->user)){
                    $user=$row->user->name;
                }else{
                    $user="Visitor";
                }

                return $user;
            })
            ->addColumn('type', function($row){

                if(class_basename($row->auditable_type) == "Allocation"){
                    return "Allotment";
                }else if(class_basename($row->auditable_type) == "SubAsset"){
                    return "Parcel";
                }else if(class_basename($row->auditable_type) == "Asset"){
                    return "Group Ranch";
                }else{
                    return class_basename($row->auditable_type);
                }

            })
            ->addColumn('old', function($row){
                return json_encode($row->old_values);
            })
            ->addColumn('new', function($row){
                return json_encode($row->new_values);
            });
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Audit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Audit $model)
    {
        return $model::with('user')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('audits-table')
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
            Column::make('id'),
            Column::make('user'),
            Column::make('type'),
            Column::make('old'),
            Column::make('new'),
            Column::make('ip_address'),
            Column::make('user_agent'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Audits_' . date('YmdHis');
    }
}
