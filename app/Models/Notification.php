<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at'
    ];
    
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
    
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
    
    public function getIconAttribute()
    {
        return match($this->type) {
            'welcome' => '🎉',
            'login_success' => '🔐',
            'password_reset' => '🔑',
            'new_review' => '⭐',
            'order_created' => '🛒',
            'order_status_updated' => '📦',
            'new_product' => '🆕',
            'product_sale' => '🔥',
            default => '🔔'
        };
    }
    
    public function getColorAttribute()
    {
        return match($this->type) {
            'welcome' => '#4CAF50',
            'login_success' => '#2196F3',
            'password_reset' => '#FF9800',
            'new_review' => '#9C27B0',
            'order_created' => '#4CAF50',
            'order_status_updated' => '#2196F3',
            'new_product' => '#FF9800',
            'product_sale' => '#F44336',
            default => '#9E9E9E'
        };
    }
}
