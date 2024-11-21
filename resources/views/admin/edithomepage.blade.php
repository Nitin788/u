@extends('admin.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Homepage</h3>
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
                    <a href="{{ route('homepages.index') }}">Homepage List</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit Homepage</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
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
                        <form action="{{ route('homepages.update', $homepages->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Header Menu Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Header Menu</h3>
                                </div>
                                <div class="card-body">
                                    <div id="headerMenuContainer">
                                        @php $headerMenu = json_decode($homepages->header_menu, true); @endphp
                                        @if (is_array($headerMenu) && count($headerMenu) > 0)
                                            @foreach($headerMenu as $index => $menu)
                                                <div class="row mt-3" id="headerMenuRow{{ $index + 1 }}">
                                                    <div class="form-group col-md-6">
                                                        <label for="header_menu_title_{{ $index + 1 }}">Menu Title</label>
                                                        <input type="text" name="header_menu_title[]" class="form-control"
                                                            id="header_menu_title_{{ $index + 1 }}"
                                                            placeholder="Enter menu title" value="{{ $menu['title'] }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="header_menu_link_{{ $index + 1 }}">Menu Link</label>
                                                        <input type="text" name="header_menu_link[]" class="form-control"
                                                            id="header_menu_link_{{ $index + 1 }}" placeholder="Enter menu link"
                                                            value="{{ $menu['link'] }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No header menu items.</p>
                                        @endif
                                    </div>
                                    <input type="button" class="btn btn-success float-right" id="addHeaderMenu"
                                        value="+">
                                    <input type="button" class="btn btn-danger float-right mr-2" id="removeHeaderMenu"
                                        value="-">
                                </div>
                            </div>
                            <!-- Slider Images Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Slider Images</h3>
                                </div>
                                <div class="card-body">
                                    <label for="slider_images">Slider Images (multiple)</label>
                                    <input type="file" name="slider_images[]" class="form-control-file"
                                        id="slider_images" multiple>
                                    <strong class="form-text text-muted">You can upload multiple images. Current
                                        images:</strong>
                                    <div class="mt-2">
                                        @if ($homepages->slider_images)
                                            @php    $existingSliderImages = json_decode($homepages->slider_images); @endphp
                                            @foreach ($existingSliderImages as $image)
                                                <div>
                                                    <img class="m-1" src="{{ asset('slider_images/' . $image) }}"
                                                        alt="Slider Image" width="100" height="70">
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No current slider images.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Card Images and Titles Card -->
                            <!-- <div class="card mb-3">
                                <div class="card-header">
                                    Card Images and Titles
                                </div>
                                <div class="card-body" id="cardContainer">
                                    @php $cardImages = json_decode($homepages->card_images_title); @endphp
                                    @if (is_array($cardImages) || is_object($cardImages))
                                        @foreach ($cardImages as $index => $card)
                                            <div class="row mt-3" id="cardRow{{ $index + 1 }}">
                                                <div class="form-group col-md-6">
                                                    <label for="card_images_title_{{ $index + 1 }}">Card Image</label>
                                                    <input type="file" name="card_images_title[]" class="form-control-file"
                                                        id="card_images_title_{{ $index + 1 }}">
                                                    <strong class="form-text text-muted">Current image:
                                                        <img src="{{ asset('card_images_title/' . $card->image) }}"
                                                            alt="Card Image" width="50" height="40">
                                                    </strong>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="card_title_{{ $index + 1 }}">Card Title</label>
                                                    <input type="text" name="card_title[]" class="form-control"
                                                        id="card_title_{{ $index + 1 }}" placeholder="Enter card title"
                                                        value="{{ $card->title }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No card images found.</p>
                                    @endif
                                    <input type="button" class="btn btn-success float-right" id="addCard" value="+">
                                    <input type="button" class="btn btn-danger float-right mr-2" id="cancelCard"
                                        value="-">
                                </div>
                            </div> -->

                            <!-- Book Offers Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Book Offers</h3>
                                </div>
                                <div class="card-body">
                                    <div id="offerContainer">
                                        @php $bookOffers = json_decode($homepages->book_offers, true); @endphp
                                        @if (is_array($bookOffers) && count($bookOffers) > 0)
                                            @foreach($bookOffers as $index => $offer)
                                                <div class="row offer-group mb-3">
                                                    <hr>
                                                    <div class="form-group col-md-6">
                                                        <label for="offer_image_{{ $index }}">Offer Image</label>
                                                        <input type="file" name="offer_image[]" class="form-control-file"
                                                            id="offer_image_{{ $index }}">
                                                        <strong class="form-text text-muted">Current image:
                                                            <img src="{{ asset('offer_images/' . $offer['image']) }}"
                                                                alt="Offer Image" width="50" height="40">
                                                        </strong>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="offer_title_{{ $index }}">Offer Title</label>
                                                        <input type="text" name="offer_title[]" class="form-control"
                                                            id="offer_title_{{ $index }}" placeholder="Enter offer title"
                                                            value="{{ $offer['title'] }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="offers_{{ $index }}">Offers</label>
                                                        <input type="text" name="offers[]" class="form-control"
                                                            id="offers_{{ $index }}" placeholder="Enter offers details"
                                                            value="{{ $offer['offers'] }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inclusions_{{ $index }}">Inclusions</label>
                                                        <input type="text" name="inclusions[]" class="form-control"
                                                            id="inclusions_{{ $index }}" placeholder="Enter inclusions details"
                                                            value="{{ $offer['inclusions'] }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No book offers available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Footer Images Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Footer Images</h3>
                                </div>
                                <div class="card-body">
                                    <label for="footer_images">Footer Images (multiple)</label>
                                    <input type="file" name="footer_images[]" class="form-control-file"
                                        id="footer_images" multiple>
                                    <strong class="form-text text-muted">You can upload multiple images. Current
                                        images:</strong>
                                    <div class="mt-2">
                                        @if ($homepages->footer_images)
                                            @php    $existingFooterImages = json_decode($homepages->footer_images); @endphp
                                            @foreach ($existingFooterImages as $image)
                                                <div>
                                                    <img class="m-1" src="{{ asset('footer_images/' . $image) }}"
                                                        alt="Footer Image" width="100" height="70">
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No current footer images.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Footer Menu Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Footer Menu</h3>
                                </div>
                                <div class="card-body">
                                    <div id="footerMenuContainer">
                                        @php $footerMenu = json_decode($homepages->footer_menu, true); @endphp
                                        @if (is_array($footerMenu) && count($footerMenu) > 0)
                                            @foreach($footerMenu as $index => $menu)
                                                <div class="row mt-3" id="footerMenuRow{{ $index + 1 }}">
                                                    <div class="form-group col-md-6">
                                                        <label for="footer_menu_title_{{ $index + 1 }}">Menu Title</label>
                                                        <input type="text" name="footer_menu_title[]" class="form-control"
                                                            id="footer_menu_title_{{ $index + 1 }}"
                                                            placeholder="Enter menu title" value="{{ $menu['title'] }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="footer_menu_link_{{ $index + 1 }}">Menu Link</label>
                                                        <input type="text" name="footer_menu_link[]" class="form-control"
                                                            id="footer_menu_link_{{ $index + 1 }}" placeholder="Enter menu link"
                                                            value="{{ $menu['link'] }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No footer menu items.</p>
                                        @endif
                                    </div>
                                    <input type="button" class="btn btn-success float-right" id="addFooterMenu"
                                        value="+">
                                    <input type="button" class="btn btn-danger float-right mr-2" id="removeFooterMenu"
                                        value="-">
                                </div>
                            </div>
                            <!-- Status Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mt-3">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control" id="status" required>
                                            <option value="1" {{ $homepages->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $homepages->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-3">Update</button>
                        </form>

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
    // Add more header menu
    document.getElementById('addHeaderMenu').addEventListener('click', function () {
        const container = document.getElementById('headerMenuContainer');
        const newHeaderMenu = document.createElement('div');
        newHeaderMenu.className = 'form-group mt-3';
        newHeaderMenu.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <label for="header_menu_title">Menu Title</label>
                                <input type="text" name="header_menu_title[]" class="form-control" placeholder="Enter menu title">
                            </div>
                            <div class="col-md-6">
                                <label for="header_menu_link">Menu Link</label>
                                <input type="text" name="header_menu_link[]" class="form-control" placeholder="Enter menu link">
                            </div>
                            <hr class="mt-3">
                        </div>`;
        container.appendChild(newHeaderMenu);
    });
    // Remove last header menu
    document.getElementById('removeHeaderMenu').addEventListener('click', function () {
        const container = document.getElementById('headerMenuContainer');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
    });
    // Add more footer menu
    document.getElementById('addFooterMenu').addEventListener('click', function () {
        const container = document.getElementById('footerMenuContainer');
        const newFooterMenu = document.createElement('div');
        newFooterMenu.className = 'form-group mt-3';
        newFooterMenu.innerHTML = `
                                    <dic class=""row">
                                                <div class="col-md-6">
                                                    <label for="footer_menu_title">Menu Title</label>
                                                    <input type="text" name="footer_menu_title[]" class="form-control" placeholder="Enter menu title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="footer_menu_link">Menu Link</label>
                                                    <input type="text" name="footer_menu_link[]" class="form-control" placeholder="Enter menu link">
                                                </div>
                                                <hr class="mt-3">
                                                </div>
                                            `;
        container.appendChild(newFooterMenu);
    });
    // Remove last footer menu
    document.getElementById('removeFooterMenu').addEventListener('click', function () {
        const container = document.getElementById('footerMenuContainer');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
    });
</script>

@endsection