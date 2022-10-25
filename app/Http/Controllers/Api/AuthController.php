<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Microservices\Crm;

class AuthController extends Controller
{
    function searchAccount(Request $request)
    {
        $email_phone = $request->email_phone;
        $crmModel = new Crm();
        $data = $crmModel->findContact($email_phone);
        if (!$data) return response()->json(['data' => []], 200);
        return response()->json(['data'=> $data],200);
    }

    public function register(Request $request)
    {
        $userTempModel = new  UserTemp();
        $str_value = $request->email_phone ?? '';
        if (empty($str_value)) {
            return response()->json(['status' => 'error', 'message' => 'Email hoặc phone không được để trống']);
        }
        $crm = new Crm();
        $check = $crm->findContact($str_value);
        if (!empty($check)) return response()->json(['status' => 'error', 'message' => 'Email hoặc phone đã tồn tại trong hệ thống']);

        $mailFormat = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
        $type = preg_match($mailFormat, $str_value) ? 'email' : 'phone';

        $user_temp_id = $userTempModel->create([
            "$type" => $request->email,
            'type' => $type,
            'fullname' => $request->fullname ?? ''
        ]);
        $data = array('user_id' => $user_temp_id, 'action_type' => 'register', 'type' => $type);
        // Bắn event_sendOtp
        return response()->json(['status' => 'success', 'user_temp_id' => $userTempModel]);
    }

    function verifyRegister(Request $request)
    {
        $userTempModel = new UserTemp();
        $otpModel = new Otp();
        $action_type = 'register';
        $user_id = $request->user_id;
        $otp = $request->otp;
//        $check = Otp::checkCodeOTP($user_id, $action_type, $otp);
//        if ($check['status']){
        $contactModel = new Contact();
        $user_temp = $userTempModel->detail($user_id);
        if (empty($user_temp)) return response()->json(['status' => false, 'message' => 'Server error !!!'], 500);
        $data = collect($user_temp)->only(['email', 'phone', 'fullname' , 'address', 'avatar']);

//        $contact = $contactModel->create($data);
        $contact = (new Crm())->getContactDetail();

        $password_randdom = substr(md5(time()), 0, 10);

        $user = User::firstOrCreate(
            ['_id' => 123456],
            [
                'password' => '',
                'is_cache' => 0,
                'password_cache' => Hash::make($password_randdom)
            ]
        );

        return response()->json(['status' => 'true', 'username' => $user['_id'], 'password' => $password_randdom], 200);
    }

    function forgotPassword(Request $request)
    {
        $str_value = $request->email_phone;
        if (empty($str_value)) {
            return response()->json(['status' => 'error', 'message' => 'Email hoặc phone không được để trống']);
        }
        $crm = new Crm();
        $contact = $crm->findContact($request->email_phone);
        if (empty($contact)) {
            return response()->json(['status' => false, 'message' => 'Email hoặc phone không tồn tại trong hệ thống']);
        }
        $user = User::firstOrCreate(
            ['_id' => $contact['contact_id']],
            [
                'id' => $contact['contact_id'],
                'password' => '',
                'is_cache' => 0,
                'password_cache' => ''
            ]
        );
        // dis pass event gửi OTP qua  mail or phone
        $mailFormat = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
        $type = preg_match($mailFormat, $str_value) ? 'email' : 'phone';
        $data = array('user_id' => $user->id, 'action_type' => 'forgot_password', 'type' => $type);
        return response()->json([
            'status' => true,
            'user_id' => $user->id,
            'action_type' => 'forgot_password'
        ]);
    }

    function postForgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'contact_id' => 'required',
            'action_type' => 'required',
            'otp' => 'required',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }
//        $otp = Otp::where(array('action_type' => $request->action_type, 'otp_code' => $request->otp, 'user_id' => $request->user_id))->first();
//        if (empty($otp)) {
//            return response()->json(['status' => false, 'message' => 'Mã otp không hợp lệ'], 400);
//        }
        try {
            $user = User::where('_id', (int) $request->contact_id)->first();
            $password_randdom = substr(md5(time()), 0, 10);
            $user->update([
                'password' => '',
                'is_cache' => 0,
                'password_cache' =>  Hash::make($password_randdom)
            ]);
            return response()->json(['status' => true, 'username' => $user->id, 'password' => $password_randdom], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
    }

}
