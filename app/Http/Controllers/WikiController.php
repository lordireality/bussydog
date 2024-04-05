<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WikiController extends Controller
{
    function Index(Request $request){
        //todo perm check
        return view('wiki.index');
    }

    function ViewArticle(int $articleid = 0,Request $request){
        //todo perm check
        return view('wiki.article');
    }

    function EditArticle(Request $request){
        //todo perm check
    }
    //API
    function SaveArticle(Request $request){
        //todo perm check
    }

    function GetAllStructure(Request $request){
        $structure = DB::table('sys_wikistructure')->select('id','name','parent',DB::Raw('false as isArticle'));
        $structurewitharticle = DB::table('sys_wikiarticle')->select('id','name','parent',DB::Raw('true as isArticle'))->union($structure)->get();
        return $structurewitharticle;
        
    }
}
