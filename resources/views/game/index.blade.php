@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center" style="font-size: 1.75em; font-weight: 600;">{{ $name }}</p>
      </div>
    </div>

    @if(count($games))

    <div class="panel panel-default">
      <table class="table">
        <tr>
          <th>Название</th>
          <th>Предложил</th>
          @if(auth()->check() && auth()->user()->inRole('game-management'))
          <th class="table-actions-thin"></th>
          @endif
        </tr>
        @foreach($games as $game)
        <tr>
          <td>
            {{ $game->name }}
          </td>
          <td>
            @if($game->suggester)
            {{ $game->suggester->name }}
            @endif
          </td>
          @if(auth()->check() && auth()->user()->inRole('game-management'))
          <td class="table-actions-thin">
            <a href="{{ route('games.show', ['game' => $game->id]) }}" class="btn btn-default btn-xs">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </a>
          </td>
          @endif
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
