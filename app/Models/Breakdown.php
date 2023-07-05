<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;



class Breakdown extends Model
{
    use HasFactory/*, SoftDeletes*/;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'breakdown',
        'solution',
        'description',
    ];

    public function requests(): BelongsToMany
    {
        return $this->BelongsToMany(Request::class, 'breakdown_requests', 'breakdown_id', 'request_id');
    }
}
