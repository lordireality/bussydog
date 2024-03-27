<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UIPageController extends Controller
{
    function LoadMainPage(Request $request){
        $currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        //Получаем виджеты
        $widgetInfo = DB::table('sys_indexwidgets')->select(DB::raw("null as assembly"),'sys_uiwidget.visiblename','sys_indexwidgets.id','sys_indexwidgets.num','sys_indexwidgets.widgetSizeClass')->leftjoin('sys_uiwidget','sys_uiwidget.id', '=', 'sys_indexwidgets.widgetId')->where([['sys_indexwidgets.userId','=',$currentuserId],['sys_indexwidgets.num', '<>', '0']])->orderby('sys_indexwidgets.num', 'asc')->get();
        $isEdit = false;
        if($request->has("isEdit")){
            $isEdit = (bool)$request->input()["isEdit"];
        } else {
            $isEdit = false;
        }
        return view('index')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);;
       // return view('/ese/mainpage')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);
    }

    function LoadWelcomePage(Request $request){
        return view('welcome');
    }

}
