<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
        'admin_reply',
        'replied_at',
        'replied_by'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Chờ xử lý',
            'replied' => 'Đã trả lời',
            'closed' => 'Đã đóng',
            default => 'Chờ xử lý'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'replied' => 'success',
            'closed' => 'secondary',
            default => 'warning'
        };
    }
}