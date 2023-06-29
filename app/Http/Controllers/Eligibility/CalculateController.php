<?php

namespace App\Http\Controllers\Eligibility;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Result;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class CalculateController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            Result::query()->truncate();

            // Matrix Keputusan (X)
            $matrix_x = array();
            $criterias = Criteria::query()->get();
            $alternatives = Alternative::query()->with(['scores', 'scores.criteria'])->get(['id', 'name']);

            foreach ($alternatives as $alternative) {
                foreach ($alternative->scores as $score) {
                    $value = $score->value;

                    // save value to matrix keputusan
                    $matrix_x[$score->criteria_id][$alternative->id] = $value;
                }
            }

            // Matrix Normalisasi (X)
            $value_x = array();
            foreach ($alternatives as $alternative) {
                foreach ($alternative->scores as $score) {
                    $current_value = $matrix_x[$score->criteria_id][$alternative->id];

                    $max_value = @(max($matrix_x[$score->criteria_id]));
                    $min_value = @(min($matrix_x[$score->criteria_id]));

                    try {
                        $result = ($max_value-$current_value)/($max_value-$min_value);
                    } catch (\Throwable $th) {
                        $result = 0.0;
                    }

                    // save result to matrix normalisasi
                    $value_x[$score->criteria_id][$alternative->id] = round($result, 3);
                }
            }

            // Matrix Normalisasi (R)
            $matrix_r = array();
            // Nilai S
            $value_s = array();
            foreach ($alternatives as $alternative) {
                $total_r = 0;
                foreach ($criterias as $criteria) {
                    $weight = $criteria->weight;
                    $current_value = $value_x[$criteria->id][$alternative->id];

                    $r = $current_value * $weight;

                    $matrix_r[$criteria->id][$alternative->id] = round($r, 3);
                    $total_r += round($r, 3);
                }
                $value_s[$alternative->id] = floatval($total_r);
            }

            // Nilai R
            $value_r = array();
            foreach ($alternatives as $alternative) {
                $max_value = @(max($matrix_r[$alternative->id]));

                $value_r[$alternative->id] = floatval($max_value);
            }

            // Nilai Qi
            $value_q = array();
            foreach ($alternatives as $alternative) {
                $current_s = $value_s[$alternative->id];
                $current_r = $value_r[$alternative->id];
                $max_s = floatval(max($value_s));
                $min_s = floatval(min($value_s));
                $max_r = floatval(max($value_r));
                $min_r = floatval(min($value_r));

                $v = 0.5;
                $v1 = $current_s - $min_s;
                $v2 = $max_s - $min_s;
                $v3 = $current_r - $min_r;
                $v4 = $max_r - $min_r;

                $div1 = $v1 / $v2;
                $div2 = $v3 / $v4;

                $result1 = $div1 * $v;
                $result2 = $div2 * (1 - $v);
                $q = $result1 + $result2;
                $value_q[$alternative->id] = round($q, 4);
            }

            foreach ($alternatives as $alternative) {
                $result = Result::query()->create([
                    'alternative_id' => $alternative->id,
                    'value' => $value_q[$alternative->id]
                ]);
            }

            DB::commit();

            $data = [
                [
                    'title' => "Matrix Keputusan (X)",
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $matrix_x
                ],
                [
                    'title' => 'Normalisasi Matrix (X)',
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $value_x
                ],
                [
                    'title' => 'Bobot Kriteria (W)',
                    'type' => 0,
                    'hide_name' => true,
                    'show' => 'horizontal',
                    'value' => $criterias->pluck('weight')
                ],
                [
                    'title' => 'Matrix Normalisasi (R)',
                    'type' => 0,
                    'show' => 'vertical',
                    'value' => $matrix_r
                ],
                [
                    'header' => 'R',
                    'title' => 'Nilai R',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'horizontal',
                    'value' => $value_r
                ],
                [
                    'header' => 'S',
                    'title' => 'Nilai S',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'horizontal',
                    'value' => $value_s
                ],
                [
                    'header' => [
                        'S<sup>+</sup>',
                        'S<sup>-</sup>',
                        'R<sup>+</sup>',
                        'R<sup>-</sup>'
                    ],
                    'title' => 'Nilai S dan R',
                    'hide_name' => true,
                    'type' => 0,
                    'show' => 'horizontal',
                    'value' => [
                        floatval(max($value_s)),
                        floatval(min($value_s)),
                        floatval(max($value_r)),
                        floatval(min($value_r))
                    ]
                ],
                [
                    'header' => [
                        'No', 'Alternatif', 'Nilai Q'
                    ],
                    'title' => 'Nilai Qi',
                    'hide_name' => true,
                    'type' => 1,
                    'show' => 'vertical',
                    'value' => $value_q
                ]
            ];

            return view('eligibility.calculate', compact(
                'alternatives',
                'criterias',
                'data'
            ));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
