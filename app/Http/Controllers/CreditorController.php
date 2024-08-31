<?php

namespace App\Http\Controllers;

use App\Models\Creditor;
use Illuminate\Http\Request;

class CreditorController extends Controller
{
    public function index(Request $request)
    {
        $creditors = Creditor::all();

        // 按名字分組
        $groupedCreditors = $creditors->groupBy('name')->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'total_amount' => $group->sum('amount'),
                'details' => $group,
            ];
        });
        // dd($groupedCreditors);

        return view('creditors.index', ['groupedCreditors' => $groupedCreditors]);
    }





    public function create()
    {
        return view('creditors.create');
    }
    public function store(Request $request)
    {
        Creditor::create([
            'name' => $request->input('creditor_name'),
            'amount' => $request->input('creditor_amount'),
        ]);

        return redirect()->route('creditors.create')->with('success', '新增成功');
    }
}
