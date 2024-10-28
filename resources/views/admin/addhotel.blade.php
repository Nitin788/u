@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Hotel Form</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hotels.index') }}">Hotel List</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hotels.create') }}">Add Hotel Form</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('destinations.create') }}">Add Destination</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert" id="message">
                                <strong>Oops!</strong> There were some problems with your input.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h2>Create New Hotel</h2>
                        <hr />
                        <form action="{{ route('hotels.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Hotel Destination -->
                                <div class="form-group col-md-6">
                                    <label for="destination_id">Destination</label>
                                    <select id="destination_id" name="destination_id" class="form-control" required>
                                        <option value="">Select a destination</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->destination_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Hotel Name -->
                                <div class="form-group col-md-6">
                                    <label for="hotel_name">Hotel Name</label>
                                    <input type="text" class="form-control" id="hotel_name" name="hotel_name" required
                                        placeholder="Enter hotel name">
                                </div>
                            </div>
                            <!-- Hotel Image -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="hotel_image">Hotel Image</label>
                                    <input type="file" class="form-control" id="hotel_image" name="hotel_image"
                                        placeholder="Upload hotel image" required>
                                </div>
                                <!-- Description Selection -->
                                <div class="form-group col-md-6">
                                    <label for="hotel_description">Hotel Description</label>
                                    <textarea class="form-control" id="hotel_description" name="hotel_description"
                                        rows="3" placeholder="Enter hotel description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Automatically close success message after 10 seconds
    setTimeout(function () {
        $('#message').alert('close');
    }, 10000);
</script>
@endsection