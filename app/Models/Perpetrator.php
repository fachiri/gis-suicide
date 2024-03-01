<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Perpetrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'age',
        'education',
        'address',
        'marital_status',
        'occupation',
        'incident_date',
        'suicide_method',
        'suicide_tool',
        'description',
        'latitude',
        'longitude'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            if (!$model->exists) {
                $model->uuid = (string) Uuid::uuid4();
            }
        });
    }
}
