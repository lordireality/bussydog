<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
        //Открытие страницы авторизации
        function LogOnPage(Request $request){
            //Проверка, авторизован ли уже пользователь. Если авторизован отправляем на индекс, если нет то на логин
            if($this->IsSessionAlive($request) == true){
                return redirect()->route('index');
            } else {
                return view('/login');
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
            $userRecord = DB::table('user')->SELECT('id','isBlocked')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->first();
            if($userRecord == null){
                return response() -> json(["status" => "401","message"=>"Неверный логин или пароль!"],401);
            }
            if($userRecord->isBlocked == 1){
                return response() -> json(["status" => "403","message"=>"Учетная запись заблокирована!"],401);
            }
            $authtoken = hash('sha256',date("ymdhis"));
            DB::table('sys_authsessions')->INSERT(['userid'=>$userRecord->id,'authToken'=>$authtoken,'expiresAt'=>Now()->addHours(1)]);
            return response() -> json(["status" => "200","message"=>"Вы успешно авторизовались!", "authtoken"=>$authtoken, "userid"=>$userRecord->id],200);
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
            return DB::table('user')->SELECT('id','login','firstname','middlename','lastname','email')->WHERE([['id','=',$sessionData->userid]])->first();
        }
}
