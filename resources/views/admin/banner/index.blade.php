@extends('layout.master')
@section('title', 'Banners')
@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="heading">
                <h2>Banners</h2>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('banner_create') }}" class="btn btn-warning mb-2" data-toggle="modal" data-target="#addBannerModel">Add</a>
                </div>
            </div>
            <table id="bannerTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">link</th>
                        <th scope="col">order</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $key=> $banner)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td> <img src="{{ $banner->image }}" width="50" height="50" alt="" srcset=""> </td>
                            <td> <a href="{{$banner->link}}">{{$banner->link}}</a> </td>
                            <td> {{$banner->order}} </td>
                            <td>
                                <div class="d-flex">
                                    <div class="edit-button mr-4">
                                        <a href="{{ route('banners.edit', $banner->id) }}"
                                            class="btn btn-primary">EDIT</a>
                                    </div>
                                    <div class="delete-button mr-4">
                                        <!-- <a href="" class="btn btn-danger">DELETE</a> -->
                                            @csrf
                                            <button type="submit" class="btn btn-danger">DELETE</button>
                                    </div>
                                   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="addBannerModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="post" id="addBannerForm">
        <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input file_input" id="banner_image">
                        <label class="custom-file-label file_label" for="customFile">Choose file</label>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                   <img src="{{ asset('assets/images/placeholder-1920x860.png') }}" class="img-thumbnail preview-img" alt="" srcset="">
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="">Link</label>
                    <input type="url" class="form-control" name="link" placeholder="Enter the link to redirect" id="link">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputState">Order</label>
                    <input type="number" class="form-control" name="order" id="order">
                  </div>
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Banner</button>
        </div>
        </form>

      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="post" id="editBannerForm">
        <input type="hidden" id="edit_id" name="id">
        <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input edit_file_input" id="edit_banner_image">
                        <label class="custom-file-label edit_file_label" for="customFile">Choose file</label>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                   <img src="{{ asset('assets/images/placeholder-1920x860.png') }}" class="img-thumbnail edit-preview-img" alt="" srcset="">
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="">Link</label>
                    <input type="url" class="form-control" name="link" placeholder="Enter the link to redirect" id="edit_link">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputState">Order</label>
                    <input type="number" class="form-control" name="order" id="edit_order">
                  </div>
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Banner</button>
        </div>
        </form>

      </div>
    </div>
  </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var table =  $('#bannerTable').DataTable();

            $(".file_input").change(function(e){
                var file = e.target.files[0];
                const validImageTypes = [ 'image/jpeg', 'image/png'];
                if($.inArray(file.type, validImageTypes) < 0){
                    toastr.error('invalid format')
                    $(this).val(null)
                    return;
                }

                // var image = '';
                var reader = new FileReader();

                reader.onload = (e) => {
                   $('.preview-img').attr('src',e.target.result)
                };
                reader.readAsDataURL(file);

                $('.file_label').text(file.name)

            });

            $(".edit_file_input").change(function(e){
                var file = e.target.files[0];
                const validImageTypes = [ 'image/jpeg', 'image/png'];
                if($.inArray(file.type, validImageTypes) < 0){
                    toastr.error('invalid format')
                    $(this).val(null)
                    return;
                }

                // var image = '';
                var reader = new FileReader();

                reader.onload = (e) => {
                   $('.edit-preview-img').attr('src',e.target.result)
                };
                reader.readAsDataURL(file);

                $('.edit_file_label').text(file.name)

            });

            $('#addBannerForm').submit(function(e){
                e.preventDefault();
                var url = "{{route('banner.add')}}"
                var formData = new FormData();
                formData.append('image' , $('.file_input')[0].files[0])

                formData.append('link' , $('#link').val())
                formData.append('order' , $('#order').val())
                console.log(formData)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
                });
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: "Post",
                    async: true,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        console.log(data);
                        toastr.success('Banner is added succesfully!');
                        $('#addBannerModel').modal('hide')
                        location.reload();     

                    },
                    error: function (xhr, exception) {
                    
                    }
                }); 
            });

            $('#editBannerForm').submit(function(e){
                e.preventDefault();
                var id = $('#edit_id').val()
                var url = "{{url('admin/banner')}}/"+id
                var formData = new FormData();
                formData.append('image' , $('.edit_file_input')[0].files[0])
                formData.append('link' , $('#edit_link').val())
                formData.append('order' , $('#edit_order').val())
                console.log(formData)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
                });
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: "Post",
                    async: true,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        console.log(data);
                        toastr.success('Banner is updated succesfully!');
                        $('#editBannerModal').modal('hide')
                        location.reload();
                        

                    },
                    error: function (xhr, exception) {
                    
                    }
                }); 
            });

        function fetch_data(){
            var url = "{{route('banner.list')}}"
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

                    $('#bannerTable tbody').empty();
                    // return;
                    table.destroy()    

                    data.data.forEach(function(element,i){
                        var row = `<tr>
                            <td>${i+1}</td>
                            <td> <img src="${element.image}" width="150" alt="" srcset=""> </td>
                            <td> <a href="${element.link}">${element.link}</a> </td>
                            <td> ${element.order} </td>
                            <td>
                                <div class="d-flex">
                                    <div class="edit-button mr-4">
                                        <a href="#" data-id="${element.id}" class="btn btn-primary edit_btn">EDIT</a>
                                    </div>
                                    <div class="delete-button mr-4">
                                        <a href="#"  data-id="${element.id}" class="btn btn-danger delete_btn">DELETE</a>   
                                    </div>
                                
                                </div>
                            </td>
                            </tr>`;
                        $('.table tbody').append(row);  
                    })

                    table =  $('#bannerTable').DataTable();
                    delete_row()
                    edit_row()


                },
                error: function (xhr, exception) {
                
                }
            }); 
          
        }
    function delete_row(){
        $('.delete_btn').on('click',function() {
            var id = $(this).data("id");
            var url =  "{{ url('/') }}/admin/banner/"+id
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
            });
            $.ajax({
                url: url,
                dataType: "json",
                type: "delete",
                async: true,
                success: function (data) {
                    console.log(data);
                    toastr.success('Banner is deleted succesfully!');
                    location.reload();
                },
                error: function (xhr, exception) {
                
                }
            }); 
        });
    }

    function edit_row(){
        $('.edit_btn').on('click',function() {
            var id = $(this).data("id");
            var url =  "{{ url('/') }}/admin/banner/"+id
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
                    console.log(data);
                    $('.edit-preview-img').attr('src',data.data.image);
                    $('#edit_link').val(data.data.link);
                    $('#edit_order').val(data.data.order);
                    $('#edit_id').val(data.data.id);

                    $('#editBannerModal').modal()
                },
                error: function (xhr, exception) {
                
                }
            }); 
        });
    }

       

    fetch_data();

    });

       



    </script>
@endsection