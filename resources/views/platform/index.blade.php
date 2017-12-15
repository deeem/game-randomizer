@extends('layouts.app');

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Платформы</h3></div>

            <table class="table">
                <tr>
                    <th>название</th>
                    <th>
                        <a href="/platforms/create" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </th>
                </tr>
                @foreach($platforms as $platform)
                <tr>
                    <td>{{ $platform->name }}</td>
                    <td>
                        <a href="/platforms/{{ $platform->id }}/edit" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                        &nbsp;&nbsp;
                        <form action="/platforms/{{ $platform->id }}" method="POST" style="display:inline;">
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
    </div>
</div>
@endsection
