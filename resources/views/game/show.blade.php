@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    @if($game->user_id)
      @include('game.info')
    @else
      @include('game.approve')
    @endif

  </div>
</div>
@endsection
