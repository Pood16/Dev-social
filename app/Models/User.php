<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'cover_picture',
        'bio',
        'linkedin',
        'portfolio',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Like::class);
    }

    public function hasLiked($postId){
        return $this->likes()->where('post_id', $postId)->where('like', true)->exists();
    }
    public function hasDisLiked($postId){
        return $this->likes()->where('post_id', $postId)->where('like', false)->exists();
    }


    public function toggleLikeDislike($postId, $like){
        // Check if the like/dislike already exists
        $existingLike = $this->likes()->where('post_id', $postId)->first();

        if ($existingLike) {
            if ($existingLike->like == $like) {
                $existingLike->delete();

                return [
                    'hasLiked' => false,
                    'hasDisliked' => false
                ];
            } else {
                $existingLike->update(['like' => $like]);
            }
        } else {
            $this->likes()->create([
                'post_id' => $postId,
                'like' => $like,
            ]);
        }

        return [
            'hasLiked' => $this->hasLiked($postId),
            'hasDisliked' => $this->hasDisliked($postId)
        ];
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }



    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function certificates() {
        return $this->hasMany(Certificate::class);
    }

    public function sentConnections(){
        return $this->hasMany(Connection::class, 'user_id');
    }

    public function receivedConnections(){
        return $this->hasMany(Connection::class, 'follower_id');
    }

    public function connections() {
        return $this->hasMany(Connection::class);
    }



    public function getAllConnections() {
        return Connection::where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id)
            ->where('status', 'accepted');
    }


    public function isConnectedWith(User $user) {
        return Connection::where(function($query) use ($user) {
                $query->where('sender_id', $this->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $this->id);
            })
            ->where('status', 'accepted')
            ->exists();
    }


    /**
     * Get the messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'from_user_id');
    }

    /**
     * Get the messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'to_user_id');
    }




}
