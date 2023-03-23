<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            config('permission.table_names.role_has_permissions'),
            'role_id',
            'permission_id'
        )->withPivot('access_type');
    }

    public function group_user()
    {
        return $this->morphedByMany(
            GroupUser::class,
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            config('permission.column_names.model_morph_key')
        );
    }
}
