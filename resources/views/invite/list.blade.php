<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Приглашения</h3></div>

  <table class="table">
    <tr>
      <th>email</th>
      <th class="table-actions">
        <a href="{{ route('invites.create') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-plus" aria-hidden="true"></i>
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
            <i class="fa fa-trash-o" aria-hidden="true"></i>
          </button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>

</div>
