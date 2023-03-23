<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'order';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'params' => 'object',
    ];

    protected $fillable = [
        'bill_code',
        'author_id',
        'membership_id',
        'title',
        'description',
        'content',
        'price_total',
        'price_of_prepayment',
        'params',
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

    public function membership(){
        return $this->hasOne(Membership::class,'id','membership_id');
    }

    public function txns()
    {
        return $this->morphOne(Txns::class, 'txnsable');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {

        });
    }
}
