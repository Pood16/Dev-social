
const auth_user = document.querySelector('meta[name="user-id"]').content;

Pusher.logToConsole = true;
var pusher = new Pusher('acf224ac549a10c8b5e9', {
    cluster: 'mt1',
    encrypted: true
});
// Subscribe to channels
var comment_Channel = pusher.subscribe('comment-channel');
var like_Channel = pusher.subscribe('like-channel');
// Listen for events
// comment event
comment_Channel.bind('comment.notification', function(data) {
    if (data.state) {
        if (parseInt(auth_user) === parseInt(data.post_owner_id)) {
            if(typeof fetchNotifications === 'function') {
                fetchNotifications();
            }
            toastr.info(
                `<div class="notification-content">
                    <i class="fas fa-user"></i> <span>${data.author}</span>
                    <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.content}</span>
                </div>`,
                'New Comment on your post',
                {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 0,
                    extendedTimeOut: 0,
                    positionClass: 'toast-top-right',
                    enableHtml: true
                }
            );
        }
    }
});


//like event
like_Channel.bind('like.notification', function(data) {
    if (data.actor && data.post) {
        if (parseInt(auth_user) === parseInt(data.post_owner_id)){
            console.log(data);
            toastr.info(
                `<div class="notification-content">
                    <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.post} By</span>
                    <i class="fas fa-user"></i> <span>${data.actor}</span>
                </div>`,
                'New Like on your post',
                {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 0,
                    extendedTimeOut: 0,
                    positionClass: 'toast-top-right',
                    enableHtml: true
                }
            );
        }
    } else {
        console.error('Invalid data received:', data);
    }
});
pusher.connection.bind('connected', function() {
    console.log('Pusher connected');
});
