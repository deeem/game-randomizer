<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Причины отказа в добавлении игры</h3></div>

  <table class="table">
    <tr>
      <th></th>
      <th></th>
      @if(auth()->check() && auth()->user()->inRole('rule-management'))
      <th class="table-actions">
        <a href="{{ route('rules.create') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
      </th>
      @endif
    </tr>
    @foreach($rules as $rule)
    <tr>
      <td><strong>{{ $rule->title }}</strong></td>
      <td>{{ $rule->body }}</td>
      @if(auth()->check() && auth()->user()->inRole('rule-management'))
      <td class="table-actions">
        <a href="{{ route('rules.edit', ['rule' => $rule->id]) }}" class="btn btn-default btn-xs">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
        &nbsp;
        <form action="{{ route('rules.destroy', ['rule' => $rule->id]) }}" method="POST" style="display:inline;">
          {{ method_field('DELETE') }}
          {{ csrf_field() }}
          <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('are you shure?');">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
          </button>
        </form>
      </td>
      @endif
    </tr>
    @endforeach
  </table>
</div>
