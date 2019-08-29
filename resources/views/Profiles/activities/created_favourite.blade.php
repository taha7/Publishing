@component('Profiles.activities.activity')
@slot('heading')
<a href=" {{$activity->subject->favourited->path()}} ">
    {{ $profileUser->name }} favourited a reply.
</a>
{{-- <a href="{{ $activity->subject->thread->path() }}">
{{ $activity->subject->thread->title }}
</a> --}}
@endslot

@slot('body')
{{ $activity->subject->favourited->body }}
@endslot

@slot('panelColor')
warning
@endslot
@endcomponent