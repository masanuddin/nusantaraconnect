<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'vendor_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public static function getOrCreate($customerId, $vendorId)
    {
        return self::firstOrCreate(
            ['customer_id' => $customerId, 'vendor_id' => $vendorId]
        );
    }
}
