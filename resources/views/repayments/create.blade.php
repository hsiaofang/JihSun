<style>
    .btn-align-right {
        position: relative;
        height: 50px;
    }

    .btn-align-right .btn {
        position: absolute;
        right: 0;
        bottom: 0;
        background-color: #E67E22;
        color: white;
        border-color: #E67E22;
    }
</style>

@extends('layouts.app')

@section('title', '新增還款記錄')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('repayments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="loan_id">選擇貸款</label>
            <select name="loan_id" class="form-control" required>
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}">
                        {{$loan->loan_date}}{{ $loan->debtor_name }} - {{ number_format($loan->loan_amount) }} -
                        {{ $loan->repayment_method == 'principal_and_interest' ? '本利攤' : '純繳息' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="payment_amount">還款金額</label>
            <input type="number" name="payment_amount" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="payment_date">還款日期</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>
        <div class="btn-align-right">
            <button type="submit" class="btn btn-dark-orange btn-spacing">提交</button>
        </div>
    </form>
</div>
@endsection