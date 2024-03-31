@extends('templates.PageCoreAuth')


@section('pagename', 'Профиль пользователя '.$viewUser->lastname.' '.(mb_substr($viewUser->firstname, 0, 1) ?? '').(mb_substr($viewUser->middlename, 0, 1) ?? ''))

@section('content')
<div class="panel"><h1>Пользователь: {{$viewUser->lastname}} {{$viewUser->firstname ?? ''}} {{$viewUser->middlename ?? ''}} @if($viewUser->isBlocked == 1) <i style="color:red">[Заблокирован]</i> @endif</h1></div>
<div style="width:100%; text-align:left;">
    <img style="margin: 10px; border: 1px solid gray; border-radius: 128px; width:128px; height:128px; display:inline-block;" src="{{$viewUser->photoBase64 ?? '/content/images/default.png'}}">
    <div style="display:inline-block; vertical-align:top; padding: 10px;">
        <h3>Должность: </h3>
        <h3>Эл. почта: {{$viewUser->email}}</h3>
        <h3>Дата рождения: {{$viewUser->birthday ?? 'Информация не указана'}}</h3>
        <h3>В компании с: {{$viewUser->inCompanyFrom ?? 'Информация не указана'}}</h3>
        <br>
        <h3>О себе: </h3>
        <p>{{$viewUser->description}}</p>
    </div>
</div>
<div class="panel"><h1>Участие в группах</h1></div>

@endsection