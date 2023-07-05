<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class TransactionReparateur extends Model
{
    use HasFactory/*, SoftDeletes*/;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'autobulance_id',
        'affected_at',
        'detached_at'

    ];
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function autobulance(): BelongsTo
    {
        return $this->belongsTo(Autobulance::class, 'autobulance_id');
    }
}
