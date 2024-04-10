<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EntityController extends Controller
{

    /*Получить все метаданные сущностей из таблицы sys_entitymetadata */
    function GetAllEntitiesMetadata(){
        //return EntityMetadata::all();
        //wtf this was working???
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

    function GetSysTables(){
        $sysTables = [
            'sys_authsessions',
            'sys_authsessions.id',
            'sys_authsessions.userid',
            'sys_authsessions.authtoken',
            'sys_authsessions.expiresAt',
            'sys_authsessions.useragent',
            'sys_authsessions.ipAddr',
            'sys_authsessions.isTerminated',
            'sys_dialogue',
            'sys_dialogue.id',
            'sys_dialogue.isPrivate',
            'sys_dialogue.Name',
            'sys_dialoguemessage',
            'sys_dialoguemessage.id',
            'sys_dialoguemessage.dialogue',
            'sys_dialoguemessage.user',
            'sys_dialoguemessage.message',
            'sys_dialoguemessage.sentAt',
            'sys_dialogueparticipant',
            'sys_dialogueparticipant.id',
            'sys_dialogueparticipant.dialogue',
            'sys_dialogueparticipant.user',
            'sys_dialogueparticipant.isOwner',
            'sys_indexwidgets',
            'sys_indexwidgets.id',
            'sys_indexwidgets.userId',
            'sys_indexwidgets.widgetId',
            'sys_indexwidgets.num',
            'sys_indexwidgets.widgetSizeClass',
            'sys_indexwidgetsassembly',
            'sys_indexwidgetsassembly.id',
            'sys_indexwidgetsassembly.widgetId',
            'sys_indexwidgetsassembly.versionNumb',
            'sys_indexwidgetsassembly.isCurrent',
            'sys_interfaces',
            'sys_interfaces.id',
            'sys_interfaces.name',
            'sys_interfaces.csssheetname',
            'sys_interface_buttons',
            'sys_interface_buttons.id',
            'sys_interface_buttons.interfaceid',
            'sys_interface_buttons.buttonText',
            'sys_interface_buttons.buttonIcon',
            'sys_interface_buttons.path',
            'sys_interface_buttons.num',
            'sys_positions',
            'sys_positions.id',
            'sys_positions.name',
            'sys_positions.user',
            'sys_positions.parent',
            'sys_privilege',
            'sys_privilege.id',
            'sys_privilege.keyname',
            'sys_privilege.name',
            'sys_privilege.description',
            'sys_uiwidget',
            'sys_uiwidget.id',
            'sys_uiwidget.visiblename',
            'sys_uiwidget.assembly',
            'sys_usergroup',
            'sys_usergroup.id',
            'sys_usergroup.name',
            'sys_usergroup.description',
            'sys_usergroup_positions',
            'sys_usergroup_positions.id',
            'sys_usergroup_positions.usergroup',
            'sys_usergroup_positions.position',
            'sys_usergroup_privelege',
            'sys_usergroup_privelege.id',
            'sys_usergroup_privelege.usergroup',
            'sys_usergroup_privelege.privilege',
            'sys_usergroup_user',
            'sys_usergroup_user.id',
            'sys_usergroup_user.usergroup',
            'sys_usergroup_user.user',
            'sys_wikiarticle',
            'sys_wikiarticle.id',
            'sys_wikiarticle.name',
            'sys_wikiarticle.content',
            'sys_wikiarticle.parent',
            'sys_wikiarticle.isArchived',
            'sys_wikistructure',
            'sys_wikistructure.id',
            'sys_wikistructure.name',
            'sys_wikistructure.parent',
            'user',
            'user.id',
            'user.login',
            'user.firstname',
            'user.middlename',
            'user.lastname',
            'user.passwordhash',
            'user.email',
            'user.description',
            'user.isBlocked',
            'user.interface',
            'user.verified',
            'user.verificationToken',
            'user.photoBase64',
            'user.birthday',
            'user.inCompanyFrom',
            'sys_file',
            'sys_file.id',
            'sys_file.contentBase64'
        ];

        return $sysTables;

    }


    function DiagnosticsPage(Request $request){
        $result = '';
        if(config('app.entitydiagnostics') == false){
            return 'Диагностика сущностей выключена на конфигурации. Включите её в .env => APP_ENTITYDIAGNOSTICS=TRUE';
        }
        $dbName = DB::connection()->getDatabaseName();
        if($dbName){
            $result = 'Установлено соединение с БД: '.$dbName;
        } else {
            $result = 'Невозможно подключится к БД: '.$dbName;
            return $result;
        }
        $sysTables =app('App\Http\Controllers\EntityController')->GetSysTables();
        $existingTables = [];
        $allDBSet = DB::Select(DB::Raw('select column_name,table_name,DATA_TYPE from information_schema.columns where table_schema = \''.$dbName.'\' order by table_name,ordinal_position'));
        $allTables = DB::Select(DB::Raw('SELECT TABLE_NAME FROM information_schema.tables where table_schema = \''.$dbName.'\''));
        
        foreach($allTables as $table){
            $tableExists = in_array($table->TABLE_NAME,$sysTables);
            array_push($existingTables, $table->TABLE_NAME);
            $result .= '<p>Таблица: '.$table->TABLE_NAME.': ' .($tableExists == true ? '<b style="color:green">Найдена</b>' : '<b style="color:yellow">Не найдена в описании системных метаданных!</b>').'</p>';
            foreach(array_keys(array_column($allDBSet,'table_name'),$table->TABLE_NAME) as $key){
                $columnExists = in_array($table->TABLE_NAME.'.'.$allDBSet[$key]->column_name,$sysTables);
                array_push($existingTables, $table->TABLE_NAME.'.'.$allDBSet[$key]->column_name);
                $result .= '<p>Колонка: '.$table->TABLE_NAME.'.'.$allDBSet[$key]->column_name.': ' .($columnExists == true ? '<b style="color:green">Найдена</b>' : '<b style="color:yellow">Не найдена в описании системных метаданных!</b>').'</p>';

            }
            $result.='<hr>';
            
           
        }
        foreach(array_diff($sysTables, $existingTables) as $notFound){
            $result.='<b style="color:red">Таблица или колонка: '.$notFound.' - НЕ НАЙДЕНА!</b><br>';
        }
        return $result;
        //json_encode($allTables);


    }


}