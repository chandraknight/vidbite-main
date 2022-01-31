@extends('layout.studio-dashboard')
@section('title', 'Lance Master | Home Page')

@section('content')


    <h2 class="text-uppercase"> Edit {{ $video->title }}</h2>
    <form class="" method="POST" action="{{ route('user.updateVideo', $video->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-5">

            <div class="col-md-6">
                <label>Video Title</label>
                <input type="text" class="form-control" name="video_title" placeholder="Video Title"
                    value="{{ $video->title }}" />
            </div>

            <div class="col-md-6">
                <label>Video Category</label>
                <select name="video_category" id="videoCategory" class="w-100 " required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $video->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mt-3">
                <label>Video Description</label>
                <textarea name="description" class="form-control" rows="10">{{ $video->description }}</textarea>
            </div>
            <div class="col-md-6 mt-3">
                <label>Video Tags <sub class="red">Please separate tags with ,</sub></label>
                <input type="text" name="video_tags" value="{{ $video->tags }}" id="tags" class="form-control"
                    placeholder="Video tag">
            </div>

            <div class="col-md-6 mt-3">
                <label for="videoPlaylist">Video Playlist</label>

                {{-- {{ $video->playlists[0] }} --}}
                <div class="w-100" id="playlistCheck">
                    <input type="radio" name="playList" value="yes" id="playListYes"
                        onchange="showPlaylistSelect(this.value)">
                    Yes :
                    <input type="radio" name="playList" value="No" id="playListNo"
                        onchange="showPlaylistSelect(this.value)"> No
                    :
                </div>
                {{-- {{ sizeof($video->playlists) }} --}}
                <div class="w-100 d-none" id="playlistSelect">
                    <br>

                    @if (sizeof($video->playlists) > 0)
                        <select name="video_playlist" id="videoPlaylist" class="w-100 ">
                            @foreach ($playlists as $playlist)
                                <option value="{{ $playlist->id }}"
                                    {{ $video->playlists[0]->id == $playlist->id ? 'selected' : '' }}>
                                    {{ $playlist->playlist_name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select name="video_playlist" id="videoPlaylist" class="w-100 ">
                            <option value="" disabled selected>Select Playlist</option>
                            @foreach ($playlists as $playlist)
                                <option value="{{ $playlist->id }}"> {{ $playlist->playlist_name }} </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <label class="d-block">Video Thumbnail</label>
                <div class="drop-zone drop-thumbnail">
                    {{-- <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Video Thumbnail </b></span> --}}
                    <input type="file" name="thumbnail" id="thumbnail" class="drop-zone__input">
                    <img src="{{ $video->thumbnail }}" 
                    class="drop-img" alt="...">
                </div>
                
                {{-- <input type='file' name="thumbnail" id="thumbnail" /> --}}

            </div>
            <div class="col-md-6 mt-4">
                <label class="d-block">Video</label>
                <div class="drop-zone">
                    {{-- <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Video Content </b></span> --}}
                    <input type="file" name="video" id="video" class="drop-zone__input">
                    <video controls width='100%' >
                        <source src="{{ asset($video->video_path) }}">
                    </video>
                </div>
                {{-- <video controls width='100%' height="250px" id="recommendedVideoPlayer{{ $video->id }}"
                    onclick="playVideo(this.id);">
                    <source src="{{ asset($video->video_path) }}">
                </video>
                <input type="file" name="video" id="video"> --}}
            </div>
            <div class="m-auto py-5">
                <div class="col-12">
                    <button class="btn btn-block btn-primary">
                        Update
                    </button>
                </div>
            </div>

        </div>

    </form>

@endsection
@section('scripts')
<script>
    $('input[name="video_tags"]').amsifySuggestags({ 
        type :'bootstrap'
    });
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
        updateThumbnail(dropZoneElement, inputElement.files[0],inputElement);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
        dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
        inputElement.files = e.dataTransfer.files;
        updateThumbnail(dropZoneElement, e.dataTransfer.files[0],inputElement);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
    });

    /**
     * Updates the thumbnail on a drop zone element.
     *
     * @param {HTMLElement} dropZoneElement
     * @param {File} file
     */
    function updateThumbnail(dropZoneElement, file,inputElement) {

        if(inputElement.name == 'video'){    

            if (!file.type.startsWith("video/")) {
                toastr.error('Invalid File Type!')   
                return;  
            }
            let videoElement = dropZoneElement.querySelector("video");
            // First time - remove the prompt
            if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }
            // First time - there is no thumbnail element, so lets create it
            if (!videoElement) {
                videoElement = document.createElement("video");
                sourceElement = document.createElement("source")
                videoElement.classList.add("drop-video");
                videoElement.appendChild(sourceElement)
                dropZoneElement.appendChild(videoElement);
                videoElement.setAttribute('controls',true)
            }
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                videoElement.src = reader.result;
            };

        }else{

            if (!file.type.startsWith("image/")) { 
                toastr.error('Invalid File Type!')
                return;  
            }
            let imgElement = dropZoneElement.querySelector("img");
            // First time - remove the prompt
            if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }
            // First time - there is no thumbnail element, so lets create it
            if (!imgElement) {
                imgElement = document.createElement("img");
                imgElement.classList.add("drop-img");
                dropZoneElement.appendChild(imgElement);
            }
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                imgElement.src = reader.result;
            };


        }
    }

    document.getElementById('uploadForm').addEventListener('submit',function(e){

        e.preventDefault();
         
        if(document.getElementById('video').value == null || document.getElementById('video').value == ''){
            toastr.error('Please upload a video first.');
            return;
        }

        if(document.getElementById('thumbnail').value == null || document.getElementById('thumbnail').value == ''){
            toastr.error('Please upload a thumbnail first.');
            return;
        }

        this.submit();

    })

</script>
@endsection