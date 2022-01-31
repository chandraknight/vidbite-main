@extends('layout.master')
@section('title', 'Videos')
@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="heading">
                <h2>Videos</h2>
                <div class="d-flex justify-content-end">
                    {{-- <a href="#" class="btn btn-warning mb-2" data-toggle="modal" data-target="#addBannerModel">Add</a> --}}
                </div>
            </div>
            <table id="videoTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">video</th>
                        <th scope="col">category</th>
                        <th scope="col">title</th>
                        <th scope="col">Views</th>
                        <th scope="col">Date</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key => $video)
                        <tr>
                            <th>{{$key + 1}}</th>
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
                             <th>   
                                {{ $video->description}}
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
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
        var table =  $('#videoTable').DataTable();

        function fetch_data(){
            var url = "{{route('video.list')}}"
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
            });
            $.ajax({
                url: url,
                dataType: "json",
                type: "get",
                async: true,
                success: function (data) {

                    $('#videoTable tbody').empty();
                    // return;
                    table.destroy()    

                    data.data.forEach(function(element,i){
                        var row = `<tr>
                            <td>${i+1}</td>
                            <td><div class="video-thumbnail"> <img src="${element.thumbnail}" width="150" alt="" srcset=""> </div></td>
                            <td> ${element.category.name} </td>
                            <td> ${element.title} </td>
                            <td> ${element.totalViews} </td>
                            <td> ${element.date} </td>
                            <td>
                                <div class="d-flex">
                                    <div class="edit-button mr-4">
                                        <a href="/admin/video/${element.id}" class="btn btn-primary">VIEW MORE</a>
                                    </div>
                                </div>
                            </td>
                            </tr>`;
                        $('#videoTable tbody').append(row);  
                    })

                    table =  $('#videoTable').DataTable();
                    // delete_row()
                    // edit_row()


                },
                error: function (xhr, exception) {
                
                }
            }); 
          
        }
    // function delete_row(){
    //     $('.delete_btn').on('click',function() {
        //     var id = $(this).data("id");
        //     var url =  "{{ url('/') }}/admin/banner/"+id
        //     $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': "{{csrf_token()}}"
        //             }
        //     });
        //     $.ajax({
        //         url: url,
        //         dataType: "json",
        //         type: "delete",
        //         async: true,
        //         success: function (data) {
        //             console.log(data);
        //             toastr.success('Banner is deleted succesfully!');
        //             location.reload();
        //         },
        //         error: function (xhr, exception) {
                
        //         }
        //     }); 
        // });
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

    fetch_data();

    });

       



    </script>
@endsection