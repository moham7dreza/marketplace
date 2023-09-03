<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'parent_id',
        'body',
        'seen',
        'approved',
    ];

    protected $casts = [
        'approved' => StatusEnum::class,
        'seen' => StatusEnum::class,
    ];

    public function scopeSeen($query): mixed
    {
        return $query->where('seen', StatusEnum::active->value);
    }

    public function scopeApproved($query): mixed
    {
        return $query->where('approved', StatusEnum::active->value);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('answers');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo($this, 'parent_id');
    }
}
