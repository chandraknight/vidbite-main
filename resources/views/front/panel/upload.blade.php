@extends('layout.studio-dashboard')
@section('title', 'Lance Master | Home Page')

@section('content')


    <section class="streamManager">
        <div class="heading">
            <h2>
                Upload Video
            </h2>
        </div>
        <div class="form">
            <form action="{{ route('user.storeVideo') }}" id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                    <div class="">
                        <label for="videoTitle">Video title</label>
                        <input type="text" name="video_title" id="videoTitle" class="form-control" placeholder="Video Title"
                            required>
                    </div>
                    <div class="mt-4">
                        <label for="description">Video Description</label>
                        <textarea name="video_description" id="description" class="form-control w-100" rows="10"></textarea>
                    </div>
                    </div>
                    <div class="col-6">
                        <div class=" mt-4">
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Video Content </b></span>
                                <input type="file" name="video" id="video" class="drop-zone__input">
                            </div>
                            {{-- <input type="file" name="video" required> --}}
                        </div>
                    </div>
                    
                    <div class="w-49 mt-4">
                        <label for="videoCategory">Video Category</label>
                        <br>
                        <select name="video_category" id="videoCategory" class="w-100 " required>
                            <option value="" selected disabled>Please Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-49 mt-4">
                        <label for="videoPlaylist">Video Playlist</label>
                        <div class="w-100" id="playlistCheck">
                            <input type="radio" name="playList" value="yes" id="playListYes"
                                onchange="showPlaylistSelect(this.value)"> Yes :
                            <input type="radio" name="playList" value="No" id="playListNo"
                                onchange="showPlaylistSelect(this.value)"> No :
                        </div>
                        <div class="w-100 d-none" id="playlistSelect">
                            <br>
                            <select name="video_playlist" id="videoPlaylist" class="w-100 ">
                                <option value="0" selected disabled>Please Select Playlist</option>
                                @foreach ($playlists as $playlist)
                                    <option value="{{ $playlist->id }}">{{ $playlist->playlist_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-100 mt-4">
                        <label for="topic">Topic</label>
                        <input type="text" name="topic" id="topic" class="form-control" placeholder="Topic">
                    </div>
                    <div class="w-49 mt-4">
                        <label for="tags">Video Tags <sub class="red">Please separate tags with ,</sub></label>
                        <input type="text" name="video_tags" id="tags" class="form-control" data-role="tagsinput" placeholder="Video Tags">
                    </div>

                    <div class="w-49 mt-4">
                        <label for="tags">Thumbnail</label>
                        <div class="drop-zone drop-thumbnail">
                            <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Video Thumbnail </b></span>
                            <input type="file" name="thumbnail" id="thumbnail" class="drop-zone__input">
                        </div>
                        {{-- <input type="file" name="thumbnail" class="d-block" required> --}}
                    </div>

                    <div class="w-49 mt-4">
                        <button type="submit" class="btn btn-primary">Upload Video</button>
                    </div>

                </div>
            </form>
        </div>
    </section>


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
        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
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