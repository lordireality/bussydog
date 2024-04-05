@extends('templates.PageCoreWiki')


@section('pagename', 'Ошибка')

@section('content')
<div class="panel"><h1>Произошла ошибка!</h1>
<h3>Передайте текст ошибки приведенный ниже вашему администратору.</h3>
</div>
<br>
<div class="panel">
{!! isset($stacktrace) ? $stacktrace : '' !!}
</div>
@endsection