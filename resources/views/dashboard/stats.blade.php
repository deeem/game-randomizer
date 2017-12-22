<div class="panel panel-default">
  <div class="panel-heading"></h3 class="panel-title">Соотношение добавленных игр по платформам</h3></div>
  <div class="panel-body">
  @foreach($stats as $platform)
    <div class="progress">
      <div class="progress-bar" style="width: {{ $platform['gamesCount'] / $max * 100 }}%;">
        {{ $platform['name'] }}
      </div>
    </div>
  @endforeach
  </div>
</div>
