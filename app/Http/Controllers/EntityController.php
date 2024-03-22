<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


}

use Illuminate\Database\Eloquent\Model;

class EntityMetadata extends Model{
    protected $table = "sys_entitymetadata"; 

    //id
    //entityName
    //entityTable
    //
    //tableMapping
    /*
    [
    {
        'key':'SysColumn',
        'value':'VisibleName'
    }
    ]
    
    */
}