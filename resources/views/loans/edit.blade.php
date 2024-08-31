@extends('layout')

@section('content')
<h1>Edit Loan</h1>
<form action="{{ route('loans.update', $loan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="loan_date">借款日期</label>
        <input type="date" name="loan_date" class="form-control" value="{{ $loan->loan_date }}" required>
    </div>
    <div class="form-group">
        <label for="debtor_id">Debtor</label>
        <select name="debtor_id" class="form-control" required>
            @foreach($debtors as $debtor)
                <option value="{{ $debtor->id }}" {{ $debtor->id == $loan->debtor_id ? 'selected' : '' }}>{{ $debtor->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="loan_amount">Loan Amount</label>
        <input type="number" name="loan_amount" class="form-control" step="0.01" value="{{ $loan->loan_amount }}"
            required>
    </div>
    <div class="form-group">
        <label for="interest_rate">Interest Rate</label>
        <input type="number" name="interest_rate" class="form-control" step="0.01" value="{{ $loan->interest_rate }}"
            required>
    </div>
    <div class="form-group">
        <label for="notes">Notes</label>
        <textarea name="notes" class="form-control">{{ $loan->notes }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection