import { ajaxRequest } from './ajax.js';

export function setupEventListeners() {
    console.log('setupEventListeners called');
    console.log('Window Routes:', window.routes);


    $('#create-loan').click(function (event) {
        event.preventDefault();
        console.log('Create Loan button clicked');  // 用于调试

        ajaxRequest(
            window.routes.createLoan,
            'GET',
            null,
            function (data) {
                $('.container').html(data);  // 使用返回的视图内容更新页面
            },
            function () {
                alert('請刷新頁面');
            }
        );
    });

    $('#current-month-loan').click(function () {
        ajaxRequest(
            window.routes.currentMonthLoan,
            'GET',
            null,
            function (data) {
                $('.container').html(data);
            },
            function () {
                alert('請刷新頁面');
            }
        );
    });

    $('#search-form').submit(function (event) {
        event.preventDefault();
        var query = $(this).serialize();
        ajaxRequest(
            window.routes.indexLoans,
            'GET',
            query,
            function (data) {
                $('#table-body').html($(data).find('#table-body').html());
                $('#pagination-links').html($(data).find('#pagination-links').html());
            },
            function () {
                alert('請刷新頁面');
            }
        );
    });

    $(document).on('click', '#pagination-links a', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        ajaxRequest(
            url,
            'GET',
            null,
            function (data) {
                $('#table-body').html($(data).find('#table-body').html());
                $('#pagination-links').html($(data).find('#pagination-links').html());
            },
            function () {
                alert('請刷新頁面');
            }
        );
    });

    $(document).on('click', '.edit-icon', function () {
        var $cell = $(this).parent();
        var currentValue = $cell.text().trim();
        var $input = $('<input type="text" class="form-control" value="' + currentValue + '"/>');

        $cell.addClass('editing');
        $cell.html($input);
        $cell.append('<i class="bi bi-check-circle save-icon" style="cursor: pointer; margin-left: 3px; display: inline;"></i>');
        $input.focus();
        $(this).hide();
    });

    $(document).on('click', '.save-icon', function () {
        var $cell = $(this).parent();
        var newValue = $cell.find('input').val();
        var loanId = $(this).data('loan-id');
        var field = $(this).data('field');

        $cell.removeClass('editing');
        $cell.html(newValue);
        $(this).hide();
        $(this).siblings('.edit-icon').show();

        ajaxRequest(
            window.routes.updateLoan.replace(':id', loanId),
            'POST',
            {
                field: field,
                value: newValue
            },
            function (response) {
                alert('更新成功！');
            },
            function (xhr) {
                console.log(xhr.responseText);
                alert('請聯絡客服');
            }
        );
    });

    $(document).on('click', '.btn-info', function () {
        var loanId = $(this).data('loan-id');

        ajaxRequest(
            window.routes.creditors.replace(':id', loanId),
            'GET',
            null,
            function (data) {
                console.log('Creditors Data:', data);
                var creditorHtml = '';
                if (data && data.length > 0) {
                    data.forEach(function (creditor) {
                        creditorHtml +=
                            '<div class="creditor-item">' +
                            '<h5>債權人</h5>' +
                            '<strong>' + creditor.name + '</strong><br>' +
                            '金額：' + creditor.amount + '<br>' +
                            '</div>';
                    });
                } else {
                    creditorHtml = '<p>無債權人信息</p>';
                }
                $('#creditorDetails').html(creditorHtml);
                $('#creditorModal').modal('show');
            },
            function () {
                alert('請刷新頁面');
            }
        );
    });
}

// 初始化事件監聽器
$(document).ready(function() {
    setupEventListeners();
});
