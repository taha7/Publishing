@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create A New Thread</div>

                <div class="panel-body">
                    <form method="POST" action="/threads">
                        {{csrf_field()}}

                        <!-- Select A channel for a thread -->
                        <div class="form-group">
                            <label for="channel_id">Choose a channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one</option>
                                @foreach ($channels as $channel)
                                    <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                                        {{$channel->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type a title for a thread -->
                        <div class="form-goup" style="margin-bottom:20px">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" required>
                        </div>

                        <!-- Type a thread text -->
                        <div class="form-goup" style="margin-bottom:20px">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" class="form-control" rows="8" required>{{old('body')}}</textarea>
                        </div>

                        <!-- Here where we submit a form -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Publish</button>
                        </div>

                        <!-- What if we have errors -->
                        @if ($errors->count())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection