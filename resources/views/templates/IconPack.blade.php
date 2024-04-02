@extends('templates.PageCoreAuth')

@section('pagename', 'Иконки')

@section('content')

@foreach ($IconsData as $Icon)
        <?php 
            $shortname = str_replace('content/icon-pack/','',$Icon);
            $shortname = str_replace('-solid','',$shortname);
            $shortname = str_replace('.svg','',$shortname);
        ?>
    <div style="display:inline-block; vertical-align:top;">
        <a class="lbutton" href="#"><p class="icon-lbutton {{$shortname}}"></p>{{$shortname}}</a>
    </div>
@endforeach



@endsection