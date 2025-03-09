import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Enable Pusher debugging
Pusher.logToConsole = true;

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // Add auth details for private channels
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    }
});

console.log('Echo initialized with key:', import.meta.env.VITE_PUSHER_APP_KEY);


// const user_id = document.querySelector('meta[name="user-id"]').content;
// window.Echo.private(`App.Models.User.${user_id}`)
//     .notification((notification) => {
//         // console.log(notification.type);
//         switch (notification.type) {
//             case 'post_liked':
//                 alert('New-like!');
//                 break;
//             case 'post_commented':
//                 console.log(notification.data);
//                 break;
//         }
//     });
