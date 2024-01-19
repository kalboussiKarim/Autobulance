<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServiceEquipment extends Model
{
    use HasFactory/*, SoftDeletes*/;
    protected $fillable = [
        'quantity',
        'service_id',
        'equipment_id',
        'task_id'
    ];
}
