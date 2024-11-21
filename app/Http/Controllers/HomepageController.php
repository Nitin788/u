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
            'slider_images.*' => 'image|mimes:jpg,jpeg,png,gif',
            // 'card_images_title' => 'required|array|min:4',
            // 'card_images_title.*' => 'image|mimes:jpg,jpeg,png,gif',
            // 'card_title' => 'required|array|min:4',
            'status' => 'required|boolean',
            'offer_image' => 'required|array|min:3',
            'offer_image.*' => 'image|mimes:jpg,jpeg,png,gif',
            'offer_title' => 'required|array|min:3',
            'offers' => 'required|array',
            'inclusions' => 'required|array',
            'footer_images' => 'nullable|array', // Added validation for footer images
            'footer_images.*' => 'image|mimes:jpg,jpeg,png,gif', // Ensuring valid images for footer
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

        // Store footer images (multiple)
        $footerImages = [];
        if ($request->hasFile('footer_images')) {
            foreach ($request->file('footer_images') as $file) {
                $footerFileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('footer_images'), $footerFileName);
                $footerImages[] = $footerFileName;
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

        // Prepare header menu data
        $headerMenu = [];
        if (is_array($request->header_menu_title) && is_array($request->header_menu_link)) {
            foreach ($request->header_menu_title as $index => $title) {
                if (isset($request->header_menu_link[$index]) && $request->header_menu_link[$index]) {
                    $headerMenu[] = [
                        'title' => $title,
                        'link' => $request->header_menu_link[$index],
                    ];
                }
            }
        }

        // Prepare footer menu data
        $footerMenu = [];
        if (is_array($request->footer_menu_title) && is_array($request->footer_menu_link)) {
            foreach ($request->footer_menu_title as $index => $title) {
                if (isset($request->footer_menu_link[$index]) && $request->footer_menu_link[$index]) {
                    $footerMenu[] = [
                        'title' => $title,
                        'link' => $request->footer_menu_link[$index],
                    ];
                }
            }
        }

        // Save the data to the database (you might have a model like Homepage or similar)
        $homepage = new Homepage(); // replace with your actual model
        $homepage->slider_images = json_encode($sliderImages);
        $homepage->footer_images = json_encode($footerImages); // Save footer images as JSON
        // $homepage->card_images_title = json_encode($cardData);
        $homepage->book_offers = json_encode($bookOffers); // Assuming you have a column for book offers
        $homepage->header_menu = json_encode($headerMenu); // Save header menu as JSON
        $homepage->footer_menu = json_encode($footerMenu); // Save footer menu as JSON
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
            'slider_images.*' => 'image|mimes:jpg,jpeg,png,gif',
            'card_images_title' => 'nullable|array',
            'card_images_title.*' => 'image|mimes:jpg,jpeg,png,gif',
            'card_title' => 'nullable|array',
            'status' => 'required|boolean',
            'offer_image' => 'nullable|array',
            'offer_image.*' => 'image|mimes:jpg,jpeg,png,gif',
            'offer_title' => 'nullable|array',
            'offers' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'footer_images' => 'nullable|array', // Added footer_images validation
            'footer_images.*' => 'image|mimes:jpg,jpeg,png,gif', // Ensuring valid images for footer
        ]);

        // Store slider images
        $sliderImages = json_decode($homepage->slider_images, true) ?? [];

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

        // Handle header menu update
        $headerMenu = json_decode($homepage->header_menu, true) ?? [];
        if (is_array($request->header_menu_title) && is_array($request->header_menu_link)) {
            $headerMenu = [];
            foreach ($request->header_menu_title as $index => $title) {
                if (isset($request->header_menu_link[$index]) && $request->header_menu_link[$index]) {
                    $headerMenu[] = [
                        'title' => $title,
                        'link' => $request->header_menu_link[$index],
                    ];
                }
            }
        }

        // Handle footer menu update
        $footerMenu = json_decode($homepage->footer_menu, true) ?? [];
        if (is_array($request->footer_menu_title) && is_array($request->footer_menu_link)) {
            $footerMenu = [];
            foreach ($request->footer_menu_title as $index => $title) {
                if (isset($request->footer_menu_link[$index]) && $request->footer_menu_link[$index]) {
                    $footerMenu[] = [
                        'title' => $title,
                        'link' => $request->footer_menu_link[$index],
                    ];
                }
            }
        }

        // Store footer images (multiple)
        $footerImages = json_decode($homepage->footer_images, true) ?? [];

        if ($request->hasFile('footer_images')) {
            // Unlink old footer images
            foreach ($footerImages as $oldImage) {
                if (file_exists(public_path('footer_images/' . $oldImage))) {
                    unlink(public_path('footer_images/' . $oldImage));
                }
            }

            $footerImages = []; // Reset for new images
            foreach ($request->file('footer_images') as $file) {
                $footerFileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('footer_images'), $footerFileName);
                $footerImages[] = $footerFileName;
            }
        }

        // Update the data in the database
        $homepage->slider_images = json_encode(array_values($sliderImages)); // Ensure re-indexing
        $homepage->card_images_title = json_encode($cardData);
        $homepage->book_offers = json_encode($bookOffers);
        $homepage->header_menu = json_encode($headerMenu); // Save updated header menu
        $homepage->footer_menu = json_encode($footerMenu); // Save updated footer menu
        $homepage->footer_images = json_encode($footerImages); // Save footer images
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
