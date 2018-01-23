@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">Предложить игру</h3></div>

      <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('games.store')}}">

          {{ csrf_field() }}
          @include('layouts.errors')

          <div class="form-group">
            <label for="inputName" class="col-sm-3 control-label">Название</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="inputName" placeholder="Название игры" name="name" required>
            </div>
          </div>

          <div class="form-group">
            <label for="platform_id" class="col-sm-3 control-label">Платформа</label>
            <div class="col-sm-6">
                @foreach($platforms as $platform)
                  <div class="radio">
                    <label>
                      <input type="radio" name="platform_id" value="{{ $platform->id }}">
                      {{ $platform->name }}
                    </label>
                  </div>
                @endforeach
            </div>
          </div>

          @guest
          <div class="form-group">
            <label for="inputSuggest" class="col-sm-3 control-label">Предложил</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="inputSuggest" placeholder="Ваше имя (не обязательно)" name="suggester_name">
            </div>
          </div>

          <div class="form-group">
            <label for="inputSuggest" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="inputSuggest" placeholder="Ваш email (не обязательно)" name="suggester_email">
            </div>
          </div>
          @endguest

          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-6">
              <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
          </div>

          <hr>

          <p class="text-primary">
            Ознакомтесь с причинами, по которым предложенная игра может быть
            <a href="{{ route('rules.index') }}" class="alert-link"> <strong>отклонена</strong></a>
          </p>
          <p class="text-primary">
            Укажите email, если хотите получить уведомление о том добавлена Ваша игра или отклонена (и почему)
          </p>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
