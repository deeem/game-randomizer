@extends('layouts.app');

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

      @if(count($platforms))
        @include('platform.list')
      @else
        @include('platform.empty')
      @endif

    </div>
</div>
@endsection
