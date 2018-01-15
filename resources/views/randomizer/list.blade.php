<div class="randomizer-list">
  @foreach($platforms as $platform)

  <a href="{{ route('randomizer', ['platform' => $platform->slug]) }}">
      {{ $platform->name }}
  </a>

  @endforeach
</div>
