@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-default">
          <div class="panel-body">
            <p class="text-center" style="font-size: 1.75em; font-weight: 600;">{{ $games->first()->platform->name }}</p>
          </div>
        </div>

          <div class="panel panel-default">
            <table class="table">
                <tr>
                    <th>Название</th>
                    <th>Предложил</th>
                    <th></th>
                </tr>
                @foreach($games as $game)
                <tr>
                    <td>{{ $game->name }}</td>
                    <td>{{ $game->suggested }}</td>
                    <td>
                        <a href="/games/{{ $game->id }}/edit" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                        &nbsp;&nbsp;
                        <form action="/games/{{ $game->id }}" method="POST" style="display:inline;">
                             {{ method_field('DELETE') }}
                             {{ csrf_field() }}
                             <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('are you shure?');">
                                <span class="glyphicon glyphicon-trash " aria-hidden="true"></span>
                              </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

    </div>
</div>
@endsection
