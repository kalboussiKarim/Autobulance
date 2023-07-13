<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;
    protected $fillable = [
        'latitude',
        'longitude',
        'autobulance_id'
    ];
    public function autobulance(): BelongsTo
    {
        return $this->belongsTo(Autobulance::class,'autobulance_id');
    }
}
