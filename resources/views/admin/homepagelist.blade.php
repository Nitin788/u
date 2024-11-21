@extends('admin.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Homepage Table</h3>
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
                    <a href="{{ route('homepages.create') }}">Add New Homepage</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('homepages.index') }}">Homepage List</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Homepage List</h4>
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
                                <!-- Filters Card -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="dataTables_length" id="basic-datatables_length">
                                                    <label>Show
                                                        <select name="basic-datatables_length"
                                                            aria-controls="basic-datatables"
                                                            class="form-control form-control-sm" id="pagination-select">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                        entries
                                                    </label>
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

                                <!-- Main Data Cards -->
                                <div class="row">
                                    @foreach($homepages as $homepage)
                                                                        <div class="col-md-12 mb-3">
                                                                            <!-- Header Menu Section -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h3>Header Menu</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    @php
                                                                                        $headerMenu = json_decode($homepage->header_menu, true);
                                                                                    @endphp

                                                                                    @if (is_array($headerMenu) && count($headerMenu) > 0)
                                                                                        <ul class="list-group">
                                                                                            @foreach($headerMenu as $menu)
                                                                                                <li class="list-group-item">
                                                                                                    <a href="{{ $menu['link'] }}"
                                                                                                        target="_blank">{{ $menu['title'] }}</a>
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @else
                                                                                        <p>No Header Menu Items</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <!-- Slider Images Card -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h6>Slider Images for Homepage ID: {{ $homepage->id }}</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="slider-images mb-2">
                                                                                        @if($homepage->slider_images)
                                                                                            @foreach(json_decode($homepage->slider_images) as $image)
                                                                                                <img src="{{ asset('slider_images/' . $image) }}" alt="Slider Image"
                                                                                                    width="100" height="70" class="m-1">
                                                                                            @endforeach
                                                                                        @else
                                                                                            <p>No Images</p>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Card Images and Titles -->
                                                                            @php
                                                                                $cardImages = json_decode($homepage->card_images_title, true);
                                                                            @endphp

                                                                            @if (is_array($cardImages) && count($cardImages) > 0)
                                                                                <div class="card-header">
                                                                                    <h6>Card Images And Card Titles:</h6>
                                                                                </div>
                                                                                <div class="row">
                                                                                    @foreach($cardImages as $card)
                                                                                        <div class="card mb-3 col-md-6">
                                                                                            <div class="card-body d-flex align-items-center">
                                                                                                <img src="{{ asset('card_images_title/' . $card['image']) }}"
                                                                                                    alt="Card Image" width="100" height="70" class="m-1">
                                                                                                <div class="ms-3">
                                                                                                    <h6>Card Title: {{ $card['title'] }}</h6>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @else
                                                                                <!-- <p>No Card Images</p> -->
                                                                            @endif

                                                                            <!-- Book Offers Details -->
                                                                            @php
                                                                                $bookOffers = json_decode($homepage->book_offers, true);
                                                                            @endphp

                                                                            @if (is_array($bookOffers) && count($bookOffers) > 0)
                                                                                <div class="card mb-3">
                                                                                    <div class="card-header">
                                                                                        <h3>Book Offers</h3>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        @foreach($bookOffers as $offer)
                                                                                            <div class="offer-item mb-1">
                                                                                                <div class="row">
                                                                                                    <hr>
                                                                                                    <div class="col-md-6">
                                                                                                        <img src="{{ asset('offer_images/' . $offer['image']) }}"
                                                                                                            alt="Offer Image" width="100" height="70" class="m-1">
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <h6><strong>Offer Title:</strong> {{ $offer['title'] }}</h6>
                                                                                                        <p><strong>Offers:</strong> {{ $offer['offers'] }}</p>
                                                                                                        <p><strong>Inclusions:</strong> {{ $offer['inclusions'] }}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <hr>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <p>No Book Offers Available</p>
                                                                            @endif
                                                                            <!-- Footer Images Section -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h3>Footer Images</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="footer-images">
                                                                                        @if ($homepage->footer_images)
                                                                                                                                        @php
                                                                                                                                            $footerImages = json_decode($homepage->footer_images);
                                                                                                                                        @endphp
                                                                                                                                        <div class="row">
                                                                                                                                            @foreach ($footerImages as $image)
                                                                                                                                                <div class="col-md-3">
                                                                                                                                                    <div class="mb-3">
                                                                                                                                                        <img src="{{ asset('footer_images/' . $image) }}"
                                                                                                                                                            alt="Footer Image" width="100" height="70" >
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            @endforeach
                                                                                                                                        </div>
                                                                                        @else
                                                                                            <p>No Footer Images Available</p>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Footer Menu Section -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h3>Footer Menu</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    @php
                                                                                        $footerMenu = json_decode($homepage->footer_menu, true);
                                                                                    @endphp
                                                                                    @if (is_array($footerMenu) && count($footerMenu) > 0)
                                                                                        <ul class="list-group">
                                                                                            @foreach($footerMenu as $menu)
                                                                                                <li class="list-group-item">
                                                                                                    <a href="{{ $menu['link'] }}"
                                                                                                        target="_blank">{{ $menu['title'] }}</a>
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @else
                                                                                        <p>No Footer Menu Items</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <a href="{{ route('homepages.edit', $homepage->id) }}"
                                                                                    class="btn btn-warning btn-sm m-3">Edit</a>
                                                                                <form action="{{ route('homepages.destroy', $homepage->id) }}" method="POST"
                                                                                    style="display:inline-block;"
                                                                                    onsubmit="return confirm('Are you sure you want to delete this homepage data?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-danger btn-sm m-3">Delete</button>
                                                                                </form>
                                                                            </div>

                                                                            <!-- Status Card -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h6>Status</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <p>{{ $homepage->status == 1 ? 'Active' : 'Inactive' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination Info -->
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="basic-datatables_info" role="status"
                                            aria-live="polite">
                                            Showing {{ $homepages->firstItem() }} to {{ $homepages->lastItem() }} of
                                            {{ $homepages->total() }} entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7 text-md-right">
                                        <div class="pagination">
                                            {{ $homepages->onEachSide(3)->links() }}
                                        </div>
                                    </div>
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
    // Automatically close success message after 8 seconds
    setTimeout(function () {
        $('#message').alert('close');
    }, 10000);
    // Automatically pagination-info
    $(document).ready(function () {
        $('#pagination-select').on('change', function () {
            var selectedValue = $(this).val();
            var totalEntries = {{ $homepages->total() }};
            var currentPage = {{ $homepages->currentPage() }};
            var lastPage = {{ $homepages->lastPage() }};
            var firstItem = {{ $homepages->firstItem() }};
            var lastItem = {{ $homepages->lastItem() }};
            var paginationInfo = 'Showing ' + firstItem + ' to ' + lastItem + ' of ' + totalEntries + ' entries (Page ' + currentPage + ' of ' + lastPage + ')';
            $('#pagination-info').text(paginationInfo);
        });
    });
</script>
@endsection