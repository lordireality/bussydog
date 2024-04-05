@extends('templates.PageCoreWiki')


@section('pagename', 'wiki-Редактор')

@section('content')
<div class="panel"><h1>Редактирование - {{$article->name}}</h1>
<a class="button2" href="#">Предпросмотр</a>
<a class="button2" href="#">Сохранить</a>
</div>
<div id="editArticle" style="text-align:left">
    <div class="panel">
        <h3>Редактор</h3>
    </div>
    <textarea id="editArticleSource" hidden>{!!$article->content!!}</textarea>
    <div class="editor" id="articleEditor"></div>
</div>
<div id="previewArticle">
    <div class="panel">
        <h3>Предпросмотр</h3>
    </div>
    <div id="previewPlaceholder" style="all: initial;">

    </div>
</div>

<script>var require = { paths: { 'vs': '{{ asset('/content/monaco-editor/min/vs/') }}' } };</script>
<script src="{{ asset('/content/monaco-editor/min/vs/loader.js') }}"></script>
<script src="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.nls.js') }}"></script>
<script src="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.js') }}"></script>
<link rel="stylesheet" data-name="vs/editor/editor.main" href="{{ asset('/content/monaco-editor/min/vs/editor/editor.main.css') }}">
<script>
var viewEditor = monaco.editor.create(document.getElementById('articleEditor'), {
    value: document.getElementById('editArticleSource').value,
    language: 'php',
    fontSize: 16
});

</script>
@endsection