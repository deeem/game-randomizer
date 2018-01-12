@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center" style="font-size: 1.75em; font-weight: 600;">предложенные</p>
      </div>
    </div>

    @if(count($games))

    <div class="panel panel-default">
      <table class="table">
        <tr>
          <th>Название</th>
          <th>Платформа</th>
          <th></th>
        </tr>
        @foreach($games as $game)
        <tr>
          <td>{{ $game->name }}</td>
          <td>{{ $game->platform->name }}</td>
          <td>
            <a href="{{ route('games.approve', ['game' => $game->id]) }}" class="btn btn-default btn-xs">
              <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
            </a>
            &nbsp;&nbsp;
            <form action="{{ route('games.destroy', ['game' => $game->id]) }}" method="POST" style="display:inline;">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('are you shure?');">
                <span class="glyphicon glyphicon-remove-circle " aria-hidden="true"></span>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
    </div>

    @else

    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center">Список пуст</p>
      </div>
    </div>

    @endif

  </div>
</div>
@endsection
