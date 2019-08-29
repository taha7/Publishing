@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-offset-2">
            <div class="page-header">
                <h1>
                    {{$profileUser->name}}
                </h1>
            </div>

            @foreach ($grouped_activities as $date => $activities)
            <h3 class="page-header"> {{ $date }} </h3>
            @foreach ($activities as $activity)
            @if(view()->exists("profiles.activities.{$activity->type}"))
            @include("profiles.activities.{$activity->type}")
            @endif
            @endforeach
            @endforeach

            {{-- {{ $threads->links() }} --}}
        </div>
    </div>
</div>
@endsection