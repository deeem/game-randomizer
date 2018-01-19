<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Топ модераторов</h3></div>
  <table class="table">
    <tr>
      <th>Имя</th>
      <th>Очков</th>
    </tr>
    @foreach($approvers as $approver)
    <tr>
      <td>{{ $approver->name }}</td>
      <td>{{ $approver->approver_count }}</td>
    </tr>
    @endforeach
  </table>
</div>
