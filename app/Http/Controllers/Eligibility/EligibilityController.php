<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;

class EligibilityController extends Controller
{
    public function index()
    {
        return view('eligibility.index');
    }
}
