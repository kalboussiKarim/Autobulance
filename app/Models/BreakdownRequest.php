<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class BreakdownRequest extends Model
{
    use HasFactory/*, SoftDeletes*/;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'request_id',
        'breakdown_id',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
    public function breakdown(): BelongsTo
    {
        return $this->belongsTo(Breakdown::class, 'breakdown_id');
    }
}
