@php
    $starttime = microtime(true); 
@endphp
@php
    $sys_popups = [];
    if(!isset($def_popups)){
        $def_popups = [];
    }
@endphp
<!doctype html>
<html>
	<head>
		<title>@yield('pagename')|{{config('app.name')}}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="ESE-CRM Leightweight OpenSource BPMN CRM"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/base.css') }}">
        <!--TODO:BDOG-1 -->
        <link rel="stylesheet" href="{{ asset('/content/css/base-blue.css') }}">
        <link rel="stylesheet" href="{{ asset('/ese/content/css/icon-pack.css') }}">

        
        

	</head>


	<body>
        
        @foreach($sys_popups as $popup)
            @include($popup)
        @endforeach
        @foreach($def_popups as $popup)
            @include($popup)
        @endforeach
        <header>
            <!-- BDOG-2,BDOG-3 - Side menu -->
            <div class="menu">
                <a href="{{route('index')}}" class="logo"><h1 style="display: inline;">{{config('app.name')}} {{@config('app.EDITIONNAME')}}</h1><img style="height:2em; width:2em; vertical-align:baseline;" src="{{ asset('/ese/content/images/eseapplogotransparent.png') }}"/></a>
                <ul>
                    <li><a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Главная</a></li>
                    <li><a class="button2" href="{{route('Tasks')}}"><p class="icon-button list-check"></p>Задачи[{{TasksController::ActiveTasksCount(app('request'))}}]</a></li> 

                   
                   <!-- <li><a class="button2" href="{{route('adminpanel')}}"><p class="icon-button screwdriver-wrench"></p>Админ-панель</a></li>-->
                    <li><a class="button2" href="javascript:LogOut();"><p class="icon-button right-from-bracket"></p>Выйти</a></li>
                </ul>
            </div>
        </header>
        <section class="bodysection">
            @yield('content')
        </section>

        <footer>
        <hr>
        <i style="text-align:right">
            @php
            $endtime = microtime(true);
            @printf("%s v.%s - Страница загружена за %f секунд",config('app.name'), config('app.ver') ,$endtime - $starttime );
            @endphp
        </i>
        </footer>
	</body>
</html>