<div class="panel panel-default">
  <div class="panel-heading"></h3 class="panel-title">Добавлено игр</h3></div>
  <div class="panel-body">
  @foreach($counts as $name => $value)
    <div class="progress">
      <div class="progress-bar" style="width: {{ $value / $max * 100 }}%;">
        {{ $name }}
      </div>
    </div>
  @endforeach
  </div>
</div>
