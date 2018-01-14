<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Приглашения</h3></div>

  <table class="table">
    <tr>
      <th>email</th>
      <th class="table-actions">
        <a href="{{ route('invites.create') }}" class="btn btn-primary btn-sm">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
      </th>
    </tr>
    @foreach($invites as $invite)
    <tr>
      <td>{{ $invite->email }}</td>
      <td class="table-actions">
        <form action="{{ route('invites.destroy', ['invite' => $invite->id]) }}" method="POST" style="display:inline;">
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
