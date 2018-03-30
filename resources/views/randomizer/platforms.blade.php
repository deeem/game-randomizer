@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">

      @if(count($platforms))
        <div class="randomizer-platform-list">
          @foreach($platforms as $platform)

          <a href="{{ route('randomizer', ['platform' => $platform->slug]) }}" class="randomizer-platform-list-item">
              {{ $platform->name }}
          </a>

          @endforeach
        </div>
      @else
        <div class="well">Список пуст</div>
      @endif

    </div>
</div>
@endsection
