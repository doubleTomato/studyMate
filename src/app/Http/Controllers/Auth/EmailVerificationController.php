<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Members;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Str;


class EmailVerificationController extends Controller
{
    // 인증코드 생성 및 이메일 발송
    public function sendCode(Request $request){
        $request -> validate(['email' => 'required|email']);
        $email = $request -> email;

        $is_duplicate = Members::where('email', $email)->exists();
        if(!$is_duplicate){
            /// 6자리 랜덤 숫자 코드 생성
            $code = str_pad(random_int(0,999999), 6, '0', STR_PAD_LEFT);

            // ematil_verifications 테이블에 코드 저장 및 존재 시 업데이트
            DB::table('email_verifications')->updateOrInsert(
                ['email' => $email],
                ['code' => $code, 'created_at' => now()]
            );

            // 이메일 전송
            try{
                Mail::to($email)->send(new VerificationCodeMail($code));
                return response() -> json(['msg' => '인증 코드가 발송되었습니다.']);
            }catch(\Exception $e){
                // 에러 리턴
                return response() -> json(['msg' => '이메일 발송에 실패하였습니다. 다시 시도해주세요.', 'err' => $e -> getMessage()],500);
            }
        }else{
             return response() -> json(['msg' => '이미 가입된 이메일입니다.', 'status' => 'duplicate']);
        }
    }

    public function verifyCode(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        $is_verification = DB::table('email_verifications')
        ->where('email', $request->email)
        ->where('code', $request->code)
        ->first();

        if($is_verification){
            // 인증이 되었다면 세션에 인증된 이메일 저장
            session(['verified_email' => $request->email]);
            // 확인 완료된 코드는 db에서 제거
            DB::table('email_verifications')->where('email', $request->email)->delete();

            return response()->json(['msg'=>'성공적으로 인증되었습니다.']);
        }
        return response()->json(['msg'=>'인증 코드가 올바르지 않습니다. 다시 확인해주세요.'], 422);
    }

}
