@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Hotel List</h3>
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
                    <a href="{{ route('hotels.create') }}">Add New Hotel</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hotels.index') }}">Hotel List</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hotel List</h4>
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success" id="message" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="dataTables_length" id="basic-datatables_length">
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div id="basic-datatables_filter" class="dataTables_filter">
                                                <label>Search:
                                                    <input type="search" class="form-control form-control-sm"
                                                        placeholder="" aria-controls="basic-datatables">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Country</th> <!-- First column for country -->
                                        <th>Destination</th> <!-- Second column for destination -->
                                        <th>Hotel Name</th> <!-- Third column for hotel name -->
                                        <th>Image</th> <!-- Fourth column for image -->
                                        <th>Actions</th> <!-- Fifth column for actions -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotels as $hotel)
                                        <tr>
                                            <td>
                                                {{ $hotel->destination->country ? $hotel->destination->country->country_name : 'No country' }}
                                            </td>
                                            <!-- Displaying country name -->
                                            <td>{{ $hotel->destination->destination_name }}</td>
                                            <!-- Displaying destination name -->
                                            <td>{{ $hotel->hotel_name }}</td> <!-- Displaying hotel name -->
                                            <td>
                                                @if($hotel->hotel_image)
                                                    <img src="{{ asset($hotel->hotel_image) }}" alt="{{ $hotel->hotel_name }}"
                                                        width="100" height="50">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-warning">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this hotel?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mt-2">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-between">
                                <div id="pagination-info">
                                    Showing {{ $hotels->firstItem() }} to {{ $hotels->lastItem() }} of
                                    {{ $hotels->total() }} entries
                                </div>
                                {{ $hotels->links() }} <!-- Pagination links -->
                            </div>
                        </div>
                    </div>
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