<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory, Notifiable, HasUuids , HasApiTokens;
    protected $keyType = 'string';
    public $incrementing = false;

        protected $fillable = [
        'sender_id',
        'receiver_id',
        'text'
    ];
 
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
 
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
