<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Microservices\Crm;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    function checkLogin(Request $request)
    {
        $request->validate(['email_phone' =>  'required'], ['email_phone.required' => 'Tài khoản không được để trống !!!']);
        // // $crm = new Crm();
        // // $contact = $crm->findContact($request->email_phone);
        // if (empty($contact)) {
        //     return back()->with('notification_error', 'Không tìm thấy tài khoản của bạn !!!');
        // }
        if (empty($contact)) {
            /// kiểm tra xem contact thuộc login microsoft hay google
            return redirect()->route('login.socialite', ['attr' => 'microsoft']);
        } else {
            return back()->withInput()->with('notification_error', 'Tài khoản không tồn tại trong hệ thống');
        }
    }






    public function viewRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $userTempModel = new UserTemp();
        $crm = new Crm();
        $request->validate([
            'email' => [
                'required',
                function ($attribute, $value, $fail) use ($crm) {
                    $contact = $crm->findContact($value);
                    if (!empty($contact)) {
                        $fail('The ' . $attribute . ' exist in the system.');
                    }
                },
            ],
        ]);
        $mailFormat = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
        $type = preg_match($mailFormat, $request->email) ? 'email' : 'phone';
        try {
            $user_temp_id = $userTempModel->create([
                "$type" => $request->email,
                'type' => $type,
                'fullname' => $request->fullname ?? ''
            ]);
            $data = ['user_id' => $user_temp_id, 'action_type' => 'register', 'type' => $type];
            //            SendOtp::dispatch([
            //                'data' => array('user_id' => $user->id, 'action_type' => 'register', 'type' => $type),
            //                'action' => 'create'
            //            ]);
            return redirect()->route('verify.otp', array_merge($data, ['callback' => route('verify.register', ['id' => $user_temp_id])]));
        } catch (\Exception $ex) {
            return back();
        }
    }

    public function verifyRegister($id, Request $request)
    {
        $otpModel = new Otp();
        $userTempModel = new UserTemp();
        $action_type = 'register';

        //        $check_otp = $otpModel->validate_otp($id, $action_type, $request->code);

        //        if (!$check_otp['status']) {
        //            return back()->with('notification_error', $check_otp['message']);
        //        }
        $userTemp = $userTempModel->detail($id);

        if (empty($userTempModel)) {
            return back()->with('notification_error', 'Otp does not exists !!!');
        }
        $data = collect($userTemp)->only(['email', 'phone', 'fullname', 'address', 'avatar']);

        //        $contactModel = new Contact();
        //        $contact = $contactModel->create($data);

        $password_randdom = substr(md5(time()), 0, 10);

        $user = User::firstOrCreate(
            ['_id' => 123456],
            [
                'password' => '',
                'is_cache' => 0,
                'password_cache' => Hash::make($password_randdom)
            ]
        );
        Auth::login($user);
        return redirect()->route('home')->with('temporary_password', $password_randdom);
    }


    public function forgotPassword()
    {
    }

    public function verifyForgotPassword()
    {
    }

    function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
