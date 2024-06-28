<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use illuminate\Contracts\view\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    function index() : View {
        return view('admin.dashboard.index');
    }
}
