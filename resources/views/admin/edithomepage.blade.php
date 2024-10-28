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

                            <!-- Slider Images Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Slider Images
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
                            <div class="card mb-3">
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
                                        <input type="button" class="btn btn-success float-right" id="addCard" value="+">
                                        <input type="button" class="btn btn-danger float-right mr-2" id="cancelCard"
                                            value="-">
                                    @else
                                        <p>No card images found.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Book Offers Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Book Offers
                                </div>
                                <div class="card-body">
                                    <div id="offerContainer">
                                        @php $bookOffers = json_decode($homepages->book_offers, true); @endphp
                                        @if (is_array($bookOffers) && count($bookOffers) > 0)
                                            @foreach($bookOffers as $index => $offer)
                                                <div class="row offer-group mb-3">
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
                                            <input type="button" class="btn btn-success float-right" id="addOffer" value="+">
                                            <input type="button" class="btn btn-danger float-right mr-2"
                                                id="removeOffer" value="-">
                                        @else
                                            <p>No book offers available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Status
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
</script>
@push('EditaddCard')
    <script>
        let cardCount = {{ count($cardImages) }}; // Initialize with existing card count
        let offerCount = {{ count($bookOffers) }}; // Initialize with existing offer count

        // Add Card
        document.getElementById('addCard').addEventListener('click', function () {
            cardCount++;
            const cardContainer = document.getElementById('cardContainer');

            // Create new row for additional card inputs
            const newCardRow = document.createElement('div');
            newCardRow.className = 'row mt-3';
            newCardRow.id = `cardRow${cardCount}`;

            // Create card image input
            const cardImageDiv = document.createElement('div');
            cardImageDiv.className = 'form-group col-md-6';
            cardImageDiv.innerHTML = `
                                <label for="card_images_title_${cardCount}">Card Image</label>
                                <input type="file" name="card_images_title[]" class="form-control-file" id="card_images_title_${cardCount}">
                            `;

            // Create card title input
            const cardTitleDiv = document.createElement('div');
            cardTitleDiv.className = 'form-group col-md-6';
            cardTitleDiv.innerHTML = `
                                <label for="card_title_${cardCount}">Card Title</label>
                                <input type="text" name="card_title[]" class="form-control" placeholder="Enter card title">
                            `;

            // Append new inputs to the new row
            newCardRow.appendChild(cardImageDiv);
            newCardRow.appendChild(cardTitleDiv);

            // Append new row to the card container
            cardContainer.appendChild(newCardRow);
        });

        // Cancel Card
        document.getElementById('cancelCard').addEventListener('click', function () {
            if (cardCount > 1) { // Ensure at least one card is present
                const cardContainer = document.getElementById('cardContainer');
                const lastCardRow = document.getElementById(`cardRow${cardCount}`);
                cardContainer.removeChild(lastCardRow); // Remove the last added row
                cardCount--; // Decrement the count
            }
        });

        // Add Offer
        document.getElementById('addOffer').addEventListener('click', function () {
            offerCount++;
            const offerContainer = document.getElementById('offerContainer');
            const newOfferGroup = offerContainer.firstElementChild.cloneNode(true);

            // Clear the input values in the cloned fields
            Array.from(newOfferGroup.querySelectorAll('input')).forEach(input => {
                input.value = '';
                // Reset the ID for the cloned inputs
                input.id = input.id.replace(/\d+$/, offerCount); // Update the ID to the new count
            });

            // Append the cloned group to the container
            offerContainer.appendChild(newOfferGroup);
        });

        // Cancel Offer
        document.getElementById('removeOffer').addEventListener('click', function () {
            const offerGroups = document.querySelectorAll('.offer-group');
            if (offerGroups.length > 1) {
                // Remove the last offer group
                offerGroups[offerGroups.length - 1].remove();
            } else {
                alert('At least one offer must be present.');
            }
        });
    </script>
@endpush
@endsection