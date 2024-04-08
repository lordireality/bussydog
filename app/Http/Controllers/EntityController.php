<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EntityController extends Controller
{

    /*Получить все метаданные сущностей из таблицы sys_entitymetadata */
    function GetAllEntitiesMetadata(){
        return EntityMetadata::all();
    }

    /*Получить список всех сущностей из таблицы sys_entitymetadata */
    function GetAllEntitiesList(){

    }

    /*Получить конкретную запись метаданных */
    function LoadEntityMetadata(){

    }

    /*Получить все данные для конкретной сущности из метаданных  */
    function GetEntityData(){

    }

    /*Создать метаданные */
    function CreateEntityMetadata(){

    }

    /*Обновить метаданные */
    function UpdateEntityMetadata(){

    }

    /*Мягкое перестроение таблицы сущности */
    function SoftRebaseEntity(){

    }
    /*Насильное перестроение таблицы сущности */
    function HardRebaseEntity(){

    }

    function DiagnosticsPage(Request $request){
        $result = '';
        $dbName = DB::connection()->getDatabaseName();
        if($dbName){
            $result = 'Connection estabilished with DB: '.$dbName;
        } else {
            $result = 'Cannot connect to database: '.$dbName;
            return $result;
        }
        $allDBSet = DB::Select(DB::Raw('select column_name,table_name,DATA_TYPE from information_schema.columns where table_schema = \''.$dbName.'\' order by table_name,ordinal_position'));
        $allTables = DB::Select(DB::Raw('SELECT TABLE_NAME FROM information_schema.tables where table_schema = \''.$dbName.'\''));
        
        foreach($allTables as $table){
            $result .= '<p>Table: '.$table->TABLE_NAME.' - Found</p>';
            foreach(array_keys(array_column($allDBSet,'table_name'),$table->TABLE_NAME) as $key){
                $result .= '<p>Column: '.$table->TABLE_NAME.'.'.$allDBSet[$key]->column_name.' ('.$allDBSet[$key]->DATA_TYPE.') - Found</p>';
            }
            $result.='<hr>';
        }
        return $result;
        //json_encode($allTables);


    }


}