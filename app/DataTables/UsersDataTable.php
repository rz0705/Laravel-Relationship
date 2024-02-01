<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return datatables($query)
            ->addColumn('phone', function ($user) {
                return optional($user->phone)->phone ?? 'N/A';
            })
            ->addColumn('action', 'users.action')
            ->setRowId('id');
    }

    public function query(User $model): \Illuminate\Database\Eloquent\Builder
    {
        $model = $model->with('phone');
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('add'),
                Button::make('excel')
                    ->text('Excel')
                    ->addClass('btn btn-success'),
                Button::make('csv')
                    ->text('CSV')
                    ->addClass('btn btn-info'),
                Button::make('pdf')
                    ->text('PDF')
                    ->addClass('btn btn-danger'),
                Button::make('print')
                    ->text('Print')
                    ->addClass('btn btn-primary'),
                Button::make('reset')
                    ->text('Reset')
                    ->addClass('btn btn-warning'),
                Button::make('reload')
                    ->text('Reload')
                    ->addClass('btn btn-secondary'),
            ]);
    }

    protected function getColumns(): array
    {
        return [Column::make('id'), Column::make('name'), Column::make('email'), Column::make('phone')];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
