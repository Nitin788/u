@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Destination Form</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <!-- <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('destinations.index') }}">Destination List</a>
                </li> -->
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                    
                </li>
                <li class="nav-item">
                    <a href="{{ route('destinations.create') }}">Add Destination Form</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('countries.create') }}">Add Country </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hotels.create') }}">Add Hotel </a>
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
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success" id="message" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h2>Create New Destination</h2>
                        <hr />
                        <form action="{{ route('destinations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Country Selection -->
                                <div class="form-group col-md-6">
                                    <label for="country_id">Country</label>
                                    <select id="country_id" name="country_id" class="form-control" required>
                                        <option value="">Select a country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Destination Name -->
                                <div class="form-group col-md-6">
                                    <label for="destination_name">Destination Name</label>
                                    <input type="text" class="form-control" id="destination_name"
                                        name="destination_name" required placeholder="Enter destination name">
                                </div>
                                <!-- Destination Image -->
                                <div class="form-group col-md-6">
                                    <label for="destination_image">Destination Image</label>
                                    <input type="file" class="form-control" id="destination_image"
                                        name="destination_image" placeholder="Upload destination image" required>
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