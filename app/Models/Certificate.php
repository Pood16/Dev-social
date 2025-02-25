<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'issuer',
        'issue_date',
        'credential_url',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_certificates');
    }
}
