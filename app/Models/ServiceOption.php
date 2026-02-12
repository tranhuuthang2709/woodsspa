<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'duration',
        'price_vnd',
        'sale_price_vnd',
        'price_usd',
        'sale_price_usd',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
