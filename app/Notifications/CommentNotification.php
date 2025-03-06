<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CommentNotification extends Notification
{
    use Queueable;
    protected $post;


    /**
     * Create a new notification instance.
     */
    public function __construct($post)
    {
        $this->post = $post;

    }


    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }



    public function toDatabase(object $notifiable): array
    {
        return [
            'user_name' => Auth::user()->name,
            'message' => 'Has commented on your post',
            'post_title' => $this->post->title,
            'type' => 'comment'
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage( [
            'user_name' => Auth::user()->name,
            'message' => 'Has commented on your post',
            'post_title' => $this->post->title,
            'type' => 'comment'
        ]);
    }

    public function broadcastType(){
        return 'post_commented';
    }

}
