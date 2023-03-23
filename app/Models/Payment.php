<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payment';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'params' => 'object',
    ];

    protected $fillable = [
        'title',
        'description',
        'content',
        'params',
        'status',
        'created_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {

        });
    }
}
