<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class WikiController extends Controller
{
    function Index(Request $request){
        //todo perm check
        //CheckCurrentUserPrivelege($request, 'wiki-access');
        return view('wiki.index');
    }

    function ViewArticle(int $articleid = 0,Request $request){
        //todo perm check
        $article = DB::table('sys_wikiarticle')->where([['id','=',$articleid]])->first();
        if($article == null){
            return view('wiki.error')->with(['stacktrace'=>'Статья с идентификатором '.$articleid.' не найдена']);
        }
        return view('wiki.article')->with(['article'=>$article]);
    }

    function EditArticle(int $articleid = 0, Request $request){
        //todo perm check
        $article = DB::table('sys_wikiarticle')->where([['id','=',$articleid]])->first();
        if($article == null){
            return view('wiki.error')->with(['stacktrace'=>'Статья с идентификатором '.$articleid.' не найдена']);
        }
        $structure = DB::table('sys_wikistructure')->select('id','name','parent')->get();
        return view('wiki.editor')->with(['article'=>$article,'structure'=>$structure]);
    }

    function CreateArticle(Request $request){
        //todo perm check
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
        //todo perm check
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
        
        return json_encode(DB::table('sys_wikiarticle')->select('id','name')->where([['name','like','%'.$request->get('query').'%']])->get());

    }
}
