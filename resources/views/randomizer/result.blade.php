@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">

      @isset($game)
      <div class="randomizer-result">
        <div class="randomizer-result-game">
          <p>{{ $game->name }}</p>
        </div>
        <div class="randomizer-result-platform">
          <p>{{ $platform->name }}</p>
        </div>
      </div>
      @endisset

      @empty($game)
        <div class="well well-lg"><h1>Список пуст</h1></div>
      @endempty

      @push('scripts')
        <script src="{{ asset('js/randomizer.js') }}"></script>
      @endpush

    </div>
</div>
@endsection
