<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class LikeNotification extends Notification
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


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'user_name' => Auth::user()->name,
            'message' => 'Liked your post',
            'post_title' => $this->post->title,
            'type' => 'like'
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_name' => Auth::user()->name,
            'message' => 'Liked your Post',
            'post_title' => $this->post->title,
            'type' => 'like'
        ]);
    }

    public function broadcastType(){
        return 'post_liked';
    }





}
