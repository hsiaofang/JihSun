@extends('layouts.app')

@section('title', '新增債權人')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('creditors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="creditor_name">債權人名稱</label>
            <input type="text" name="creditor_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="creditor_amount">金額</label>
            <input type="text" name="creditor_amount" class="form-control" required>
        </div>
        <div class="btn-align-right">
            <button type="submit" class="btn btn-dark-orange btn-spacing">提交</button>
        </div>
    </form>
</div>
@endsection