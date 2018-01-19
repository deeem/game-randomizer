@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    @if(count($stats))
      @include('dashboard.stats')
    @else
      @include('dashboard.stats-empty')
    @endif

    @if(count($games))
      @include('dashboard.recent')
    @else
      @include('dashboard.recent-empty')
    @endif

    @if(count($suggesters))
      @include('dashboard.suggesters')
    @else
      @include('dashboard.suggesters-empty')
    @endif

  </div>
</div>
@endsection
