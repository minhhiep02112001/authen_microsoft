<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtpController extends Controller
{
    function index(Request $request)
    {
        $url = $request->callback ?? '';
        if (empty($url)) {
            return redirect()->route('login');
        }
        return view('auth.otp', compact('url'));
    }

    function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'action_type' => 'required',
            'type' => 'required',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        $otp = Otp::where([
            'user_id' => $request->user_id,
            'action_type' => $request->action_type,
            'type' => $request->type,
        ])->first();
        if (empty($otp)) {
            return response()->json(['message' => 'OTP lỗi'], 500);
        }
        if ($otp->count_send >= 5) {
            return response()->json(['message' => 'Bạn đã gửi quá số lần cho phép của chúng tôi'], 404);
        }
        SendOtp::dispatch([
            'data' => array('user_id' => $request->user_id, 'action_type' => $request->action_type, 'type' => $request->type,),
            'action' => 'update'
        ]);
        return response()->json(['message' => 'Kiểm tra và nhận mã xác nhận'], 200);
    }

    function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'action_type' => 'required',
            'code' => 'required',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        $otp = $request->code;
        $action_type = $request->action_type;
        $user_id = $request->user_id;
        return Otp::checkCodeOTP($user_id, $action_type, $otp);
    }
}
