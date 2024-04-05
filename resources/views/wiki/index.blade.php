@extends('templates.PageCoreWiki')


@section('pagename', 'wiki-Главная')

@section('content')
<div class="panel"><h1>База знаний - {{config('app.organizationname')}}</h1></div>
<?php include_once(resource_path()."/UIStaticPagesAssembly/wiki.php") ?>
@endsection