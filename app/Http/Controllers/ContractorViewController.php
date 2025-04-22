<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractorViewController extends Controller
{
    public function dashboard()
    {
        return view('contractor.dashboard');
    }
}