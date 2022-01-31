@extends('layout.user-dashboard')
@section('title', 'Lance Master | Home Page')

@section('content')

    <div class="s_box shadow-sm">
        <div class="card-header">
            <h3 class="">Edit Profile</h3>
        </div>
        <div class="card-body row">
            <div class="col-md-8">
                <form action={{ route('user.updateProfile', $user->id) }} method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="name"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('Name') }}</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') == '' ? $user->name : old('name') }}" required
                                autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') == '' ? $user->email : old('email') }}" required
                                autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone_number"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('Phone Number') }}</label>

                        <div class="col-md-8">
                            <input id="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                value="{{ old('phone_number') == '' ? $user->phone_number : old('phone_number') }}"
                                required>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('Password') }}</label>

                        <div class="col-md-8">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            <span class="password-note" role="alert">
                                <strong>Leave the password field empty if you don't want it to update password </strong>
                            </span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="location"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('Location') }}</label>

                        <div class="col-md-8">
                            @if ($user->profile != null)
                                <input id="location" type="location"
                                    class="form-control @error('location') is-invalid @enderror" name="location"
                                    value="{{ old('location') == '' ? ($user->profile->location != null ? $user->profile->location : '') : old('location') }}"
                                    required>

                            @else
                                <input id="location" type="location"
                                    class="form-control @error('location') is-invalid @enderror" name="location"
                                    value="{{ old('location') == '' ? '' : old('location') }}" required>
                            @endif
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="about"
                            class="col-md-3 col-form-label text-md-right text-left ">{{ __('About Yourself') }}</label>

                        <div class="col-md-8">
                            @if ($user->profile != null)
                                <textarea name="about" id="about" class="form-control" rows="3"
                                    required>{{ old('about') == '' ? ($user->profile->about != null ? $user->profile->about : '') : old('about') }}</textarea>
                            @else
                                <textarea name="about" id="about" class="form-control" rows="3"
                                    required>{{ old('about') == '' ? '' : old('about') }}</textarea>
                            @endif
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row my-4">
                        <label for="profileImage"
                            class="col-md-3 col-form-label text-md-right text-left ">{{ __('Profile Image') }}</label>

                        <div class="col-md-8">
                            <div class="drop-zone drop-profile">
                                @if ($user->profile != null && $user->profile->profile_image != null)
                                    <input type="file" name="profileImage" id="profileImage" class="drop-zone__input">
                                    <img src="{{ asset($user->profile->profile_image) }}" 
                                    class="drop-img" alt="User profile picture">
                                @else
                                    <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Profile Pic </b></span>
                                    <input type="file" name="profileImage" id="profileImage" class="drop-zone__input">
                                @endif            
                            </div>
                            {{-- <input type="file" name="profileImage" id="profileImage" /> --}}
                            @error('profileImage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="cover"
                            class="col-md-3 col-form-label text-md-right text-left">{{ __('Cover Image') }}</label>

                        <div class="col-md-8">
                            <div class="drop-zone drop-cover">
                                @if ($user->profile != null && $user->profile->cover_image != null)
                                <input type="file" name="cover" id="cover" class="drop-zone__input">
                                <img src="{{ asset($user->profile->cover_image) }}" 
                                class="drop-img" alt="Cover picture">
                                @else
                                <span class="drop-zone__prompt">Drop file here or click to upload <br><b> Cover Photo </b></span>
                                <input type="file" name="cover" id="cover" class="drop-zone__input">
                                @endif
                                {{-- <img src="{{ $video->thumbnail }}" 
                                class="drop-img" alt="..."> --}}
                            </div>
                            {{-- <input type="file" name="cover" id="cover" /> --}}
                            @error('cover')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary d-block m-auto">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
 
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

  

</script>
@endsection
