@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    @if(count($counts))
    <div class="panel panel-default">
      <div class="panel-heading"></h3 class="panel-title">Добавлено игр</h3></div>
      <div class="panel-body">
      @foreach($counts as $name => $value)
        <div class="progress">
          <div class="progress-bar" style="width: {{ $value / $max * 100 }}%;">
            {{ $name }}
          </div>
        </div>
      @endforeach
      </div>
    </div>
    @endif

    @if(count($games))

    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">Последние добавленные игры</h3></div>
      <table class="table">
        <tr>
          <th>Игра</th>
          <th>Предложил</th>
        </tr>
        @foreach($games as $game)
        <tr>
          <td>{{ $game->name }} ({{ $game->platform->name}})</td>
          <td>{{ $game->suggested }}</td>
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
