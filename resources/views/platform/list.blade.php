<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Платформы</h3></div>

  <table class="table">
    <tr>
      <th>название</th>
      <th class="table-actions">
        <a href="{{ route('platforms.create') }}" class="btn btn-primary btn-sm">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
      </th>
    </tr>
    @foreach($platforms as $platform)
    <tr>
      <td>{{ $platform->name }}</td>
      <td class="table-actions">
        <a href="{{ route('platforms.edit', ['platform' => $platform->slug]) }}" class="btn btn-default btn-xs">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        &nbsp;
        <form action="{{ route('platforms.destroy', ['platform' => $platform->slug]) }}" method="POST" style="display:inline;">
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
