@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    @if(count($games))
      @include('dashboard.recent')
    @endif

    <div class="row">
      <div class="col-md-6">
      @if(count($suggesters))
        @include('dashboard.suggesters')
      @endif
      </div>
      <div class="col-md-6">
      @if(count($approvers))
        @include('dashboard.approvers')
      @endif
      </div>
    </div>

    @if(count($stats) && $max > 0)
      @include('dashboard.stats')
    @endif

  </div>
</div>
@endsection
