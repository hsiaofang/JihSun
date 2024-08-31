@extends('layout')

@section('content')
<h1>Edit Repayment</h1>
<form action="{{ route('repayments.update', $repayment->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="loan_id">Loan</label>
        <select name="loan_id" class="form-control" required>
            @foreach($loans as $loan)
                <option value="{{ $loan->id }}" {{ $loan->id == $repayment->loan_id ? 'selected' : '' }}>
                    {{ $loan->loan_date }} - {{ $loan->debtor->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="payment_date">Payment Date</label>
        <input type="date" name="payment_date" class="form-control" value="{{ $repayment->payment_date }}" required>
    </div>
    <div class="form-group">
        <label for="payment_amount">Payment Amount</label>
        <input type="number" name="payment_amount" class="form-control" step="0.01"
            value="{{ $repayment->payment_amount }}" required>
    </div>
    <div class="form-group">
        <label for="notes">Notes</label>
        <textarea name="notes" class="form-control">{{ $repayment->notes }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection