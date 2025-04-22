<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantViewController extends Controller
{
    public function dashboard()
    {
        return view('tenant.dashboard');
    }
}