@extends('layout.master')
@section('title', 'Video Detail')
@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="heading">
                <h2>Video Detail</h2>
                <div class="d-flex justify-content-end">
        
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Views</h5>
                                <h2 class="mb-0">{{$videoContent->totalViews()}}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                <i class="fa fa-eye fa-fw fa-sm text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Likes</h5>
                                <h2 class="mb-0">{{$videoContent->totalLikes()}}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg   bg-primary-light mt-1">
                                <i class=" fas fa-thumbs-up fa-fw fa-sm text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="row">
               <div class="col-md-8">
                    <div class="card p-4">
                        <video controls="" width="100%" class="preview-vid mb-4" id="video">
                            <source src="{{ asset($videoContent->video_path) }}" type="video/mp4">
                        </video>
                        <h2>{{$videoContent->title}}</h2>
                        <p class="lead">{{$videoContent->description}}</p>
                        <div class="row">
                            <div class="col-6">
                                <p>
                                    <b>Category:</b> {{$videoContent->category->name}}
                                </p>
                            </div>
                            <div class="col-6">
                                <p>
                                    <b>Tags:</b> {{$videoContent->tags}}
                                     {{-- @foreach ($videoContent->video_tags as $key => $item)
                                        {{$item->name}} 
                                        @if ($videoContent->video_tags()->count() != ($key + 1))
                                            ,
                                        @endif 
                                    @endforeach  --}}
                                </p>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="col-md-4">
                   <div class="card">
                       <div class="card-header">
                           <h2>User Detail</h2>
                       </div>
                       <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Name: {{$videoContent->user->name}}</li>
                                <li class="list-group-item">Email: {{$videoContent->user->email}}</li>
                            </ul>
                        </div>
                   </div>
               </div>
        `  </div>
        </div>
    </div>
    <!-- Modal -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
        var table =  $('#videoTable').DataTable();

        // function fetch_data(){
        //     var url = "{{route('video.list')}}"
        //     $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': "{{csrf_token()}}"
        //             }
        //     });
        //     $.ajax({
        //         url: url,
        //         dataType: "json",
        //         type: "get",
        //         async: true,
        //         success: function (data) {

        //             $('#videoTable tbody').empty();
        //             // return;
        //             table.destroy()    

        //             data.data.forEach(function(element,i){
        //                 var row = `<tr>
        //                     <td>${i+1}</td>
        //                     <td><div class="video-thumbnail"> <img src="${element.thumbnail}" width="150" alt="" srcset=""> </div></td>
        //                     <td> ${element.category.name} </td>
        //                     <td> ${element.title} </td>
        //                     <td> ${element.totalViews} </td>
        //                     <td>
        //                         <div class="d-flex">
        //                             <div class="edit-button mr-4">
        //                                 <a href="#" class="btn btn-primary">VIEW MORE</a>
        //                             </div>
        //                         </div>
        //                     </td>
        //                     </tr>`;
        //                 $('#videoTable tbody').append(row);  
        //             })

        //             table =  $('#videoTable').DataTable();
        //             // delete_row()
        //             // edit_row()


        //         },
        //         error: function (xhr, exception) {
                
        //         }
        //     }); 
          
        // }
    // function delete_row(){
    //     $('.delete_btn').on('click',function() {
    //         var id = $(this).data("id");
    //         var url =  "{{ url('/') }}/admin/banner/"+id
    //         $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': "{{csrf_token()}}"
    //                 }
    //         });
    //         $.ajax({
    //             url: url,
    //             dataType: "json",
    //             type: "delete",
    //             async: true,
    //             success: function (data) {
    //                 console.log(data);
    //                 toastr.success('Banner is deleted succesfully!');
    //                 location.reload();
    //             },
    //             error: function (xhr, exception) {
                
    //             }
    //         }); 
    //     });
    // }

    // function edit_row(){
    //     $('.edit_btn').on('click',function() {
    //         var id = $(this).data("id");
    //         var url =  "{{ url('/') }}/admin/banner/"+id
    //         $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': "{{csrf_token()}}"
    //                 }
    //         });
    //         $.ajax({
    //             url: url,
    //             dataType: "json",
    //             type: "get",
    //             async: true,
    //             success: function (data) {
    //                 console.log(data);
    //                 $('.edit-preview-img').attr('src',data.data.image);
    //                 $('#edit_link').val(data.data.link);
    //                 $('#edit_order').val(data.data.order);
    //                 $('#edit_id').val(data.data.id);

    //                 $('#editBannerModal').modal()
    //             },
    //             error: function (xhr, exception) {
                
    //             }
    //         }); 
    //     });
    // }

    // fetch_data();

    });

       



    </script>
@endsection