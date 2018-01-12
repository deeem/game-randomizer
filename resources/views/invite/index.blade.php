@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    @if(count($invites))
      @include('invite.list')
    @else
      @include('invite.empty')
    @endif

  </div>
</div>
@endsection
