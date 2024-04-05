@extends('templates.PageCoreWiki')


@section('pagename', 'wiki-Статья')

@section('content')
<?php
$canEdit = true;
?>
<div class="panel">@if($canEdit==true)<a style="display:inline-block; margin-right:10px;" class="button2" href="{{route('wiki-article-edit',['articleid'=>$article->id])}}"><p class="icon-button pen"></p></a>@endif<h1 style="display:inline-block;">{{$article->name}}</h1></div>
<div style="all: initial; ">
{!!$article->content!!}
</div>
@endsection


