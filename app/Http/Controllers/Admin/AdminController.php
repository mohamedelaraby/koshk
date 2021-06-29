<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(){
        return view('admin.dashboard');
    }

    /**
     *  Render admins datatable iew
     * @param AdminDatatable $admin
     * @return mixed
     */
    public function index(AdminDatatable $admin) {
        $title = trans('admin.dashboard');
        return $admin->render('admin.admins.index',['title' =>$title]);
    }
}
