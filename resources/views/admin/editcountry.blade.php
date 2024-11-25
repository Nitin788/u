@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Country</h3>
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
                    <a href="{{ route('countries.index') }}">Country List</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('countries.edit', $countries->id) }}">Edit Country</a>
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
                        <h2>Edit Country</h2>
                        <hr />

                        <!-- Edit Country Form -->
                        <form action="{{ route('countries.update', $countries->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- We need to specify that this is an update request -->

                            <div class="row">
                                <!-- Country Name -->
                                <div class="form-group col-md-6">
                                    <label for="name">Country Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $countries->country_name) }}" required>
                                </div>

                                <!-- Country Image -->
                                <div class="form-group col-md-6">
                                    <label for="country_image">Country Image</label>
                                    <input type="file" class="form-control" id="country_image" name="country_image">
                                    @if($countries->country_image)
                                        <img class="mt-3" src="{{ asset('' . $countries->country_image) }}"
                                            alt="{{ $countries->country_name }}" width="100" height="50">
                                    @else
                                        No Image
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Country</button>
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