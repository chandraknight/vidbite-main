@extends('layout.master')
@section('title', 'User Management')
@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="heading">
                <h2>Edit Banner</h2>
            </div>

            <form method="POST" action="{{ route('banner.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="image">Select Banner Image</label>
                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" placeholder="Enter image" >
                </div>
                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" value="{{ $banner->link }}" required name="link" id="link" aria-describedby="link"
                        placeholder="Enter Link">
                </div>
                <div class="form-group">
                    <label for="order">order</label>
                    <input type="text" class="form-control" value="{{ $banner->order }}" required name="order" id="order" aria-describedby="order"
                        placeholder="Enter Link">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
