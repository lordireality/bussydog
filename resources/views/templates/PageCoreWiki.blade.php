@php
    use \App\Http\Controllers\SecurityController;
    use \App\Http\Controllers\UIPageController;
    use \App\Http\Controllers\WikiController;
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
            window.location = "{{ route('LogOnPage') }}";
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
    function buildTree($data, $parentId = null)
    {
        $result = '';
        if($parentId != null){
            $result .= '<ul class="listree-submenu-items">';
        }
        foreach ($data as $row) {
            if ($row->parent == $parentId) {
                if($row->isArticle == 0){
                    $result .= '<li>';
                    $result .= '<div class="listree-submenu-heading">' . $row->name . '</div>';
                    $result .= buildTree($data, $row->id);
                    $result .= '</li>';
                } else {
                    $result .= '<li>';
                    $result .= '<a style="color:white;" href="'.route('wiki-article',['articleid'=>$row->id]).'">'.$row->name .'</a>';
                    $result .= '</li>';
                }
                
            }
        }
        if($parentId != null){
            $result .= '</ul>';
        }
        
        return $result;
    }
    $articleStructure =  buildTree(json_decode(WikiController::GetAllStructure(app('request'))),null);
    $currentUser = SecurityController::GetCurrentUser(app('request'));
    $currentInterface = UIPageController::GetInterface($currentUser->interface);
    if(!isset($def_popups)){
        $def_popups = [];
    }
    
@endphp
<!doctype html>
<html>
	<head>
		<title>@yield('pagename')|{{config('app.name')}}</title>
		<link rel="icon" href="{{ asset('/content/images/favicon.ico') }}" type="image/x-icon">
		<meta name="description" content="BussyDog Leightweight OpenSource System"> 
		<meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/content/css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('/content/css/icon-pack.css') }}">
        <link rel="stylesheet" href="{{ asset('/content/css/'.$currentInterface->csssheetname.'.css') }}">
        <link rel="stylesheet" href="{{ asset('/content/css/listree.min.css') }}"/>
        <script src="{{ asset('/content/js/listree.umd.min.js') }}"></script>
        <script src="{{ asset('/content/js/BussyDogPopup.js') }}"></script>
        <script src="{{ asset('/content/js/BussyDogSecurity.js') }}"></script>
        <script src="{{ asset('/content/js/BussyDogRest.js') }}"></script>
        <script src="{{ asset('/content/js/BussyDog.js') }}"></script>
	</head>
    <body>
    @foreach($def_popups as $popup)
        @include($popup)
    @endforeach
    <div class="popupBlocker" id="popupBlocker"></div>
        <header>
            <div class="menu">
                <a href="{{route('index')}}" class="logo" style="margin:115px !important;"><img style="height:3em; width:3em; vertical-align:middle;" src="{{ asset('/content/images/eseapplogotransparent.png') }}"/></a>
                
                <ul>
                    <li> <a class="button2" href="{{route('index')}}"><p class="icon-button house"></p>Вернутся на портал</a></li>
                    @if(SecurityController::CheckCurrentUserPrivelege(app('request'), 'wiki-editor') == true)
                    <li> <a class="button2" href="{{route('wiki-article-create')}}"><p class="icon-button pen"></p>Создать статью</a></li>
                    <li> <a class="button2" href="{{route('wiki-structure-edit')}}"><p class="icon-button folder-tree"></p>Редактировать структуру</a></li>                    
                    @endif
                </ul>
                <div class="profile-info">
                    <table>
                        <tr>
                        <td rowspan="2"><a href="{{route('user',['id'=>'me'])}}"><img style="margin: 10px; border: 1px solid gray; border-radius: 128px; width:32px; height:32px;" src="{{$currentUser->photoBase64 ?? '/content/images/default.png'}}"></a></td>
                        <td>{{$currentUser->lastname}} {{(mb_substr($currentUser->firstname, 0, 1) ?? '')}}{{(mb_substr($currentUser->middlename, 0, 1) ?? '')}}</td>
                        
                        </tr>
                        <tr>
                        <td rowspan="2"><a style="color:white" href="javascript:BussyDog.Security.LogOut()">Выйти</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </header>
        <section class="bodysection">
            <div class="lmenu" style="width: 250px !important; text-align:left !important;">
                <a style="color:white;" href="{{route('wiki')}}">Главная</a>
                <ul class="listree" style="color:white;">
                    {!!$articleStructure!!}
                </ul>
            </div>
            <script>
                listree();
            </script>
            <div class="content" style="width: calc(97vw - 250px);">
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