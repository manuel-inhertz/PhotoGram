@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row pt-5 justify-content-center">
       <div class="col-7">
        <img class="img-fluid" src="/storage/{{$post->image}}" alt="{{ strip_tags($post->caption)}}">
       </div>
       <div class="col-5">
            <div class="heading d-flex align-items-center">
                <img class="rounded-circle img-fluid mr-2" width="40" src="{{$post->user->profile->profileImage()}}" alt="{{$post->user->username}} profile image">
                <div class="p-0 font-weight-bold"><a class="text-dark" href="/profile/{{$post->user->username}}">{{$post->user->username}}</a></div>
                @if (auth()->user()->id != $post->user->id)
                <follow-button user-id={{$post->user->id}} follows={{$follows}}></follow-button>
                @endif
                <like-button post-id={{$post->id}} is-liked={{$isLiked}}></like-button>
                <div class="counter ml-3">Liked by {{$likesCount}} people</div>
            </div>
            <hr>
           <div class="body mt-3">
                {!! $post->caption !!}
           </div>
           <hr>
        <comments-grid post-id={{$post->id}} auth-username="{{auth()->user()->username}}"></comments-grid>
       </div>
   </div>
</div>
@endsection
