<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'is_paid',
        'file_url'
    ];

    public function rating()
    {
        return $this->hasOne(Rating::class, 'service_id', 'service_id')->where('user_id', auth()->user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
