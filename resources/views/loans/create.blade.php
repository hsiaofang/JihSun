@extends('layouts.app')

@section('title', '新增借款')

@section('content')
@if(session('success'))
    <div class="alert alert-success mt-3 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger mt-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mx-auto px-4 py-6 min-h-screen flex flex-col">
    <form action="{{ route('loans.store') }}" method="POST" class="flex-1">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div class="form-group">
                <label for="loan_date" class="block text-sm font-medium text-gray-700">借款日期</label>
                <input type="date" name="loan_date" id="loan_date"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="form-group">
                <label for="repayment_method" class="block text-sm font-medium text-gray-700">還款方式</label>
                <select name="repayment_method" id="repayment_method"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    <option value="principal_and_interest">本利攤</option>
                    <option value="interest_only">純繳息</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div class="form-group">
                <label for="debtor_name" class="block text-sm font-medium text-gray-700">債務人</label>
                <input type="text" name="debtor_name" id="debtor_name"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="form-group">
                <label for="phone" class="block text-sm font-medium text-gray-700">電話</label>
                <input type="text" name="phone" id="phone"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div class="form-group">
                <label for="address" class="block text-sm font-medium text-gray-700">地址</label>
                <input type="text" name="address" id="address"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="form-group">
                <label for="loan_amount" class="block text-sm font-medium text-gray-700">借款金額</label>
                <input type="number" name="loan_amount" id="loan_amount"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" step="0.01" required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div class="form-group">
                <label for="installments" class="block text-sm font-medium text-gray-700">分期期數</label>
                <input type="number" name="installments" id="installments"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" step="1" min="1">
            </div>
            <div class="form-group">
                <label for="interest_rate" class="block text-sm font-medium text-gray-700">年利率</label>
                <input type="number" name="interest_rate" id="interest_rate"
                    class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" step="0.01" required>
            </div>
        </div>
        <div class="form-group mb-4">
            <label for="creditors-container" class="block text-sm font-medium text-gray-700">債權人</label>
            <div id="creditors-container">
                @for($i = 0; $i < 4; $i++)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <div class="form-group">
                            <label for="creditor_id_{{ $i + 1 }}" class="block text-sm font-medium text-gray-700">債權人
                                {{ $i + 1 }}</label>
                            <select name="creditors[{{ $i }}][creditor_id]" id="creditor_id_{{ $i + 1 }}"
                                class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                <option value="">請選擇</option>
                                @foreach($creditors as $creditor)
                                    <option value="{{ $creditor->id }}">{{ $creditor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount_{{ $i + 1 }}" class="block text-sm font-medium text-gray-700">金额</label>
                            <input type="number" name="creditors[{{ $i }}][amount]" id="amount_{{ $i + 1 }}"
                                class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm" step="0.01">
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="form-group mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">備註</label>
            <textarea name="notes" id="notes"
                class="form-control block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
        </div>
        <div class="btn-align-right">
            <button type="submit" class="btn btn-dark-orange px-4 py-2 rounded-md hover:bg-orange-600">提交</button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var loanAmountInput = document.getElementById('loan_amount');
        var interestRateInput = document.getElementById('interest_rate');
        var totalAmountInput = document.getElementById('total_amount');

        function updateTotalAmount() {
            var loanAmount = parseFloat(loanAmountInput.value) || 0;
            var interestRate = parseFloat(interestRateInput.value) || 0;

            var totalAmount = loanAmount * (1 + interestRate / 100);
            if (totalAmountInput) {
                totalAmountInput.value = totalAmount.toFixed(2);
            }
        }

        loanAmountInput.addEventListener('input', updateTotalAmount);
        interestRateInput.addEventListener('input', updateTotalAmount);
    });
</script>
@endsection