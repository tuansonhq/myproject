<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public function children() {
        return $this->hasMany(static::class, 'parent_id');
    }
    public function grandChildren()
    {
        return $this->children()->with('grandChildren');
    }
    public function parents()
    {
        return $this->belongsTo(self::class,'parent_id');
    }
    public function grandParent()
    {
        return $this->parents()->with('grandParent');
    }
}
