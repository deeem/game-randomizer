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
          <th class="table-actions"><i class="fa fa-cog fa-2x" aria-hidden="true"></i></th>
        </tr>
        @foreach($games as $game)
        <tr>
          <td>{{ $game->name }}</td>
          <td>{{ $game->suggested }}</td>
          <td>
            <a href="{{ route('games.edit', ['game' => $game->id]) }}" class="btn btn-default btn-xs">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            &nbsp;
            <form action="{{ route('games.destroy', ['game' => $game->id]) }}" method="POST" style="display:inline;">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('are you shure?');">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
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
