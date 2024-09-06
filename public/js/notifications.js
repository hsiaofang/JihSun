import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '927e826437124db45fca',
    cluster: 'ap3',
    encrypted: true,
    wsHost: 'ws.pusherapp.com',
    wsPort: 443,
    disableStats: true
});

Pusher.logToConsole = true;

window.Echo.channel('main-hurricane-774')
    .listen('.RepaymentNotification', (event) => {
        console.log('Received event:', event);
        alert(`Debt payment due today for ${event.debtor_name}: ${event.monthly_payment_amount}`);

        let notificationArea = document.getElementById('notification-area');
        if (notificationArea) {
            notificationArea.innerHTML += `<p>${event.debtor_name} needs to pay ${event.monthly_payment_amount} today.</p>`;
        }
    });

console.log('Notification script loaded successfully');
