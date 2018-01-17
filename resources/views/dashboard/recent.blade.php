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
      <td>
        @isset($game->suggester->name)
          {{ $game->suggester->name }}
        @else
          Anonymous
        @endisset
      </td>
    </tr>
    @endforeach
  </table>
</div>
