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

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM fully loaded and parsed');

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '927e826437124db45fca',
            cluster: 'ap3',
            encrypted: true
        });
        console.log(window.Echo);


        window.Echo.channel('main-hurricane-774')
            .listen('RepaymentNotification', (e) => {
                console.log('Event received:', e);
                console.log('Message:', e.message);

            });
    });
</script>
@endsection