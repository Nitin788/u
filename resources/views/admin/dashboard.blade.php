@extends('admin.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <!-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a> -->
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Visitors</p>
                                    <h4 class="card-title">1,294</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Subscribers</p>
                                    <h4 class="card-title">1303</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-luggage-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sales</p>
                                    <h4 class="card-title">$ 1,345</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Order</p>
                                    <h4 class="card-title">576</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
                                </div>
                                <!-- Main Data Cards -->
                                <div class="row">
                                    @foreach($homepages as $homepage)
                                                                        <div class="col-md-12 mb-3">
                                                                            <!-- Slider Images Card -->
                                                                            <div class="card mb-3">
                                                                                <div class="card-header">
                                                                                    <h5>Slider Images for Homepage ID: {{ $homepage->id }}</h5>
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
                                                                                    <h5>Card Images And card Title:</h5>
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
                                                                                <p>No Card Images</p>
                                                                            @endif

                                                                            <!-- Book Offers Details -->
                                                                            @php
                                                                                $bookOffers = json_decode($homepage->book_offers, true);
                                                                            @endphp

                                                                            @if (is_array($bookOffers) && count($bookOffers) > 0)
                                                                                <div class="card mb-3">
                                                                                    <div class="card-header">
                                                                                        <h5>Book Offers</h5>
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
@endsection