<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\RegistrationMail;

class SecurityController extends Controller
{
        //Открытие страницы авторизации
        function LogOnPage(Request $request){
            //Проверка, авторизован ли уже пользователь. Если авторизован отправляем на индекс, если нет то на логин
            if($this->IsSessionAlive($request) == true){
                return redirect()->route('index');
            } else {
                return view('security.login');
            }   
        }

        //Открытие страницы регистрации
        function RegisterPage(Request $request){
            if($this->IsSessionAlive($request) == true){
                return redirect()->route('index');
            } else {
                if(config('app.registration') == false){
                    return redirect()->route('login');
                    
                } else {
                    return view('security.register');
                }
                

            } 
        }

    
        //API метод авторизации
        function Auth(Request $request){
            $inputData = $request->input();
            $validRules = [
               'email' => 'required|Email|max:256',
               'password' => 'required|max:256'
            ];
            $validator = Validator::make($inputData,$validRules);
            if(!$validator -> passes()){
                return response() -> json(["status" => "422","message"=>$validator->messages()],422);
            }
            $hashedPassword = hash('sha256',$inputData["password"].$inputData["email"]);
            $userRecord = DB::table('user')->SELECT('id','isBlocked','verified')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->first();
            if($userRecord == null){
                return response() -> json(["status" => "401","message"=>"Неверный логин или пароль!"],401);
            }
            if($userRecord->verified == 0 && config('app.verificationrequired') == true){
                return response() -> json(["status" => "403","message"=>"Требуется подтверждение учетной записи!"],401);
            }
            if($userRecord->isBlocked == 1){
                return response() -> json(["status" => "403","message"=>"Учетная запись заблокирована!"],401);
            }
            $authtoken = hash('sha256',date("ymdhis"));
            DB::table('sys_authsessions')->INSERT(['userid'=>$userRecord->id,'authToken'=>$authtoken,'expiresAt'=>Now()->addHours(1),'useragent'=>$request->server('HTTP_USER_AGENT'),'ipAddr'=>$request->ip()]);
            return response() -> json(["status" => "200","message"=>"Вы успешно авторизовались!", "authtoken"=>$authtoken, "userid"=>$userRecord->id],200);
        }
        //API метод регистрации
        function Register(Request $request){
            $inputData = $request->input();
            if(config('app.registration') == false){
                return response() -> json(["status" => "405","message"=>"Регистрация недопустима на конфигурации!"],405);
            }
            $validRules = [
                'login' => 'required|max:256',
                'email' => 'required|Email|max:256',
                'password' => 'required|max:256',
                'firstname' => 'required|max:256',
                'lastname' => 'required|max:256',
                'middlename' => 'max:256'
            ];
            $validator = Validator::make($inputData,$validRules);
            if(!$validator -> passes()){
                return response() -> json(["status" => "422","message"=>$validator->messages()],422);
            }
            if(DB::table('user')->WHERE([['email','=',$inputData["email"]]])->exists()){
                return response() -> json(["status" => "409","message"=>"Указанная электронная почта уже используется другим пользователем!"],409);
            }
            if(DB::table('user')->WHERE([['login','=',$inputData["login"]]])->exists()){
                return response() -> json(["status" => "409","message"=>"Указанный логин уже используется другим пользователем!"],409);
            }
            $hashedPassword = hash('sha256',$inputData["password"].$inputData["email"]);
            $verificationToken = null;
            $verified = 1;
            if(config('app.verificationrequired')==true){
                $verificationToken = hash('sha256',$inputData["email"].$inputData["login"]);
                $verified = 0;
            }
            $userRecord = DB::table('user')->insertGetId(['login'=>$inputData["login"],'firstname'=>$inputData["firstname"],'lastname'=>$inputData["lastname"],'middlename'=>isset($inputData["middlename"]) ? $inputData["middlename"] : null,'passwordhash'=>$hashedPassword,'email'=>$inputData["email"],'verified'=>$verified,'verificationToken'=>$verificationToken,'isBlocked' => 0]);
            if(config('app.verificationrequired')==true){
                Mail::to($inputData['email'])->send(new RegistrationMail($inputData["firstname"], $verificationToken, $inputData["email"]));
                return response() -> json(["status" => "200","message"=>"Вы успешно зарегистрировались!", "approveRequired"=>"true"],200);
            } else {
                $authtoken = hash('sha256',date("ymdhis"));
                DB::table('sys_authsessions')->INSERT(['userid'=>$userRecord,'authToken'=>$authtoken,'expiresAt'=>Now()->addHours(1),'useragent'=>$request->server('HTTP_USER_AGENT'),'ipAddr'=>$request->ip()]);
                return response() -> json(["status" => "200","message"=>"Вы успешно зарегистрировались!", "approveRequired"=>"false","authtoken"=>$authtoken, "userid"=>$userRecord],200);
            }
        }


        //Верификации текущей сессии
        function IsSessionAlive(Request $request){
            $cookieInputData = $request->cookie();
            $validRules = [
                'userid' => 'required|max:256',
                'authtoken' => 'required'
            ];
            $validator = Validator::make($cookieInputData,$validRules);
            if(!$validator -> passes()){
                return false;
            }
            $userRecord = DB::table('user')->SELECT('isBlocked')->where([['id','=',$cookieInputData["userid"]]])->first();
            if($userRecord == null){
                return false;
            }
            if($userRecord->isBlocked == 1){
                return false;
            }
            return DB::table('sys_authsessions')->SELECT('id')->WHERE([['userid','=',$cookieInputData["userid"]],['authtoken','=',$cookieInputData["authtoken"]],['expiresAt','>',Now()]])->exists();
        }

        //Получить текущего пользователя как объект
        function GetCurrentUser(Request $request){
            $cookieInputData = $request->cookie();
            $validRules = [
                'userid' => 'required|max:256',
                'authtoken' => 'required'
            ];
            $validator = Validator::make($cookieInputData,$validRules);
            if(!$validator -> passes()){
                return null;
            }
            $sessionData = DB::table('sys_authsessions')->SELECT('userid')->WHERE([['userid','=',$cookieInputData["userid"]],['authtoken','=',$cookieInputData["authtoken"]],['expiresAt','>',Now()]])->first();
            if($sessionData == null){
                return null;
            }
            return DB::table('user')->SELECT('id','login','firstname','middlename','lastname','email','interface')->WHERE([['id','=',$sessionData->userid]])->first();
        }

        //Получить id текущего пользователя
        function GetCurrentUserId(Request $request){
            $user = app('App\Http\Controllers\SecurityController')->GetCurrentUser($request);
            if($user == null){
                return null;
            } else {
                return $user->id;
            }
        }

        function VerifyAccount(Request $request){
            $inputData = $request->input();
            $validRules = [
               'email' => 'required|Email|max:256',
               'verificationToken' => 'required|max:256'
            ];
            $validator = Validator::make($inputData,$validRules);
            if(!$validator -> passes()){
                return view('error')->with(['stacktrace'=>$validator->messages()]);
            } else {
                if(DB::table('user')->where([['email','=',$inputData['email']],['verificationToken','=',$inputData['verificationToken']]])->exists()){
                    DB::table('user')->where([['email','=',$inputData['email']],['verificationToken','=',$inputData['verificationToken']]])->update(['verified'=>1,'verificationToken'=>null]);
                    return view('security.accountVerified');
                } else {
                    return view('error')->with(['stacktrace'=>'Не найдена учетная запись для подтверждения. Возможно учетная запись уже подтверждена?']);
                }
            }
        }

        function UserProfile($id = null, Request $request){
            $user = null;
            if($id == 'me'){
                $id = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
            }
            if(!DB::table('user')->where([['id','=',$id]])->exists()){
                return 'notExists';
            }
            $user = DB::table('user')->where([['id','=',$id]])->first();
           
            return view('security.user')->with(['viewUser'=>$user]);
        }


}
