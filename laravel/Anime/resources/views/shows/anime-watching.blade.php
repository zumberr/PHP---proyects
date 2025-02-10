@extends('layouts.app')

@section('content')




<div class="breadcrumb-option"  style="margin-top: -100px; background-color: #0B0C2A">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="./categories.html">Categories</a>
                    <a href="#">{{ $show->genere }}</a>
                    <span>{{ $show->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Anime Section Begin -->
<section class="anime-details spad"  style="background-color: #0B0C2A">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="anime__video__player">
                    <video id="player" playsinline controls data-poster="{{ asset('assets/thumbnails/'.$episode->thumbnail.'') }}">
                        <source src="{{ asset('assets/videos/'.$episode->video.'') }}" type="video/mp4" />
                        <!-- Captions are optional -->
                        <track kind="captions" label="English captions" src="#" srclang="en" default />
                    </video>
                </div>
                <div class="anime__details__episodes">
                    <div class="section-title">
                        <h5>List Name</h5>
                    </div>
                    @foreach ($episodes as $episode)
                        <a href="{{ route('anime.watching', ['show_id' => $show->id,'episode_id' => $episode->episode_name]) }}">Ep {{ $episode->episode_name }}</a>
    
                    @endforeach
                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="anime__details__review">
                    <div class="section-title">
                        <h5>Reviews</h5>
                    </div>
                    @foreach ($comments as $comment)
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="{{ asset('assets/user_images/'.$comment->image.'') }}" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>{{ $comment->user_name }} - <span>{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y')}}</span></h6>
                                <p>
                                    {{ $comment->comment }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                   
                    
                </div>
                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Your Comment</h5>
                    </div>
                    @if(isset(auth::user()->id))

                        <form  method="POST" action="{{ route('anime.insert.comments', $show->id) }}">
                            @csrf
                            <textarea name="comment" placeholder="Your Comment"></textarea>
                            <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                        </form>
                    @else 
                         <p class="alert alert-success">login to write a comment</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection