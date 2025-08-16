<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;


class DashboardController extends Controller
{   
    public function index(){
        $branches = Branch::all();
        return view('pages.dashboard',compact('branches'));
    }
}
