<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UIPageController extends Controller
{
    //Загрузка главной index страницы со всеми виджетами
    function LoadMainPage(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        //Получаем виджеты
        $widgetInfo = DB::table('sys_indexwidgets')->select('sys_uiwidget.assembly',DB::Raw('(select max(`tmp`.`versionNumb`) FROM `sys_indexwidgetsassembly` as `tmp` WHERE `tmp`.`widgetId` = `sys_uiwidget`.`id` and `tmp`.`isCurrent` = 1 LIMIT 1) as `versionNumb`'),'sys_uiwidget.visiblename','sys_indexwidgets.id','sys_indexwidgets.num','sys_indexwidgets.widgetSizeClass')->leftjoin('sys_uiwidget','sys_uiwidget.id', '=', 'sys_indexwidgets.widgetId')->leftjoin('sys_indexwidgetsassembly','sys_indexwidgetsassembly.widgetId', '=', 'sys_uiwidget.id')->where([['sys_indexwidgets.userId','=',$currentuserId],['sys_indexwidgets.num', '<>', '0'],])->orderby('sys_indexwidgets.num', 'asc')->get();
        
        $isEdit = false;
        if($request->has("isEdit")){
            $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'widget-index-edit');
            if($access == true){
                $isEdit = (bool)$request->input()["isEdit"];
            } else {
               $isEdit = false;  
            }
        } else {
            $isEdit = false;
        }
        
        return view('index')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);;
       
    }

    //handle лэндинг страницы для un-authorized пользователей
    function LoadWelcomePage(Request $request){
        if(config('app.uselandingpage') == true){
            return view('welcome');
        }
        else {
            return redirect()->route('LogOnPage');
        }
    }

    //Хватает интерфейс по id
    function GetInterface(int $interfaceId){
        return DB::table('sys_interfaces')->where([['id','=',$interfaceId]])->get()->first();
    }
    //Хватает кнопки для левого меню указанного интерфейса
    function GetInterfaceButtons(int $interfaceId){
        return DB::table('sys_interface_buttons')->where([['interfaceid','=',$interfaceId],['num','<>','0']])->orderby('num')->get();
    }

    //страница icon-pack'a (просмотр всех иконок)
    function IconPack(Request $request){ 
        return view('templates.IconPack')->with("IconsData",File::glob('content/icon-pack/*'));
    }

    //Добавить зону виджета для пользователя
    function AddWidgetZone(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);

        /*кусок бесполезных проверок, которые сработают только если целенаправленно кто-то не будет реверсить API Call-back'и */

        //проверяем не пустой ли пользователь, т.к. getCurrentUser возвращает null при отсутствии авторизации
        if(is_null($currentuserId)){
            //возвращаем ответ в случае отсутствия авторизации
            return response() -> json(["status" => "401","message"=>"Не авторизован"],401);
        }
        /*Проверяем есть ли у пользователя привелегия редактирования виджетов на индексе. 
        Вообще в идеале может сработать только по прямому REST запросу,
        т.к. сама страница открывается только при наличии привелегии*/
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'widget-index-edit');
        if($access == false){
            return response() -> json(["status" => "403","message"=>"Отсутствует привелегия widget-index-edit"],403);
        }
        //Ставим дефолтный размер        
        $widgetSizeClass = "widget50";

        //Устанавливаем размер пришедший в запросе
        if($request->has("widgetSizeClass")){
            $sizeVal = (string)$request->input()["widgetSizeClass"];
            if($sizeVal == "widget50" || $sizeVal == "widget100"){
                $widgetSizeClass = $sizeVal;
            }
        }

        //Получаем предполагаемый Num зоны для виджета по принципу - если есть виджеты +1, если нет =1
        $newWidgetZoneNum = (DB::table('sys_indexwidgets')->where([['userId','=',$currentuserId]])->max('num'));
        if(is_null($newWidgetZoneNum)){
            $newWidgetZoneNum = 1;
        } else {
            $newWidgetZoneNum = $newWidgetZoneNum + 1;
        }
        //Инсертим и отдаем ответ
        DB::table('sys_indexwidgets')->insert(["userId"=>$currentuserId,"num"=>$newWidgetZoneNum, "widgetSizeClass"=>$widgetSizeClass]);
        return response() -> json(["status" => "200","message"=>"Zone added!"],200); 
    }
}
