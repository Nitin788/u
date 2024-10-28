@extends('admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Homepage Form</h3>
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
                    <a href="{{route('homepages.index')}}">Homepage List</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{route('homepages.create')}}">Homepage Form</a>
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
                    <div class="container">
                        <h2>Create New Homepage</h2>
                        <hr />
                        <form action="{{ route('homepages.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Slider Images Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Slider Images
                                </div>
                                <div class="card-body">
                                    <strong class="form-text text-muted mb-3">You can upload multiple images. Minimum 2
                                        images required.</strong>
                                    <label for="slider_images">Slider Images (multiple)</label>
                                    <input type="file" name="slider_images[]" class="form-control-file"
                                        id="slider_images" multiple required>
                                </div>
                            </div>

                            <!-- Card Section -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Card Images and Titles
                                </div>
                                <div class="card-body">
                                    <strong class="form-text text-muted mb-3">You can upload multiple Card images.
                                        Minimum 4 images and titles required.</strong>
                                    <div id="cardContainer" class="row">
                                        <div class="form-group mt-3 col-md-6">
                                            <label for="card_images_title">Card Image</label>
                                            <input type="file" name="card_images_title[]" class="form-control-file"
                                                id="card_images_title" required>
                                        </div>
                                        <div class="form-group mt-3 col-md-6">
                                            <label for="card_title">Card Title</label>
                                            <input type="text" name="card_title[]" class="form-control" id="card_title"
                                                placeholder="Enter card title" required>
                                        </div>
                                    </div>
                                    <input type="button" id="addCard" class="btn btn-danger mt-3" value="+">
                                    <input type="button" id="cancelCard" class="btn btn-warning mt-3" value="-">
                                </div>
                            </div>

                            <!-- Book Direct Offer Section -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Book Direct Offer
                                </div>
                                <div class="card-body">
                                    <strong class="form-text text-muted mb-3">Fill in the details for the Book Direct
                                        Offer.</strong>
                                    <div id="offerContainer">
                                        <div class="row offer-group mb-3">
                                            <div class="form-group  col-md-6">
                                                <label for="offer_image">Offer Image</label>
                                                <input type="file" name="offer_image[]" class="form-control-file"
                                                    required>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="offer_title">Offer Title</label>
                                                <input type="text" name="offer_title[]" class="form-control"
                                                    placeholder="Enter offer title" required>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="offers">Offers</label>
                                                <input type="text" name="offers[]" class="form-control"
                                                    placeholder="Enter offers details" required>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="inclusions">Inclusions</label>
                                                <input type="text" name="inclusions[]" class="form-control"
                                                    placeholder="Enter inclusions details" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="button" id="addOffer" class="btn btn-danger mt-3" value="+">
                                    <input type="button" id="removeOffer" class="btn btn-warning mt-3" value="-">
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
                                        <select name="status" class="form-control" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-3">Create</button>
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

@push('addCard')
    <script>
        let cardCount = 1; // To track the number of card inputs

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
                                                                <label for="card_images_title">Card Image</label>
                                                                <input type="file" name="card_images_title[]" class="form-control-file" id="card_images_title_${cardCount}">
                                                            `;

            // Create card title input
            const cardTitleDiv = document.createElement('div');
            cardTitleDiv.className = 'form-group col-md-6';
            cardTitleDiv.innerHTML = `
                                                                <label for="card_title">Card Title</label>
                                                                <input type="text" name="card_title[]" class="form-control" placeholder="Enter card title">

                                                            `;
            // Append new inputs to the new row
            newCardRow.appendChild(cardImageDiv);
            newCardRow.appendChild(cardTitleDiv);

            // Append new row to the card container
            cardContainer.appendChild(newCardRow);
        });

        // offer 

        document.getElementById('cancelCard').addEventListener('click', function () {
            if (cardCount > 1) { // Ensure at least one card is present
                const cardContainer = document.getElementById('cardContainer');
                const lastCardRow = document.getElementById(`cardRow${cardCount}`);
                cardContainer.removeChild(lastCardRow); // Remove the last added row
                cardCount--; // Decrement the count
            }
        });
        document.getElementById('addOffer').addEventListener('click', function () {
            // Clone the offer group
            const offerContainer = document.getElementById('offerContainer');
            const newOfferGroup = offerContainer.firstElementChild.cloneNode(true);

            // Clear the input values in the cloned fields
            Array.from(newOfferGroup.querySelectorAll('input')).forEach(input => {
                input.value = '';
            });

            // Append the cloned group to the container
            offerContainer.appendChild(newOfferGroup);
        });

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