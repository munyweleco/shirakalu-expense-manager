<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('edit', function ($user) {
                return '<a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-primary mr-1">Edit</a>';
            })
            ->addColumn('view', function ($user) {
                return '<a href="'.route('users.show', $user->id).'""class="btn btn-sm btn-success mr-1">View</a>';
            })
            ->addColumn('delete', function ($user) {
                return '<button type="button" class="btn btn-sm btn-danger delete-user" data-toggle="modal" data-target="#delete-user-modal" data-id="'.$user->id.'">Delete</button>';
            })
//            ->addColumn('action', function ($user) {
//                return '<a href="/users/'.$user->id.'/edit" class="btn btn-danger btn-sm">Edit</a>';
//            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('Y-m-d H:i:s'); // Adjust the date format as needed
            })
            ->editColumn('updated_at', function ($user) {
                return $user->created_at->format('Y-m-d H:i:s'); // Adjust the date format as needed
            })
            ->rawColumns(['edit', 'view', 'delete'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
//                Button::make('excel'),
                Button::make('csv'),
//                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->exportable(false)->printable(false),
            Column::make('name')->title('Staff Name'),
            Column::make('email'),
            Column::make('created_at')->title('Created'),
            Column::make('updated_at')->title('Updated'),
            Column::computed('view') ->exportable(false)->printable(false)->width(60),
            Column::computed('edit') ->exportable(false)->printable(false)->width(60),
            Column::computed('delete') ->exportable(false)->printable(false)->width(60),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
