@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center" style="font-size: 1.75em; font-weight: 600;">информация об игре</p>
      </div>
    </div>

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

        @if($game->user_id)
          <p>
            <span class="text-muted">Проверил: </span>
            {{ $game->user->name }}
          </p>
        @endif

        <hr>
        <div class="row">
          <div class="col-md4 col-md-offset-4">

            <a href="{{ route('games.edit', ['game' => $game->id]) }}" class="btn btn-default">
              <i class="fa fa-pencil" aria-hidden="true"></i> Изменить
            </a>

            <form action="{{ route('games.destroy', ['game' => $game->id]) }}" method="POST" style="display:inline;">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger" onclick="return confirm('are you shure?');">
                <i class="fa fa-trash-o" aria-hidden="true"></i> Удалить
              </button>
            </form>

          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection
