<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $reports = Report::when($tanggal, function ($query) use ($tanggal) {
            return $query->where('Tanggal', $tanggal);
        })->orderBy('Tanggal', 'desc')->get();

        return view('laporan', compact('reports', 'tanggal'));
    }
}
