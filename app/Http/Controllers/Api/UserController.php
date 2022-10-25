<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user(Request $request)
    {

        $profile = Auth::guard("web");
        dd($profile);
        $contact = (new Crm())->getContactDetail($profile->contact_id);
        return response()->json($contact, 200);
    }

    public function changePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if (Auth::user()->check_temporary) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Mật khẩu cũ không đúng !!!');
                        }
                    } else {
                        if (!Hash::check($value, Auth::user()->temporary_password)) {
                            $fail('Mật khẩu cũ không đúng !!!');
                        }
                    }
                },
            ],
            'password' => 'required|min:6|confirmed'
        ]);
        dd($request->all());
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        $user = Auth::user();
        $user->check_temporary = 1;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi mật khẩu thành công'
        ]);
    }
}
