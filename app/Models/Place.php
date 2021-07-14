<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
class Place extends Model
{
    use HasFactory, SpatialTrait;

    protected $fillable = [
        'name'
    ];

    protected $spatialFields = [
        'location',
        'area'
    ];
}
