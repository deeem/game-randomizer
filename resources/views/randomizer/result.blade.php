@extends('layouts.app')

@section('content')

<script>
  platform_id = {{ $platform->id }};
</script>

@push('scripts')
<script src="https://unpkg.com/vue@2.5.7/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/randomizer.js') }}"></script>
@endpush

<div id="randomizer">

  <div class="row">
    <div class="col-md-6 col-md-offset-3">

      <div class="randomizer-items">
        <div class="randomizer-item" v-for="game in games" v-bind:class="game.class">
          @{{ game.name }}
        </div>
      </div>

    </div>
  </div>

  <div class="row">
    <div class="text-center">

      <button class="btn btn-primary" v-on:click="roll" v-bind:disabled="availableGames.length === 1 ? true : false">
        roll
      </button>

    </div>
  </div>

</div>
@endsection
