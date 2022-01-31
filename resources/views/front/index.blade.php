@extends('layout.front-master')
@section('title', 'Lance Master | Home Page')

@section('content')

    <div id="carousalTop" class="carousel slide mt-5" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($banners as $key => $banner)
                <li data-target="#carousalTop" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach ($banners as $key => $banner)
                <div class="carousel-item @if ($key == 0) active @endif " >
                    <img src="{{ asset($banner->image) }}" style="width: 100% !important" class="w-100 d-block" alt="...">
                </div>    
            @endforeach
           

        </div>
 
    </div>

    <div class="videos-row row justify-content-md-center">
        <div class="col-lg-12">
            <div class="heading">
                <h2>Recommended For You</h2>
            </div>
            <div class="slick-slider">
                <div class="row">
                    @foreach ($recommendedVideos as $video)
                        <div class="col-3 video-box">
                            <div class="boxImg">
                                @php
                                    if($video->continueWatches->first()){
                                        $v_time = round($video->continueWatches->first()->time);
                                    }
                                    else{
                                        $v_time = 0;
                                    }
                                @endphp
                                <img width="100%" height="150" src="{{ asset($video->thumbnail) }}" data-href="{{ URL::to('/video', $video->id) }}"
                                     class="video-list clickable" />
                                {{-- <video controls width='100%' id="recommendedVideoPlayer{{ $video->id }}" height='200px' onclick="playVideo(this.id);">
                                    <source src="{{ asset($video->video_path) }}">
                                </video> --}}
                                <div class="pt-3 video-content">
                                   <!--  <div class="title">
                                        <div>
                                            {{ $video->title }}
                                            <p class="float-right">
                                                @if (isset($video->views))
                                                    {{ sizeof($video->views) }} Views
                                                @endif
                                            </p>
                                        </div>
                                    </div> -->
                                    <div class="details mt-1">
                                        <div class="profile-pic">
                                            <img src="{{ asset('assets/front/images/dummy.jpg') }}" alt="">
                                        </div>
                                        <div class="video-details">
                                            <div>{{ $video->title }}</div>
                                            <div class="channel">
                                                <a href="{{ route('channel.index', $video->user->id) }}" class="color-white">
                                                    <span class="text-capitalize">{{ $video->user->name }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="ml-auto">
                                            @if (isset($video->views))
                                            {{ sizeof($video->views) }} Views
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="videos-row row justify-content-md-center">
        <div class="col-lg-12">
            <div class="heading">
                <h2>Watch List</h2>
            </div>
            <div class="slick-slider">
                <div class="row">
                    @foreach ($watchlistVideos as $video)
                        <div class="col-3 video-box">
                            <div class="boxImg">
                                @php
                                    if($video->continueWatches->first()){
                                        $v_time = round($video->continueWatches->first()->time);
                                    }
                                    else{
                                        $v_time = 0;
                                    }
                                @endphp
                                <img src="{{ asset($video->thumbnail) }}" data-href="{{ URL::to('/video', $video->id) }}"
                                    class="video-list clickable" />
                                {{-- <video controls width='100%' id="recommendedVideoPlayer{{ $video->id }}" height='200px' onclick="playVideo(this.id);">
                                    <source src="{{ asset($video->video_path) }}">
                                </video> --}}
                                <div class="pt-3 video-content">
                                    <div class="details mt-1">
                                        <div class="profile-pic">
                                            <img src="{{ asset('assets/front/images/dummy.jpg') }}" alt="">
                                        </div>
                                        <div class="video-details">
                                            <div>{{ $video->title }}</div>
                                            <div class="channel">
                                                <a href="{{ route('channel.index', $video->user->id) }}" class="color-white">
                                                    <span class="text-capitalize">{{ $video->user->name }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="ml-auto">
                                            @if (isset($video->views))
                                            {{ sizeof($video->views) }} Views
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="videos-row row justify-content-md-center">
        <div class="col-lg-12">
            <div class="heading">
                <h2>Continue Watching</h2>
            </div>
            <div class="slick-slider">
                <div class="row">
                    @foreach ($contWatchesVideos as $video)
                        <div class="col-3 video-box">
                            <div class="boxImg">
                                @php 
                                    if($video->continueWatches->first()){
                                        $v_time = round($video->continueWatches->first()->time);
                                    }
                                    else{
                                        $v_time = 0;
                                    }
                                @endphp
                                <img src="{{ asset($video->thumbnail) }}" data-href="{{ URL::to('/video', $video->id) }}"
                                    class="video-list clickable" />
                                {{-- <video controls width='100%' id="recommendedVideoPlayer{{ $video->id }}" height='200px' onclick="playVideo(this.id);">
                                    <source src="{{ asset($video->video_path) }}">
                                </video> --}}
                                <div class="pt-3 video-content">
                                    <div class="details mt-1">
                                        <div class="profile-pic">
                                            <img src="{{ asset('assets/front/images/dummy.jpg') }}" alt="">
                                        </div>
                                        <div class="video-details">
                                            <div>{{ $video->title }}</div>
                                            <div class="channel">
                                                <a href="{{ route('channel.index', $video->user->id) }}" class="color-white">
                                                    <span class="text-capitalize">{{ $video->user->name }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="ml-auto">
                                            @if (isset($video->views))
                                            {{ sizeof($video->views) }} Views
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </div>
    </div>

    <div class="videos-row row justify-content-md-center">
        <div class="col-lg-12">
            <div class="heading"   style="text-de: 2px solid white">
                <h2>Trending</h2>
            </div>
            <div class="slick-slider" >
                <div class="row">
                    @foreach ($trendingVideos as $video)
                        <div class="col-3 video-box">
                            <div class="boxImg">
                                @php 
                                    if($video->record->continueWatches->first()){
                                        $v_time = round($video->record->continueWatches->first()->time);
                                    }
                                    else{
                                        $v_time = 0;
                                    }
                                @endphp
                                <img src="{{ asset($video->record->thumbnail) }}" data-href="{{ URL::to('/video', $video->record->id) }}"
                                    class="video-list clickable" />
                                {{-- <video controls width='100%' id="recommendedVideoPlayer{{ $video->record->id }}" height='200px' onclick="playVideo(this.id);">
                                    <source src="{{ asset($video->record->video_path) }}">
                                </video> --}}
                                <div class="pt-3 video-content">
                                    <div class="details mt-1">
                                        <div class="profile-pic">
                                            <img src="{{ asset('assets/front/images/dummy.jpg') }}" alt="">
                                        </div>
                                        <div class="video-details">
                                            <div>{{ $video->record->title }}</div>
                                            <div class="channel">
                                                <a href="{{ route('channel.index', $video->record->user->id) }}" class="color-white">
                                                    <span class="text-capitalize">{{ $video->record->user->name }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="ml-auto">
                                            @if (isset($video->record->views))
                                            {{ sizeof($video->record->views) }} Views
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
    $( function() {
        $('.slick-track').addClass('float-left');
    });
    </script>
@endpush