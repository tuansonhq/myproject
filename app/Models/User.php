<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DateTime;
use DateTimeInterface;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'username',
        'account_type',
        'google2fa_secret',
        'email_verified_at',
        'password',
        'status',
        'lastlogin_at',
        'lastlogout_at',
        'created_by',
        'created_at',
        'ip_allow',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'refresh_token',
        'token',
        'exp_token_refresh',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

//    public function can($ability, $arguments = [])
//    {
//        if($this->hasRole('admin')){
//            return true;
//        }
//        $allow = app(Gate::class)->forUser($this)->check($ability, $arguments);
//        if($allow === true){
//            $permission = $this->getAllPermissions()->toArray();
//            return $this->permissionAuthorize($permission,$ability);
//        }
//        return false;
//    }
//    public function permissionAuthorize($permissions,$ability){
//        $shop_permission = $this->shopPermission();
//        if($shop_permission === false){
//            return false;
//        }
//        foreach($permissions as $key => $permission){
//            if(is_array($ability)){
//                foreach ($ability as $item_a){
//                    if($permission['name'] === $item_a){
//                        switch ($this->getPermissionType($permission)){
//                            case config('permission.access_type.allow'): return true;
//                            case config('permission.access_type.deny'): return false;
//                            default :
//                                return false;
//
//                        }
//                    }
//                }
//            }
//            else{
//                if($permission['name'] === $ability){
//                    switch ($this->getPermissionType($permission)){
//                        case config('permission.access_type.allow'): return true;
//                        case config('permission.access_type.deny'): return false;
//                        default :
//                            return false;
//
//                    }
//                }
//            }
//        }
//        return false;
//    }
//    public function shopPermission(){
//        $shop_id = session('shop_id');
//        if(empty($shop_id)){
//            return true;
//        }
//        if(isset($this->shop_expect)){
//            $shop_expect = json_decode( $this->shop_expect);
//            if(in_array($shop_id,$shop_expect)){
//                return false;
//            }
//        }
//        if(isset($this->group_shop_access)){
//            $group_shop_access = json_decode($this->group_shop_access);
//            $ids_shop = $this->getIdsShop($group_shop_access);
//            if(!in_array($shop_id,$shop_expect)){
//                return false;
//            }
//        }
//        if(isset($this->group_shop_access)){
//            if($this->shop_access != 'all'){
//                $shop_access = json_decode($this->shop_access);
//                if(!in_array($shop_id,$shop_access)){
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
//    public function getPermissionType($permission){
//        return $permission['pivot']['access_type'];
//    }
}
