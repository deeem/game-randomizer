@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">

      @isset($game)
      <div class="randomizer-result">
        <p>{{ $game->name }}<span>({{ $platform->name }})</span></p>
      </div>
      @endisset

      @empty($game)
        <div class="well well-lg"><h1>Список пуст</h1></div>
      @endempty

    </div>
</div>
@endsection
