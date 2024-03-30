<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;


class MessageController extends Controller
{
    function GetMyDialogues(Request $request){
        $currentUserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        $dialogues = DB::table('sys_dialogue')->SELECT(DB::raw('CASE WHEN `sys_dialogue`.`isPrivate` = 0 THEN `sys_dialogue`.`Name` WHEN `sys_dialogue`.`isPrivate` = 1 THEN (SELECT CONCAT(COALESCE(`user`.`lastname`,\'\'), \' \', COALESCE(`user`.`firstname`,\'\'), \' \', COALESCE(`user`.`middlename`,\'\')) from `user` where `user`.`id` = (select `tmp`.`user` from `sys_dialogueparticipant` as `tmp` where `tmp`.`user` <> 2 and `tmp`.`dialogue` = `sys_dialogue`.`id` LIMIT 1)LIMIT 1) END as `DialogueName`'),'isPrivate')->join('sys_dialogueparticipant','sys_dialogueparticipant.dialogue','=','sys_dialogue.id')->where([['sys_dialogueparticipant.user','=',$currentUserId]])->get();
        return $dialogues;
    }
    function GetDialogueMessages(Request $request){
        $offset = 0;
        if(!isset($request->input()["dialogueId"])){
            return null;
        }
        if(isset($request->input()["offset"])){
            $offset = $request->input()["offset"];
        }
        $dialogueId = $request->input()["dialogueId"];
        $currentUserId = app('App\Http\Controllers\SecurityController')->GetCurrentUserId($request);
        $dialogue = DB::table('sys_dialogue')->join('sys_dialogueparticipant','sys_dialogueparticipant.dialogue','=','sys_dialogue.id')->where([['sys_dialogueparticipant.user','=',$currentUserId],['sys_dialogue.id','=',$dialogueId]])->first();
        if($dialogue == null){
            return null;
        }
        $dialogues = DB::table('sys_dialoguemessage')->select('message','sentAt','user.id','user.lastname','user.firstname','user.middlename')->join('user', 'user.id', '=', 'sys_dialoguemessage.user')->orderBy('sentAt','DESC')->skip($offset)->take(50)->get();
        return $dialogues;
    }
}
