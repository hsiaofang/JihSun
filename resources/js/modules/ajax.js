export function ajaxRequest(url, method, data, successCallback, errorCallback) {
    console.log('Sending AJAX request to:', url);
    $.ajax({
        url: url,
        method: method,
        data: data,
        success: successCallback,
        error: errorCallback
    });
}
