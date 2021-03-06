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
          <th class="table-actions-thin"></th>
        </tr>
        @foreach($games as $game)
        <tr>
          <td>{{ $game->name }}</td>
          <td>{{ $game->platform->name }}</td>
          <td  class="table-actions-thin">
            <a href="{{ route('games.show', ['game' => $game->id]) }}" class="btn btn-default btn-xs">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    <div class="panel panel-default">
      <div class="row">
        <div class="text-center">
          {{ $games->links() }}
        </div>
      </div>
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
