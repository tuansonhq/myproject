<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Log;
use Carbon\Carbon;
use Cache;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Library\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\ActivityLog;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LoginController extends Controller
{
    public function login(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ],[
                'username.required' => __("username không được để trống."),
                'password.required' => __("Bạn chưa mật khẩu."),
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 0
                ],422);
            }

            $username = $request->username;
            $user = User::where('username',$username)
                ->where('status', 1)
                ->select('id','username','email','password')
                ->first();

            if(!$user){
                return response()->json([
                    'message' => __('Tài khoản hoặc mật khẩu không đúng.'),
                    'status' => 0
                ], 401);
            }

            if ($user && \Hash::check($request->password, $user->password)) {
                $refresh_token = null;
                Cache::put('last_login', Carbon::now(), 1440);
                ActivityLog::add($request,"Đăng nhập thành công");
                $token = JWTAuth::fromUser($user);
                // trường hợp có yêu cầu nhớ mật khẩu
                if($request->filled('remember_token')){
                    $refresh_token = Helpers::Encrypt($token.time(),config('jwt.secret'));
                    $exp_token_refresh = Carbon::now()->addMinutes(config('jwt.refresh_ttl'));
                    $user->refresh_token = $refresh_token;
                    $user->exp_token_refresh = $exp_token_refresh;
                    $user->save();
                }
                return response()->json([
                    'message' => 'Đăng nhập thành công.',
                    'status' => 1,
                    'token' => $token,
                    'token_type' => 'bearer',
                    'refresh_token' => $refresh_token,
                    'exp_token' => config('jwt.ttl') * 60,
                    'user' => $user,
                ], 200);
            }
            else{
                return response()->json([
                    'message' => __('Tài khoản hoặc mật khẩu không đúng.'),
                    'status' => 0
                ], 401);
            }
        }
        catch (JWTException $e) {
            return response()->json([
                'message' => 'Lỗi hệ thống.',
                'status' => -1
            ], 500);
        }
    }

    public function logout(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
            ],[
                'token.required' => __("token không được để trống."),
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 0
                ],422);
            }
            $user = Auth::guard('api')->user();
            if(!$user){
                return response()->json([
                    'message' => __('Tài khoản hoặc mật khẩu không đúng.'),
                    'status' => 0
                ], 401);
            }
            $user->refresh_token = null;
            $user->exp_token_refresh = null;
            $user->save();
            JWTAuth::invalidate($request->token);
            ActivityLog::add($request,"Đăng xuất thành công");
            return response()->json([
                'message' => 'Đăng xuất thành công.',
                'status' => 1
            ], 200);
        }
        catch (JWTException $e) {
            return response()->json([
                'message' => 'Lỗi hệ thống.',
                'status' => -1
            ], 500);
        }
    }

    public function refreshTokenRemember(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'refresh_token' => 'required',
            ],[
                'refresh_token.required' => __("refresh_token không được để trống."),
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 0
                ],422);
            }
            $refresh_token = $request->refresh_token;
            $time_now = Carbon::now();
            $user = User::whereNotNull('refresh_token')
                ->where('refresh_token',$refresh_token)
                ->where('status', 1)
                ->select('id','username','email','exp_token_refresh')
                ->first();


            if(!$user){
                return response()->json([
                    'message' => __('Token không tồn tại trên hệ thống.'),
                    'status' => 0
                ], 200);
            }
            if(strtotime($time_now) > strtotime($user->exp_token_refresh)){
                $user->refresh_token = null;
                $user->exp_token_refresh = null;
                $user->save();
                return response()->json([
                    'message' => __('Token đã hết hiệu lực.'),
                    'status' => 0
                ], 200);
            }
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'message' => 'Refresh thành công.',
                'status' => 1,
                'token' => $token,
                'exp_token' => config('jwt.ttl') * 60,
                'user' => $user,
            ], 200);
        }
        catch(TokenInvalidException $e){
            return response()->json([
                'message' => "Lỗi hệ thống.",
                'status' => -1
            ]);
        }
    }

    public function refresh_token(Request $request){
        $token = $request->token;
        try{
            $token = JWTAuth::refresh($token);
            return response()->json([
                'message' => 'Refresh thành công.',
                'status' => 1,
                'token' => $token,
                'exp_token' => config('jwt.ttl') * 60,
            ], 200);
        }
        catch(TokenInvalidException $e){
            return response()->json([
                'message' => "Lỗi hệ thống.",
                'status' => -1
            ]);
        }
    }

}
