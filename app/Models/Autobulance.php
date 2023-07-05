<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autobulance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>  
     */
    protected $fillable = [
        'state_id',
        'matricule',
        'phone',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'transaction_reparateurs', 'autobulance_id', 'staff_id');
    }
}
