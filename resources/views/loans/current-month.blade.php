@extends('layouts.app')

@section('title', '當月應收款項')

@section('content')
<div class="container mt-4">
    <h1>{{ $currentDate->format('Y年m月') }}</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>借款日期</th>
                <th>債務人</th>
                <th>月付總額</th>
                <th>動作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('Y-m-d') }}</td>
                    <td>{{ $loan->debtor_name }}</td>
                    <td>{{ number_format($loan->monthly_payment_amount) }}</td>
                    <td>{{ $loan->action }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">沒有符合條件的貸款記錄</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right"><strong>總利息金額</strong></td>
                <td>{{ number_format($totalInterest) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection