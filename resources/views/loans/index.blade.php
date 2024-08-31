<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>借款列表</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="button-group mb-4">
            <a href="{{ route('loans.create') }}" class="btn btn-dark-orange">新增</a>
            <a href="{{ route('loans.current-month') }}" class="btn btn-dark-orange">當月應繳</a>

            <form id="search-form" class="flex items-center space-x-2" method="GET">
                <input type="text" name="search" class="form-input custom-input" placeholder="搜尋債務人"
                    value="{{ request()->get('search') }}">
                <button class="btn custom-button" type="submit">
                    <i class="bi bi-search"></i> 搜尋
                </button>
                @if(request()->has('search'))
                    <button id="clear-search" class="btn custom-button-outline" onclick="clearSearch()">
                        清除搜尋
                    </button>
                @endif
            </form>




        </div>

        <div id="create-form-container" class="mb-4" style="display: none;">
            @include('layouts.app')
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>借款日期</th>
                    <th>債務人</th>
                    <th>本金</th>
                    <th>還款方式</th>
                    <th>分期期數</th>
                    <th>年利率</th>
                    <th>月付總額</th>
                    <th>備註</th>
                    <th>動作</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->loan_date }}</td>
                        <td class="debtor-name" data-loan-id="{{ $loan->id }}">{{ $loan->debtor_name }}</td>
                        <td>
                            <div class="input-group">
                                <span class="loan-amount">{{ number_format($loan->loan_balance) }}</span>
                                <input type="text" class="form-control" value="{{ number_format($loan->loan_amount) }}"
                                    style="display: none;">
                                <i class="bi bi-check-circle save-icon" data-loan-id="{{ $loan->id }}"
                                    data-field="loan_amount" style="cursor: pointer; display: none;"></i>
                                <i class="bi bi-pencil edit-icon" data-field="loan_amount" style="cursor: pointer;"></i>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="repayment-method">
                                    @if($loan->repayment_method === 'principal_and_interest')
                                        本利攤
                                    @elseif($loan->repayment_method === 'interest_only')
                                        純繳息
                                    @else
                                        {{ $loan->repayment_method }}
                                    @endif
                                </span>
                                <input type="text" class="form-control"
                                    value="@if($loan->repayment_method === 'principal_and_interest') 本利攤 @elseif($loan->repayment_method === 'interest_only') 純繳息 @else {{ $loan->repayment_method }} @endif"
                                    style="display: none;">
                                <i class="bi bi-check-circle save-icon" data-loan-id="{{ $loan->id }}"
                                    data-field="repayment_method" style="cursor: pointer; display: none;"></i>
                                <i class="bi bi-pencil edit-icon" data-field="repayment_method"
                                    style="cursor: pointer;"></i>
                            </div>
                        </td>
                        <td class="installments">{{ $loan->installments }}</td>
                        <td>{{ $loan->interest_rate }}</td>
                        <td>{{ number_format($loan->monthly_payment_amount) }}</td>
                        <td>{{ $loan->notes }}</td>
                        <td class="p-3">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded" data-loan-id="{{ $loan->id }}"
                                onclick="showDetails('{{ $loan->id }}')">查看詳情</button>
                        </td>
                    </tr>
                    <tr id="details-row{{ $loan->id }}" class="details-panel">
                        <td colspan="9">
                            <div class="border border-gray-300 p-3 rounded bg-gray-50">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td colspan="4">
                                                <h3>債務人資料</h3>
                                            </td>
                                        </tr>
                                        @if($loan->debtorDetail)
                                            <tr class="info-row">
                                                <td>電話: {{ $loan->debtorDetail->phone ?? '无' }}</td>
                                                <td>地址: {{ $loan->debtorDetail->address ?? '无' }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td colspan="4">
                                                <h3>債權人</h3>
                                            </td>
                                        </tr>
                                        @forelse($loan->creditors as $creditor)
                                            <tr>
                                                <td>姓名: {{ $creditor->name ?? '无' }}</td>
                                                <td>金額: {{ number_format($creditor->pivot->amount) ?? '无' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>



                @endforeach
            </tbody>
        </table>

        <div id="pagination-links">
            {{ $loans->links() }}
        </div>

        <div id="details-container" class="mt-4" style="display: none;">
            <div id="creditorDetails"></div>
        </div>
    </div>
</body>

</html>