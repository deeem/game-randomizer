@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">

      @if(count($platforms))
        @include('randomizer.list')
      @else
        @include('randomizer.empty')
      @endif

    </div>
</div>
@endsection
