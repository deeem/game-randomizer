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
                        <a href="/platform/create" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </th>
                </tr>
                @foreach($platforms as $platform)
                <tr>
                    <td>{{ $platform->name }}</td>
                    <td>
                        <a href="/platform/{{ $platform->id }}/edit" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="/platform/{{ $platform->id }}/destroy" class="btn btn-danger btn-xs" onclick="return confirm('are you sure?');">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
