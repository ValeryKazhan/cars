<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'created_by'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


}
