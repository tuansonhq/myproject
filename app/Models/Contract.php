<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contracts';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'params' => 'object',
    ];

    protected $fillable = [
        'customer_id',
        'author_id',
        'title',
        'description',
        'content',
        'price',
        'url_type',
        'params',
        'started_at',
        'ended_at',
        'status',
        'created_at',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users(){
        return $this->hasOne(User::class,'id','author_id');
    }

    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {

        });
    }
}
