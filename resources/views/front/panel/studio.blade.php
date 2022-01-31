@extends('layout.studio-dashboard')
@section('title', 'Lance Master | Home Page')
@section('content')
    <section class="streamManager">
        <div class="heading">
            <h2>
                Videos
            </h2>
        </div>

        <table id="videoTable" class="table table-striped text-light">
            <thead>
                <tr>
                    <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                    <th scope="col">#</th>
                    <th scope="col" style="width: 40%">Video</th>
                    <th scope="col">Category</th>
                    <th scope="col">Views</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->videos as $key => $video)
                <tr>
                    <th></th>
                     <th>
                        {{$key + 1}}
                     </th>
                     <th>   
                        <div class="d-flex align-items-center ">
                            <div class="video-thumbnail"> 
                                <img src="{{$video->thumbnail}}" width="150" height="150" alt="" srcset=""> 
                            </div>
                            <div>
                                <p class="align-self-center px-2"><strong>{{ $video->title }}</strong></p>
                                <p class="lead align-self-center px-2 vid-desc">{{ $video->description}}</p>
                            </div>
                        </div>
                     </th>
                     <th class="">   
                        <div class=" align-self-center d-flex align-items-center ">
                            {{ $video->category->name }}
                        </div>
                     </th>
                     <th>
                        <div class=" d-flex align-items-center align-self-center">
                            @if (sizeof($video->views) > 0)
                                {{ $video->views->count() }} Views
                            @else
                                0 Views
                            @endif
                        </div>
                     </th>
                     <th>
                         {{$video->created_at->format('d/m/Y H:i')}}
                     </th>
                     <th>
                        <div class="d-flex align-items-center justify-content-around align-self-center">
                            <a href="{{ route('user.editVideo', $video->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fa fa-edit"></i></a>
                            <a href="{{ route('user.deleteVideo', $video->id) }}" class="btn btn-sm btn-danger"><i
                                    class="fa fa-trash"></i></a>
                        </div>
                     </th>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- <div class="row">
            <div class="list-group w-100">
                <div class="list-group-item list-group-item-action active d-flex justify-content-around">
                    <div class="video-group-title text-center">
                        Video
                    </div>
                    <div class="video-group-title text-center">
                        Category
                    </div>
                    <div class="video-group-title text-center">
                        Views
                    </div>
                    <div class="video-group-title text-center">
                        Action
                    </div>
                </div>
                @foreach ($user->videos as $video)

                    <div class="list-group-item list-group-item-action d-flex">
                        <div class="video-group d-flex align-items-center">
                            <video width='30%' id="recommendedVideoPlayer{{ $video->id }}" onclick="playVideo(this.id);">
                                <source src="{{ asset($video->video_path) }}">
                            </video>
                            <div>
                            <p class="align-self-center px-2"><strong>{{ $video->title }}</strong></p>
                            <p class="lead align-self-center px-2">{{ $video->description}}</p>
                            </div>
                        </div>
                        <div class="category align-self-center">
                            {{ $video->category->name }}
                        </div>
                        <div class="table-views align-self-center">
                            @if (sizeof($video->views) > 0)
                                {{ $video->views->count() }} Views
                            @else
                                0 Views
                            @endif
                        </div>
                        <div class="action align-self-center">
                            <a href="{{ route('user.editVideo', $video->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fa fa-edit"></i></a>
                            <a href="{{ route('user.deleteVideo', $video->id) }}" class="btn btn-sm btn-danger"><i
                                    class="fa fa-trash"></i></a>
                        </div>
                    </div>

                @endforeach
            </div>
        </div> --}}

        {{-- <div class="playList">

            @foreach ($user->videos as $video)
                <div>
                    <div class="boxImg">
                        <video controls width='100%' id="recommendedVideoPlayer{{ $video->id }}"
                            onclick="playVideo(this.id);">
                            <source src="{{ asset($video->video_path) }}">
                        </video>
                        <div class="px-3">
                            <div class="title">
                                <div>
                                    {{ $video->title }}
                                    <p class="float-right">
                                        @if (isset($video->view))
                                            @if (sizeof($video->view) > 0)
                                                {{ $video->views->total_views }} Views
                                            @endif
                                        @else
                                            0 Views
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="details">
                                <div class="profile-pic">
                                    <img src="{{ asset('assets/front/images/dummy.jpg') }}" alt="">
                                </div>
                                <div class="video-details">
                                    <div class="channel">
                                        <a href="" class="color-white">
                                            <span class="text-capitalize">{{ $video->user->name }}</span> Channel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </section>
@endsection
@section('scripts')
<script>
    $( document ).ready(function() {
      var table = $('#videoTable').DataTable({
            "columnDefs": [
                {
                    'targets': 0,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta){
                        return '<input type="checkbox" name="id[]" value="' 
                            + $('<div/>').text(data).html() + '">';
                    }
                }
            ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            'order': [1, 'asc']

        });

           // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#videoTable tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control 
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });
    
   $('#frm-example').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element 
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         } 
      });

      // FOR TESTING ONLY
      
      // Output form data to a console
      $('#example-console').text($(form).serialize()); 
        console.log("Form submission", $(form).serialize()); 
        
        // Prevent actual form submission
        e.preventDefault();
      });
    });
</script>
@endsection
