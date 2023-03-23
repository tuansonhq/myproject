<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;
use Validator;
use Carbon\Carbon;
use Cache;
use JWTAuth;
use App\Library\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\ActivityLog;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:4|max:30|regex:/^([A-Za-z0-9])+$/i',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6|max:32|string|min:6|confirmed',
            ],[
                'username.required' => __("Tài khoản không được để trống."),
                'username.min' => __("Tên tài khoản ít nhất 4 ký tự."),
                'username.max' => __("Tên tài khoản không quá 30 ký tự."),
                'username.regex'	=> __('Tên tài khoản không ký tự đặc biệt.'),
                'password.required' => __('Vui lòng nhập mật khẩu'),
                'password.min'		=> __('Mật khẩu phải ít nhất 6 ký tự.'),
                'password.max'		=> __('Mật khẩu không vượt quá 32 ký tự.'),
                'password.confirmed' => __('Mật khẩu xác nhận không đúng'),
                'email.required' => 'Vui lòng nhập trường này',
                'email.email' => 'Địa chỉ email không đúng định dạng.',
                'email.unique' => 'Địa chỉ email đã được sử dụng.',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 0
                ],400);
            }

            $username = $request->username;
            $email = $request->email;
            // kiểm tra username
            $checkUsername = User::where('username',$username)->first();

            if($checkUsername){
                return response()->json([
                    'message' => 'Tên tài khoản đã được đăng kí',
                    'status' => 0,
                ], 200);
            }
            $user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($request->password),
                'status' => 1,
            ]);

            ActivityLog::add($request,"Đăng nhập frontend thành công");
            $token = JWTAuth::fromUser($user);
            $data = User::where('id',$user->id)->where('status',1)
                ->select('id','username','email')->first();
            return response()->json([
                'message' => 'Đăng kí tài khoản thành công.',
                'status' => 1,
                'token' => $token,
                'user' => $data,
                'exp_token' => config('jwt.ttl') * 60,
            ], 200);
        }
        catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response()->json([
                    'message' => 'Tên tài khoản đã được đăng kí',
                    'status' => 0
                ], 200);
            }
            return response()->json([
                'message' => 'Lỗi hệ thống.',
                'status' => -1
            ], 500);
        }
    }
}
