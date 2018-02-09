@extends('layouts.app')

@section('content')

<script>
  platform_id = {{ $platform->id }};
</script>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

      <div id="randomizer">

        <div class="randomizer-items">
          <div
            v-for="game in games"
            v-bind:class="game.class"
            class="randomizer-item">
            @{{ game.name }}
          </div>
        </div>

        <button class="btn btn-primary"
          v-on:click="roll"
          v-bind:disabled="availableGames.length === 1 ? true : false">
          roll
        </button>

      </div>

      @push('scripts')
        <script src="https://unpkg.com/vue@2.5.7/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="{{ asset('js/randomizer.js') }}"></script>
      @endpush

    </div>
</div>
@endsection
