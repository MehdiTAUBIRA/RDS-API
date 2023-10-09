<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $table = 'asset';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'asset_url',
        'asset_type',
        'asset_source',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
