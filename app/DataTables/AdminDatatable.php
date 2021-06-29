<?php

namespace App\DataTables;

use App\Models\Admin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminDatatable extends DataTable
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
            ->addColumn('actions', 'admins.btn.actions')
            ->rawColumns(['actions'])
            ->addColumn('code',function(User $user){
                return $this->userCode($user);
            })
            ->addColumn('phone',function(User $user){
                if(!$user->phone ){
                    return "Add Phone number";
                } else {
                    return $user->phone;
                }
            })
            ->editColumn('created_at',function(User $user){
                return $user->created_at->diffForHumans();
            })
            ->editColumn('updated_at',function(User $user){
                return $user->updated_at->diffForHumans();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\UserDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return User::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('userdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->getParameters());
    }

    /**
     * Get Parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return [
            'dom'  => 'Blfrtip',
            'lengthMenu' => [[10,25,50,100],[10,25,50,100,trans('admin.all_records')] ],

            'buttons' =>$this->getButtons(),
            'initComplete' => "function () {
                this.api().columns([1,2,3,4,5]).every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }",

            'language' => datatable_lang(),
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getButtons()
    {
        return  [
            ['extend'=>'reload','className'=>'btn btn-primary my-2','text'=>'<i class="fa fa-print"></i>  '.trans('admin.ex_reload')],
            ['extend'=>'print','className'=>'btn btn-primary my-2','text'=>'<i class="fa fa-print"></i>  '.trans('admin.ex_print')],
            ['extend'=>'excel',
                'className'=>'btn btn-success my-2',
                'text'=>'<i class="fas fa-table"></i> '. trans('admin.ex_excel')
            ],
            ['extend'=>'csv',
                'className'=>'btn btn-info my-2',
                'text'=>'<i class="fa fa-file"></i>  '. trans('admin.ex_csv')
            ],
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'data' => 'id',
                'name' => 'id',
                'title' => trans('admin.user_id')
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'title' => trans('admin.user_name')
            ],

            [
                'data' => 'phone',
                'name' => 'phone',
                'title' => trans('admin.user_phone')
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'title' => trans('admin.user_email')
            ],
            [
                'data' => 'code',
                'name' => 'code',
                'title' => trans('admin.user_code')
            ],



            Column::computed('actions')
                ->title(trans('admin.options'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(20)
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
        return 'Admin_' . date('YmdHis');
    }
}
