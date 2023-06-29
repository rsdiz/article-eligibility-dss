<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Score;
use Illuminate\Http\Request;
use DataTables;

class ScoreController extends Controller
{
    public function index()
    {
        $data = Result::query()->with(['alternative'])->orderBy('value')->get();

        return view('eligibility.score', compact('data'));
    }
}
