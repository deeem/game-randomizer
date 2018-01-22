@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">Редактировать правило</h3></div>

      <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('rules.update', ['rule' => $rule->id]) }}">

          {{ csrf_field() }}
          {{ method_field('PUT') }}
          @include('layouts.errors')

          <div class="form-group">
            <label for="inputTitle" class="col-sm-4 control-label">Заголовок</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputTitle" placeholder="Загловок" name="title" required value="{{ $rule->title }}">
            </div>
          </div>

          <div class="form-group">
            <label for="inputBody" class="col-sm-4 control-label">Описание</label>
            <div class="col-sm-8">
              <textarea name="body" class="form-control" id="inputBody" placeholder="Описание">{{ $rule->body }}</textarea>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
