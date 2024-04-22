<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\StaffType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class StaffTypeDataTable extends BaseDataTable
{
    public function __construct(StaffType $model)
    {
        $columns = [
            Column::make('id'),
            Column::make('name'),
            Column::make('description'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('view')->exportable(false)->printable(false)->width(60),
            Column::computed('edit')->exportable(false)->printable(false)->width(60),
            Column::computed('delete')->exportable(false)->printable(false)->width(60),
        ];
        parent::__construct($model, $columns);
    }

    /**
     * Build the DataTable class.
     * @param QueryBuilder $query Results from query() method
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))->setRowId('id');

        $dataTable->addColumn('edit', function ($staffType) {
            /* @var StaffType $staffType */
            return '<a href="' . route('staff-type.edit', $staffType->id) . '" class="btn btn-sm btn-primary mr-1">Edit</a>';
        });
        $dataTable->addColumn('view', function ($staffType) {
            /* @var StaffType $staffType */
            return '<a href="' . route('staff-type.show', $staffType->id) . '""class="btn btn-sm btn-success mr-1">View</a>';
        });
        $dataTable->addColumn('delete', function ($staffType) {
            /* @var StaffType $staffType */
            return '<form method="POST" action="' . route('staff-type.destroy', $staffType->id) . '" onsubmit="return confirm(\'Are you sure you want to delete this user?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>';
        });

        $dataTable->editColumn('created_at', function ($staffType) {
            /* @var StaffType $staffType */
            return $staffType->created_at->format('Y-m-d H:i:s'); // Adjust the date format as needed
        });
        $dataTable->editColumn('updated_at', function ($staffType) {
            /* @var StaffType $staffType */
            return $staffType->created_at->format('Y-m-d H:i:s'); // Adjust the date format as needed
        });

        $dataTable->rawColumns(['edit', 'view', 'delete']);

        return $dataTable;
    }


    public function html(): HtmlBuilder
    {
        $htmlBuilder = parent::html();
//        $htmlBuilder->orderBy(3);
        return $htmlBuilder;
    }
}
