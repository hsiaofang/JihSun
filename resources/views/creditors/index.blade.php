<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>債權人總表</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>

<body>

    <div class="container mt-5">
        <div class="mb-3">
            <a href="{{ route('creditors.create') }}" class="btn btn-dark-orange">新增</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>債權人</th>
                    <th>總金額</th>
                    <th>動作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedCreditors as $name => $group)
                    <tr>
                        <td>{{ $group['name'] }}</td>
                        <td>{{ number_format($group['total_amount']) }}</td>
                        <td>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded" onclick="toggleDetails('{{ $name }}')">
                                查看詳情
                            </button>
                        </td>
                    </tr>
                    <tr id="details-{{ $name }}" class="details-panel">
                        <td colspan="3">
                            <table class="table">
                                <tbody>
                                    @foreach($group['details'] as $detail)
                                        <tr>
                                            <td>日期：{{ $detail->created_at->format('Y-m-d') }}</td>
                                            <td>金額：{{ number_format($detail->amount) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>