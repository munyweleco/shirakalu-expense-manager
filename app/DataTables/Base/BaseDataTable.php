<?php

namespace App\DataTables\Base;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as DataTableService;


abstract class BaseDataTable extends DataTableService
{
    protected Model $model;
    protected array $columns;
    protected array $actionColumns = [];


    public function __construct(Model $model, array $columns)
    {
        $this->model = $model;
        $this->columns = $columns;
        parent::__construct();
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    abstract public function dataTable(QueryBuilder $query): EloquentDataTable;

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return static::class . '_' . date('YmdHis');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->getTableId())
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->buttons($this->getButtons());
    }

    /**
     * Get the table ID.
     */
    protected function getTableId(): string
    {
        return strtolower(class_basename(static::class)) . '-table';
    }

    /**
     * Get the columns for the data table.
     */
    protected function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Get the buttons for the data table.
     */
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
