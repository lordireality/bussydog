<div class="{{$tmp->widgetSizeClass}}" id="widget_{{$assembly}}">
    @if($isEdit) 
    <div class="panel" style="overflow: auto;"><h1 style="display:inline-block; margin:10px">{{$visiblename}}</h1> <a class="button2" href="javascript:RemoveWidgetZone({{$num}})" style="float:right;">X</a></div>
    <div class="container">
        <i><h1 style="padding: 8px; color:#1d6d9a;">Содержимое виджета</h1></i>
    </div>
    @else
    <div class="panel"><h1 style="display:inline-block;">{{$visiblename}}</h1></div>
    <div class="container">
        <?php include_once(resource_path()."/UIWidgetAssembly/WidgetContext.php") ?>
        <?php include_once(resource_path()."/UIWidgetAssembly/".$assembly.'.php') ?>
    </div>
    @endif
</div>
