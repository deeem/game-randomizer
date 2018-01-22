@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Отправить приглашение</h3></div>

            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('invites.process') }}">
                  {{ csrf_field() }}
                  @include('layouts.errors')

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail" placeholder="email" name="email" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                  </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
