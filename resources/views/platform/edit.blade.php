@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Редактировать платформу</h3></div>

            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('platforms.update', ['platform' => $platform->slug]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Название</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputName" placeholder="Название" name="name" value="{{ $platform->name }}" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-default">Сохранить</button>
                    </div>
                  </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
