<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Топ модераторов</h3></div>
  <table class="table">
    <tr>
      <th>Очков</th>
      <th>Имя</th>
    </tr>
    @foreach($approvers as $approver)
    <tr>
      <td>{{ $approver->approver_count }}</td>
      <td>{{ $approver->name }}</td>
    </tr>
    @endforeach
  </table>
</div>
