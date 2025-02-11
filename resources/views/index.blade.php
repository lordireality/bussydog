@extends('templates.PageCoreAuth')

@section('pagename', 'Главная')

@section('content')
    @foreach($widgetInfo as $tmp)
            @if(!is_null($tmp->assembly) && !is_null($tmp->versionNumb))
            @include('templates.UIWidget',['assembly'=>$tmp->assembly.'_'.$tmp->versionNumb,'visiblename'=>$tmp->visiblename,'isEdit'=>$isEdit,'num'=>$tmp->num,'widgetSizeClass'=>$tmp->widgetSizeClass])
            @else
            <div class="{{$tmp->widgetSizeClass}}" id="EmptyWidgetPlaceholder">
                @if(!is_null($tmp->assembly) && is_null($tmp->versionNumb))
                <div class="panel" style="overflow: auto;"><h1 @if($isEdit == true)style="display:inline-block; margin: 10px;"@endif>{{$tmp->visiblename}}</h1>@if($isEdit == true)<a class="button2" href="javascript:RemoveWidgetZone({{$tmp->num}})" style="float:right;">X</a> @endif</div>
                <div class="container">
                    <h1 style="color:red;">Произошла ошибка отображения виджета! <br>В метаданных нет опубликованных версий для сборки виджета с наименованием {{$tmp->assembly}}</h1>
                </div>
                @else 
                <div class="panel" style="overflow: auto;"><h1 @if($isEdit == true)style="display:inline-block; margin: 10px;"@endif>Виджет не установлен</h1>@if($isEdit == true)<a class="button2" href="javascript:RemoveWidgetZone({{$tmp->num}})" style="float:right;">X</a> @endif</div>
                <div class="container">
                    @if($isEdit == true)
                    <a class="button2long" href="javascript:SetWidgetPopup('setWidgetToZone',{{$tmp->num}})">Добавить виджет</a>
                    @endif
                </div>
                @endif
                
            </div>
            @endif
        @endforeach
    
    @if($isEdit == true)
    <a class="button2long" href="javascript:AddWidgetZone('widget50')">Добавить зону для виджета 50%</a>
    <a class="button2long" href="javascript:AddWidgetZone('widget100')">Добавить зону для виджета 100%</a>
    <script>
            function AddWidgetZone(widgetSizeClass){
            let params = [
            {
                "key" : "widgetSizeClass",
                "value" : widgetSizeClass
            }
            ];
            var responseRaw = BussyDog.Rest.HTTPPost(window.location.origin+'/api/Index/AddWidgetZone',params,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                document.location.reload(true); 
            } else {
                console.log(response.message);
            }
        }

        function RemoveWidgetZone(zoneNum){
            let params = [
            {
                "key" : "num",
                "value" : zoneNum
            }
            ];
            var responseRaw = BussyDog.Rest.HTTPPost(window.location.origin+'/api/Index/RemoveWidgetZone',params,false);
            response = JSON.parse(responseRaw);
            if(response.status == 200){
                document.location.reload(true); 
            } else {
                console.log(response.message);
            }
        }
    </script>
    @endif
@endsection