<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping_location extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'shipping_locations';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [

    ];

    protected $fillable = [
        'order_id',
        'customer_id',
        'membership_id',
        'order_type',
        'title',
        'description',
        'content',
        'pick_up_image',
        'return_image',
        'price',
        'payment_id',
        'delivery_date',
        'started_at',
        'ended_at',
        'status',
        'created_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function membership(){
        return $this->hasOne(Membership::class,'id','membership_id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class,'id','payment_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {

        });
    }
}
