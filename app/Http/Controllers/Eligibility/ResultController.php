<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Models\Result;

class ResultController extends Controller
{
    public function index()
    {
        $data = Result::query()->with(['alternative'])->orderBy('value')->get();

        return view('eligibility.result', compact('data'));
    }
}
