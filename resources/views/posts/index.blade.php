@extends('layouts.app')

@section('content')
<div class="container">
    @if($posts->count() == 0)
        <p><strong>You don't follow any profile yet</strong></p>
    @endif
   @foreach ($posts as $post)
    <div class="row pt-5">
        <div class="col-6 offset-3">
            <a href="/p/{{$post->id}}"><img class="img-fluid" src="/storage/{{$post->image}}" alt="{{ strip_tags($post->caption)}}"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-6 offset-3 mt-4">
            <div class="heading d-flex align-items-center">
                <img class="rounded-circle img-fluid mr-2" width="40" src="{{$post->user->profile->profileImage()}}" alt="{{$post->user->username}} profile image">
                <div class="p-0 font-weight-bold mr-2"><a class="text-dark" href="/profile/{{$post->user->username}}">{{$post->user->username}}</a></div>
                <follow-button user-id={{$post->user->id}} follows={{$follows}}></follow-button>
                <like-button post-id={{$post->id}} is-liked={{$isLiked}}></like-button>
                <div class="counter ml-3">Liked by {{$likesCount}} people</div>
            </div>
            <hr>
            <div class="body mt-3">
                {!! $post->caption !!}
            </div>
        </div>
    </div>    
   @endforeach

  <!-- Pagination -->
  <div class="row align-items-center">
      <div class="col-12">
        {{ $posts->links() }}
      </div>
  </div>
</div>
@endsection
