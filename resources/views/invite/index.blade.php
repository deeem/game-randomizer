@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">Приглашения</h3></div>

      @if(count($invites))

        <table class="table">
          <tr>
            <th>email</th>
            <th>
              <a href="{{ route('invites.create') }}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </a>
            </th>
          </tr>
          @foreach($invites as $invite)
          <tr>
            <td>{{ $invite->email }}</td>
            <td>
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

      @else

        <div class="panel-body">
          <p class="text-center">Список пуст</p>
        </div>

      @endif

    </div>
  </div>
</div>
@endsection
