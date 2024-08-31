<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>還款紀錄</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>

<body>
    <div class="container mt-5">
        <div class="mb-3">
            <a href="{{ route('repayments.create') }}" class="btn btn-dark-orange btn-spacing">新增</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>還款日期</th>
                    <th>債務人</th>
                    <th>還款金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repayments as $repayment)
                    <tr>
                        <td>{{ $repayment->payment_date }}</td>
                        <td>{{ $repayment->loan->debtor_name }}</td>
                        <td>{{ number_format($repayment->payment_amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>