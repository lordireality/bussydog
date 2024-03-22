<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UIPageController extends Controller
{
    function LoadMainPage(Request $request){
        //$currentuserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        //Получаем виджеты
        //$widgetInfo = DB::table('indexpage_widgets')->select('uiwidget.assembly','uiwidget.visiblename','indexpage_widgets.id','indexpage_widgets.num')->leftjoin('uiwidget','uiwidget.id', '=', 'indexpage_widgets.widgetId')->where([['indexpage_widgets.userId','=',$currentuserId],['indexpage_widgets.num', '<>', '0']])->orderby('indexpage_widgets.num', 'asc')->get();
        $isEdit = false;
        if($request->has("isEdit")){
            $isEdit = (bool)$request->input()["isEdit"];
        } else {
            $isEdit = false;
        }
        return view('index');
       // return view('/ese/mainpage')->with("widgetInfo",$widgetInfo)->with("isEdit",$isEdit);
    }

    function LoadWelcomePage(Request $request){
        return view('welcome');
    }

}
