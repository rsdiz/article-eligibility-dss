<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EligibilityController extends Controller
{
    public function index(Request $request)
    {
        return view('eligibility.index');
    }

}
