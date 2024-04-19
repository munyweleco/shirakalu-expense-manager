<?php

namespace App\DataTables\Base;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as DataTableService;

class CustomDataTable extends DataTableService
{
    protected $model;
    protected ?array $columns;

    public function __construct($model, $columns)
    {
        $this->model = $model;
        $this->columns = $columns;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query));

        foreach ($this->columns as $column) {
            $dataTable->addColumn($column->name, $column->title);
        }

        return $dataTable;
    }

    public function query(Model $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $tableId = $this->model->getTable() . '-table';

        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons($this->getButtons());
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    protected function filename(): string
    {
        return $this->model->getTable() . '_' . date('YmdHis');
    }

    protected function getButtons(): array
    {
        return [
            Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
    }
}
