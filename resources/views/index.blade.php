@extends('templates.PageCoreAuth')

@section('pagename', 'Главная')

@section('content')
    @foreach($widgetInfo as $tmp)
            @if(!is_null($tmp->assembly))
            @include('ese.UIWidget',['assembly'=>$tmp->assembly,'visiblename'=>$tmp->visiblename,'isEdit'=>$isEdit,'num'=>$tmp->num,'widgetSizeClass'=>$tmp->widgetSizeClass])
            @else
            <div class="{{$tmp->widgetSizeClass}}" id="EmptyWidgetPlaceholder">
                <div class="panel" style="overflow: auto;"><h1 @if($isEdit == true)style="display:inline-block; margin: 10px;"@endif>Виджет не установлен</h1>@if($isEdit == true)<a class="button2" href="javascript:RemoveWidgetZone({{$tmp->num}})" style="float:right;">X</a> @endif</div>
                <div class="container">
                    @if($isEdit == true)
                    <a class="button2long" href="javascript:SetWidgetPopup('setWidgetToZone',{{$tmp->num}})">Добавить виджет</a>
                    @endif
                </div>
            </div>
            @endif
        @endforeach
    
    @if($isEdit == true)
    <a class="button2long" href="javascript:AddWidgetZone()">Добавить зону для виджета 50%</a>
    <a class="button2long" href="javascript:AddWidgetZone()">Добавить зону для виджета 100%</a>
    @endif
@endsection