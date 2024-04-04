<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UIPageController extends Controller
{
    function LoadMainPage(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        //Получаем виджеты
        $widgetInfo = DB::table('sys_indexwidgets')->select('sys_uiwidget.assembly',DB::Raw('(select max(`tmp`.`versionNumb`) FROM `sys_indexwidgetsassembly` as `tmp` WHERE `tmp`.`widgetId` = `sys_uiwidget`.`id` and `tmp`.`isCurrent` = 1 LIMIT 1) as `versionNumb`'),'sys_uiwidget.visiblename','sys_indexwidgets.id','sys_indexwidgets.num','sys_indexwidgets.widgetSizeClass')->leftjoin('sys_uiwidget','sys_uiwidget.id', '=', 'sys_indexwidgets.widgetId')->leftjoin('sys_indexwidgetsassembly','sys_indexwidgetsassembly.widgetId', '=', 'sys_uiwidget.id')->where([['sys_indexwidgets.userId','=',$currentuserId],['sys_indexwidgets.num', '<>', '0'],])->orderby('sys_indexwidgets.num', 'asc')->get();
        
        $isEdit = false;
        if($request->has("isEdit")){
            $isEdit = (bool)$request->input()["isEdit"];
        } else {
            $isEdit = false;
        }
        
        return view('index')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);;
       
    }

    function LoadWelcomePage(Request $request){
        if(config('app.uselandingpage') == true){
            return view('welcome');
        }
        else {
            return redirect()->route('LogOnPage');
        }
    }

    function GetInterface(int $interfaceId){
        return DB::table('sys_interfaces')->where([['id','=',$interfaceId]])->get()->first();
    }
    function GetInterfaceButtons(int $interfaceId){
        return DB::table('sys_interface_buttons')->where([['interfaceid','=',$interfaceId]])->get();
    }

    function IconPack(Request $request){
        
        return view('templates.IconPack')->with("IconsData",File::glob('content/icon-pack/*'));

    }

}
