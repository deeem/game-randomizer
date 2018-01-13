<div class="list-group">
@foreach($platforms as $platform)
  <a href="{{ route('randomizer', ['platform' => $platform->slug]) }}" class="list-group-item">{{ $platform->name }}</a>
@endforeach
</div>
