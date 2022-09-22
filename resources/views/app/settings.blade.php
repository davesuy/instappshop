@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form method="post" action="{{route('settings')}}" >
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">Instagram UserName</label>
                                    <input type="text" class="form-control" name="username" id="name"  value="@if($insta !== null){{$insta->username}} @endif" />
                                </div>

                                <div class="form-group">
                                    <label for="feed_count">Total Post</label>
                                    <input type="number" class="form-control" name="feed_count" id="feed_count" value="@if($user !== null){{$user->feed_count}}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="urls">Page URL (Paste the URL where you want to show the feed)</label>
                                    <textarea class="form-control" name="urls" id="urls" rows="5">@if($user !== null){{$user->page_url}}@endif</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
