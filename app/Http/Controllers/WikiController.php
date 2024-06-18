<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class WikiController extends Controller
{
    function Index(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        return view('wiki.index');
    }

    function ViewArticle(int $articleid = 0,Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        $article = DB::table('sys_wikiarticle')->where([['id','=',$articleid]])->first();
        if($article == null){
            return view('wiki.error')->with(['stacktrace'=>'Статья с идентификатором '.$articleid.' не найдена']);
        }
        return view('wiki.article')->with(['article'=>$article]);
    }

    function EditArticle(int $articleid = 0, Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        $article = DB::table('sys_wikiarticle')->where([['id','=',$articleid]])->first();
        if($article == null){
            return view('wiki.error')->with(['stacktrace'=>'Статья с идентификатором '.$articleid.' не найдена']);
        }
        $structure = DB::table('sys_wikistructure')->select('id','name','parent')->get();
        return view('wiki.editor')->with(['article'=>$article,'structure'=>$structure]);
    }

    function CreateArticle(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        $article = (object)[
            'id'=>0,
            'name' => '',
            'content' => '',
            'parent'=>null
        ];
        $structure = DB::table('sys_wikistructure')->select('id','name','parent')->get();
        return view('wiki.editor')->with(['article'=>$article,'structure'=>$structure]);
    }

    //API
    function SaveArticle(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return response() -> json(["status" => "403","message"=>"Недостаточно прав доступа!"],422);
        } 
        $inputData = $request->input();
        $validRules = [
            'id' => 'required',
            'parent' => 'required',
            'content' => 'required',
            'name' => 'required'
        ];
        $validator = Validator::make($inputData,$validRules);
        if(!$validator -> passes()){
            return response() -> json(["status" => "422","message"=>$validator->messages()],422);
        }
        $exists = DB::table('sys_wikiarticle')->where([['id','=',$inputData['id']]])->exists();
        $parent = $inputData['parent'] == 'null' ? DB::raw('null')  : $inputData['parent'];
        if($exists == true){
            DB::table('sys_wikiarticle')->where([['id','=',$inputData['id']]])->update(['parent' => $parent,'content'=>$inputData['content'],'name'=>$inputData['name']]);
            return response() -> json(["status" => "200","state"=>"update","message"=>"Статья сохранена","id"=>$inputData["id"]],200);
        } else {
            $newRowId = DB::table('sys_wikiarticle')->insertGetId(['parent' => $parent,'content'=>$inputData['content'],'name'=>$inputData['name'],'isArchived'=>0]);
            return response() -> json(["status" => "200","state"=>"create","message"=>"Статья создана","id"=>$newRowId],200);
        }
    }



    function GetAllStructure(Request $request){
        $structure = DB::table('sys_wikistructure')->select('id','name','parent',DB::Raw('false as isArticle'));
        $structurewitharticle = DB::table('sys_wikiarticle')->select('id','name','parent',DB::Raw('true as isArticle'))->union($structure)->get();
        return $structurewitharticle;
        
    }

    function ArticleSearch(Request $request){
        $isAlive = app('App\Http\Controllers\SecurityController')->IsSessionAlive($request);
        if($isAlive == false ){
            return [];
        }
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return [];
        } 
        
        return json_encode(DB::table('sys_wikiarticle')->select('id','name')->where([['name','like','%'.$request->get('query').'%']])->get());

    }

    function EditStructure(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 

        $structure = DB::table('sys_wikistructure')->select('id','name','parent')->get();
        return view('wiki.editstructure')->with(['structure'=>$structure]);
    }

    function CreateStructure(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        $inputData = $request->input();
        $validRules = [
            'parent' => 'required',
            'name' => 'required'
        ];
        $validator = Validator::make($inputData,$validRules);
        if(!$validator -> passes()){
            return response() -> json(["status" => "422","message"=>$validator->messages()],422);
        }
        $parent = $inputData["parent"] == 0 ? null : $inputData["parent"];
        DB::table('sys_wikistructure')->insert(['name'=>$inputData["name"],'parent'=>$parent]);
        return response() -> json(["status" => "200","message"=>"Раздел создан"],200);


    }
    function DeleteStructure(Request $request){
        $access = app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-editor') && app('App\Http\Controllers\SecurityController')->CheckCurrentUserPrivelege($request, 'wiki-access');
        if($access == false){
            return view('security.noaccess');
        } 
        $inputData = $request->input();
        $validRules = [
            'id' => 'required'
        ];
        $validator = Validator::make($inputData,$validRules);
        if(!$validator -> passes()){
            return response() -> json(["status" => "422","message"=>$validator->messages()],422);
        }
        $structureRow = DB::table('sys_wikistructure')->where([['id','=',$inputData["id"]]]);
        if(!$structureRow->exists()){
            response() -> json(["status" => "204","message"=>"Структура с id: ".$inputData["id"]." не найдена"],204);
        }
        $structureRowParent = $structureRow->first()->parent;
        DB::table('sys_wikistructure')->where([['parent','=',$inputData["id"]]])->update(['parent'=>$structureRowParent]);
        DB::table('sys_wikiarticle')->where([['parent','=',$inputData["id"]]])->update(['parent'=>$structureRowParent]);
        $structureRow->delete();
        return response() -> json(["status" => "200","message"=>"Структура успешно удалена!"],200);

    }

}
