<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class HistoryController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        return view('history.index', compact('loans'));
    }
}
