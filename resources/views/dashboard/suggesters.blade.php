<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Топ предлагателей</h3></div>
  <table class="table">
    <tr>
      <th>Имя</th>
      <th>Очков</th>
    </tr>
    @foreach($suggesters as $suggester)
    <tr>
      <td>{{ $suggester->name }}</td>
      <td>{{ $suggester->suggester_count }}</td>
    </tr>
    @endforeach
  </table>
</div>
