<?php

namespace App\DataTables;

use App\Models\Exercise;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable;

class ExerciseDataTable extends DataTables
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'users.datatables_actions');  // Puedes definir la acción como botones.
    }

    public function query(Exercise $model)
    {
        return $model->newQuery()->select('id', 'name', 'email', 'created_at');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')  // ID de la tabla en la vista
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    protected function getColumns()
    {
        return [
            'id',
            'name',
            'email',
            'created_at',
            'action'
        ];
    }

    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
