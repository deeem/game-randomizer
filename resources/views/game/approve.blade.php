@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center" style="font-size: 1.75em; font-weight: 600;">информация об игре</p>
      </div>
    </div>

    <div class="row">

      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">

            <p>
              <span class="text-muted">Название: </span>
              <strong class="text-uppercase">{{ $game->name }}</strong>
            </p>

            <p>
              <span class="text-muted">Платформа: </span>
              {{ $game->platform->name }}
            </p>

            @if($game->suggester_id)
            <p>
              <span class="text-muted">Предложил: </span>
              {{ $game->suggester->name }}
            </p>
            @endif

            <hr>
            <a href="{{ route('games.approve', ['game' => $game->id]) }}" class="btn btn-success">
              <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Добавить
            </a>

          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">
            @if($rules->count())
            <form action="{{ route('games.refuse', ['game' => $game->id]) }}" method="POST" style="display:inline;">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              @foreach($rules as $rule)
                <div class="radio">
                  <label>
                    <input type="radio" name="rule_id" value="{{ $rule->id }}">
                    {{ $rule->title }}
                  </label>
                </div>
              @endforeach
              <hr>
              <button type="submit" class="btn btn-danger">
                <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Отклонить
              </button>
            </form>
            @endif
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection
