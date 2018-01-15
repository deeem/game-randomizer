@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Пользователи</h3></div>

            <table class="table">
                <tr>
                    <th>имя</th>
                    <th>email</th>
                    <th class="table-actions">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="table-actions">
                        <a href="{{ route('users.edit', ['user' => $user->id ]) }}" class="btn btn-default btn-xs">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        &nbsp;
                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" style="display:inline;">
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
    </div>
</div>
@endsection
