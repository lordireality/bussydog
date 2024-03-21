<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            if($validator -> passes()){
                //Тут вы можете установить свои параметры хэширования пароля
                //Важно, что бы при создании учетной записи использовались аналогичные правила хэширования
                //--------------Start hash region--------------
                $hashedPassword = hash('sha256',$inputData["password"].$inputData["email"]);
                //---------------End hash region---------------

                //BDOG-5: return only token and user id. Stop storing email and token in cookie/local storage
                if(DB::table('user')->SELECT('email')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->exists()){
                    $authtoken = hash('sha256',date("ymdhis"));
                    DB::table('user')->WHERE([['email','=',$inputData["email"]],['passwordhash','=',$hashedPassword]])->update(['authtoken' => $authtoken]);
                    return response() -> json(["status" => "200","message"=>"Вы успешно авторизовались!", "authtoken"=>$authtoken, "email"=>$inputData["email"]],200);
                } else {
                    return response() -> json(["status" => "401","message"=>"Неверный логин или пароль!"],401);
                }
            } else { return response() -> json(["status" => "422","message"=>$validator->messages()],422); }
        }
        //Верификации текущей сессии
        function IsSessionAlive(Request $request){
            $cookieInputData = $request->cookie();
            $validRules = [
                'email' => 'required|Email|max:256',
                'authtoken' => 'required'
            ];
            $validator = Validator::make($cookieInputData,$validRules);
            if($validator -> passes()){
                //BDOG-4: Rewrite current auth token system to handle from auth table, with expiration date
                if(DB::table('user')->SELECT('email')->WHERE([['email','=',$cookieInputData["email"]],['authtoken','=',$cookieInputData["authtoken"]]])->exists()){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
}
