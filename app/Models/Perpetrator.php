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
        'age_class',
        'education',
        'address',
        'marital_status',
        'occupation',
        'incident_date',
        'suicide_method',
        'suicide_tool',
        'motive',
        'description',
        'district_code',
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

    public function genderCriteria()
    {
        return $this->belongsTo(Criteria::class, 'gender');
    }

    public function ageClassCriteria()
    {
        return $this->belongsTo(Criteria::class, 'age_class');
    }

    public function educationCriteria()
    {
        return $this->belongsTo(Criteria::class, 'education');
    }

    public function maritalStatusCriteria()
    {
        return $this->belongsTo(Criteria::class, 'marital_status');
    }

    public function occupationCriteria()
    {
        return $this->belongsTo(Criteria::class, 'occupation');
    }

    public function motiveCriteria()
    {
        return $this->belongsTo(Criteria::class, 'motive');
    }
}
