@php
    use \App\Http\Controllers\SecurityController;
    $starttime = microtime(true); 
@endphp
@if(SecurityController::IsSessionAlive(app('request'))==false)
<!doctype html>
<html>
    <head>
    <title>Не авторизован|{{config('app.name')}}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <script type="text/javascript">
            //window.location = "{{ route('LogOnPage') }}";
        </script>
    </head>
    <body>
        <h1>401 Не авторизован!</h1>
    </body>
</html>
@php
    exit;
@endphp
@else
@php
    $sys_popups = [];
    if(!isset($def_popups)){
        $def_popups = [];
    }
    /* ['ese.popup.user','ese.popup.addcomment','ese.popup.processdiagram','ese.popup.changeexecutor','ese.popup.processdiagram','ese.popup.createtask','ese.popup.createsubtask','ese.popup.changeexecutor','ese.popup.addwidget','ese.popup.2faSubmit']*/
@endphp
<!doctype html>
<html>
	<head>
		<title>@yield('pagename')|{{config('app.name')}}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('/content/css/base-blue.css') }}">
	</head>
    <body>
        @foreach($sys_popups as $popup)
            @include($popup)
        @endforeach
        @foreach($def_popups as $popup)
            @include($popup)
        @endforeach
        <header>
            <div class="menu">
                <a href="{{route('index')}}" class="logo"><img style="height:3em; width:3em; vertical-align:middle;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/></a>
                <ul>
                    <li><a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Экшен кнопка 1</a></li>
                    <li> <a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Экшен кнопка 2</a></li>
                    
                </ul>
                <div class="profile-info">
                    <table>
                        <tr>
                        <td rowspan="2">Фото</td>
                        <td>Тестовый Т.Т.</td>
                        <td rowspan="2"><a style="color:white" href="javascript:LogOut()">Выход</a></td>
                        </tr>
                        <tr>
                        <td><a style="color:white" href="#">Настройки</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </header>
        <section class="bodysection">
            <div class="lmenu">
                <a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Экшен кнопка 1</a>
                <a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Экшен кнопка 2</a>
                <a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Экшен кнопка 3</a>
            </div>
            <div class="content">
                @yield('content')
                <hr>
                <i style="text-align:right">
                @php
                    $endtime = microtime(true);
                    @printf("%s v.%s - Страница загружена за %f секунд",config('app.name'), config('app.ver') ,$endtime - $starttime );
                @endphp
                </i>
            </div>
        </section>
	</body>
</html>
@endif