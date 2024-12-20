<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'status', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
{
    return $this->hasMany(Payment::class);
}


}
