<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;

class Txns extends BaseModel
{

    //Bảng biến động số dư của user
    protected $table = 'txns';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'order_id',
        'customer_id',
        'membership_id',
        'payment_id',
        'title',
        'description',
        'content',
        'amount',
        'status',
        'created_at'
    ];


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


    public function txnsable()
    {
        return $this->morphTo();
    }



    public static function boot()
    {
        parent::boot();

        //set default auto add  scope to query
        static::addGlobalScope('global_scope', function (Builder $model) {
            //$model->where('txns.shop_id', session('shop_id'));
        });
        static::saving(function ($model) {
            $model->ip = \Request::getClientIp();
        });
        //end set default auto add  scope to query

    }



}
