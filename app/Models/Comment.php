<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comments';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'params' => 'object',
    ];

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'membership_id',
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

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function user_value_able()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {

        });
    }
}
