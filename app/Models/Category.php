<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'image'
    ];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }



}
