<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importez la classe BelongsTo
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory/*, SoftDeletes*/;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'autobulance_id',
        'request_id',
        'state'
    ];
   public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function autobulance(): BelongsTo
    {
        return $this->belongsTo(Autobulance::class, 'autobulance_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(ServiceEquipment::class, 'task_id')
            ->join('services', 'service_equipment.service_id', '=', 'services.id');
            
    }
}
