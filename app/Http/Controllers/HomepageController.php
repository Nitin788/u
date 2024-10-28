<?php

namespace App\Http\Controllers;

use App\Models\Homepage;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homepages = Homepage::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.homepagelist', compact('homepages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.addhomepage');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'slider_images' => 'required|array|min:2',
            'slider_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'card_images_title' => 'required|array|min:4',
            'card_images_title.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'card_title' => 'required|array|min:4',
            'status' => 'required|boolean',
            'offer_image' => 'required|array|min:3',
            'offer_image.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'offer_title' => 'required|array|min:3',
            'offers' => 'required|array',
            'inclusions' => 'required|array',
        ]);

        // Store slider images
        $sliderImages = [];
        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('slider_images'), $fileName);
                $sliderImages[] = $fileName;
            }
        }

        // Prepare card data
        $cardData = [];
        if ($request->hasFile('card_images_title') && is_array($request->card_title)) {
            foreach ($request->file('card_images_title') as $index => $file) {
                if (isset($request->card_title[$index]) && $request->card_title[$index]) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('card_images_title'), $fileName);

                    $cardData[] = [
                        'title' => $request->card_title[$index],
                        'image' => $fileName,
                    ];
                }
            }
        }

        // Store Book Direct Offers
        $bookOffers = [];
        if (
            is_array($request->offer_image) && is_array($request->offer_title) &&
            is_array($request->offers) && is_array($request->inclusions)
        ) {

            foreach ($request->offer_image as $index => $file) {
                if (isset($request->offer_title[$index]) && $request->offer_title[$index]) {
                    $offerFileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('offer_images'), $offerFileName);

                    $bookOffers[] = [
                        'image' => $offerFileName,
                        'title' => $request->offer_title[$index],
                        'offers' => $request->offers[$index],
                        'inclusions' => $request->inclusions[$index],
                    ];
                }
            }
        }

        // Save the data to the database (you might have a model like Homepage or similar)
        $homepage = new Homepage(); // replace with your actual model
        $homepage->slider_images = json_encode($sliderImages);
        $homepage->card_images_title = json_encode($cardData);
        $homepage->book_offers = json_encode($bookOffers); // Assuming you have a column for book offers
        $homepage->status = $request->status;
        $homepage->save();

        return redirect()->route('homepages.index')->with('success', 'Homepage created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Homepage $homepage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Homepage $homepages, $id)
    {
        $homepages = Homepage::findOrFail($id);
        return view('admin.edithomepage', compact('homepages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the existing homepage record
        $homepage = Homepage::findOrFail($id);

        // Validate the request
        $request->validate([
            'slider_images' => 'nullable|array',
            'slider_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'card_images_title' => 'nullable|array',
            'card_images_title.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'card_title' => 'nullable|array',
            'status' => 'required|boolean',
            'offer_image' => 'nullable|array',
            'offer_image.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'offer_title' => 'nullable|array',
            'offers' => 'nullable|array',
            'inclusions' => 'nullable|array',
        ]);

        // Store slider images
        $sliderImages = json_decode($homepage->slider_images, true) ?? [];

        // Handle new slider images
        if ($request->hasFile('slider_images')) {
            // Unlink old images
            foreach ($sliderImages as $oldImage) {
                if (file_exists(public_path('slider_images/' . $oldImage))) {
                    unlink(public_path('slider_images/' . $oldImage));
                }
            }

            $sliderImages = []; // Reset for new images
            foreach ($request->file('slider_images') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('slider_images'), $fileName);
                $sliderImages[] = $fileName;
            }
        }

        // Prepare card data
        $cardData = json_decode($homepage->card_images_title, true) ?? [];

        // Handle new card images and titles
        if ($request->hasFile('card_images_title')) {
            foreach ($request->file('card_images_title') as $index => $file) {
                if (isset($cardData[$index])) {
                    // Unlink old image if exists
                    if (file_exists(public_path('card_images_title/' . $cardData[$index]['image']))) {
                        unlink(public_path('card_images_title/' . $cardData[$index]['image']));
                    }
                    // Upload new image
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('card_images_title'), $fileName);
                    $cardData[$index]['image'] = $fileName; // Update the image
                }

                // Update the title if provided
                if (isset($request->card_title[$index])) {
                    $cardData[$index]['title'] = $request->card_title[$index];
                }
            }
        } else {
            // If no new images, update titles only
            foreach ($cardData as $index => $card) {
                if (isset($request->card_title[$index])) {
                    $cardData[$index]['title'] = $request->card_title[$index];
                }
            }
        }

        // Store Book Direct Offers
        $bookOffers = json_decode($homepage->book_offers, true) ?? [];

        // Handle new offer images and corresponding fields
        foreach ($bookOffers as $index => $offer) {
            // Update title, offers, and inclusions if new values are provided
            if (isset($request->offer_title[$index])) {
                $offer['title'] = $request->offer_title[$index];
            }
            if (isset($request->offers[$index])) {
                $offer['offers'] = $request->offers[$index];
            }
            if (isset($request->inclusions[$index])) {
                $offer['inclusions'] = $request->inclusions[$index];
            }

            // Check for a new image
            if (isset($request->offer_image[$index])) {
                // Unlink old offer image if it exists
                if (file_exists(public_path('offer_images/' . $offer['image']))) {
                    unlink(public_path('offer_images/' . $offer['image']));
                }

                // Upload the new image
                $file = $request->file('offer_image')[$index];
                $offerFileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('offer_images'), $offerFileName);
                $offer['image'] = $offerFileName; // Update the image
            }

            $bookOffers[$index] = $offer; // Update the bookOffers array
        }

        // Update the data in the database
        $homepage->slider_images = json_encode(array_values($sliderImages)); // Ensure re-indexing
        $homepage->card_images_title = json_encode($cardData);
        $homepage->book_offers = json_encode($bookOffers);
        $homepage->status = $request->status;
        $homepage->save();

        return redirect()->route('homepages.index')->with('success', 'Homepage updated successfully!');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homepage $homepages, $id)
    {
        $homepages = Homepage::findOrFail($id);
        // Delete the Homepage
        $homepages->delete();
        return redirect()->route('homepages.index')->with('success', 'Homepage Data deleted successfully');
    }
}
