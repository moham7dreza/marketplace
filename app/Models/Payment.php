<?php

namespace App\Models;

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount',
        'user_id',
        'status',
        'type',
        'gateway',
        'pay_at',
        'transaction_id',
        'details',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'gateway' => PaymentGatewayEnum::class,
        'type' => PaymentTypeEnum::class,
        'details' => 'json'
    ];

    public function scopeUnpaid($query): mixed
    {
        return $query->where('status', PaymentStatusEnum::not_paid->value);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
