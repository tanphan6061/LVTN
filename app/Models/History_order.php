<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getTextAttribute()
    {
        $text = [
            'cancel' => 'đã hủy',
            'processing' => 'đang chờ xác nhận',
            'shipping' => 'đang vận chuyển',
            'delivered' => 'đã giao hàng',
        ];
        return $text[$this->status];
    }
}
