@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{$user->profile->profileImage()}}" class="rounded-circle img-fluid">
        </div>
        <div class="col-9 pt-5">
            <div>
                <div class="profile-heading d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center mb-3">
                        <div class="h4">{{ $user->username }}</div>
                        @if (auth()->user()->id != $user->profile->user_id)
                            <follow-button user-id={{$user->id}} follows={{$follows}}></follow-button>
                        @endif
                    </div>
                    <div class="settings w-25 d-flex justify-content-between">
                        @can('update', $user->profile)
                            <a href="/p/create">Add New Post</a>
                            <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
                        @endcan
                    </div>
                </div>
                <div class="profile-details d-flex">
                    <p class="pr-4"><strong>{{ $postCount }}</strong> posts</p>
                <p class="pr-4"><strong>{{ $followersCount }}</strong> followers</p>
                    <p class="pr-4"><strong>{{ $followingCount }}</strong> following</p>
                </div>
                <div class="profile-description pt-3">
                    <p>
                        <strong>{{ $user->profile->title }}</strong><br>
                        {{$user->profile->description}}
                    </p>
                    <a href="{{$user->profile->url}}">{{$user->profile->url ?? 'N/A'}}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Posts Listing -->
    <div class="row pt-5">
        @if($user->posts->count() == 0)
        <p><strong>No posts yes, please add one now!</strong></p>
        @endif
        @foreach($user->posts as $post)
            <div class="col-4">
                <a href="/p/{{$post->id}}">
                    <img class="img-fluid" src="/storage/{{$post->image}}" alt="{{$post->caption}}">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
