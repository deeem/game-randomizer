<div class="randomizer-platform-list">
  @foreach($platforms as $platform)

  <a href="{{ route('randomizer', ['platform' => $platform->slug]) }}" class="randomizer-platform-list-item">
      {{ $platform->name }}
  </a>

  @endforeach
</div>
