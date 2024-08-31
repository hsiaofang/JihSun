<table class="table table-bordered">
    <thead>
        <tr>
            <th>編號</th>
            <th>借款日期</th>
            <th>債務人</th>
            <th>借款金額</th>
            <th>分期期數</th>
            <th>利率</th>
            <th>總利息金額</th>
            <th>備註</th>
        </tr>
    </thead>
    <tbody>
        @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->id }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->debtor_name }}</td>
                <td>{{ $loan->loan_amount }}</td>
                <td>{{ $loan->installments }}</td>
                <td>{{ $loan->interest_rate }}</td>
                <td>{{ $loan->interest_amount }}</td>
                <td>{{ $loan->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>