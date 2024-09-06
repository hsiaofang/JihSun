function showDetails(id) {
    const detailsRow = document.getElementById(`details-row${id}`);

    if (!detailsRow) {
        return;
    }

    if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
        detailsRow.style.display = 'table-row';
    } else {
        detailsRow.style.display = 'none';
    }
}




function toggleDetails(name) {

    const detailsPanel = document.getElementById('details-' + name);

    if (detailsPanel) {
        if (detailsPanel.style.display === 'none' || detailsPanel.style.display === '') {
            detailsPanel.style.display = 'table-row';
        } else {
            detailsPanel.style.display = 'none';
            console.log('Hiding details for:', name);  
        }
    } else {
        console.error('Details panel not found for name:', name);
    }
}


// Laravel Echo configuration
// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '927e826437124db45fca',
//     cluster: 'ap3',
//     encrypted: true, // 确保使用 HTTPS
//     wsHost: 'ws.pusherapp.com',
//     wsPort: 443,
//     disableStats: true
// });

// window.Echo.channel('main-hurricane-774')
//     .listen('.RepaymentNotification', (event) => {
//         console.log('Received event:', event);
//         alert(`Debt payment due today for ${event.message.debtor_name}: ${event.message.monthly_payment_amount}`);
        
//         let notificationArea = document.getElementById('notification-area');
//         if (notificationArea) {
//             notificationArea.innerHTML += `<p>${event.message.debtor_name} needs to pay ${event.message.monthly_payment_amount} today.</p>`;
//         }
//     });


