<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Топ предлагателей</h3></div>
  <table class="table">
    <tr>
      <th>Очков</th>
      <th>Имя</th>
    </tr>
    @foreach($suggesters as $suggester)
    <tr>
      <td>{{ $suggester->suggester_count }}</td>
      <td>{{ $suggester->name }}</td>
    </tr>
    @endforeach
  </table>
</div>
