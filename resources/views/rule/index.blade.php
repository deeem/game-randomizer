@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

      @if(count($rules))
        @include('rule.list')
      @else
        @include('rule.empty')
      @endif

    </div>
</div>
@endsection
