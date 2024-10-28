@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Country List</h3>
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
                    <a href="{{ route('countries.create') }}">Add New Country</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('countries.index') }}">Country List</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Country List</h4>
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success" id="message" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Country Name</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $country->country_name }}</td>
                                            <td>
                                                @if($country->country_image)
                                                    <img src="{{ asset('' . $country->country_image) }}"
                                                        alt="{{ $country->country_name }}" width="100" height="50">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('countries.edit', $country->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('countries.destroy', $country->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this country?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-between">
                                <div id="pagination-info">
                                    Showing {{ $countries->firstItem() }} to {{ $countries->lastItem() }} of
                                    {{ $countries->total() }} entries
                                </div>
                                {{ $countries->links() }} <!-- Pagination links -->
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