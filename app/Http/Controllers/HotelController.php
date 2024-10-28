<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Destination;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order hotels by 'created_at' in descending order
        $hotels = Hotel::with(['destination'])
            ->orderBy('created_at', 'desc') // Replace 'created_at' with the desired column name
            ->paginate(10);
        return view('admin.hotellist', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('admin.addhotel', compact( 'destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'hotel_name' => 'required|string|max:255|unique:hotels,hotel_name,',
            'hotel_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hotel_description' => 'nullable|string',
        ]);

        // Create a new hotel instance
        $hotel = new Hotel();
        $hotel->destination_id = $request->destination_id;
        $hotel->hotel_name = $request->hotel_name;
        $hotel->hotel_description = $request->hotel_description;

        // Handle the image upload
        if ($request->hasFile('hotel_image')) {
            $filename = time() . '.' . $request->hotel_image->getClientOriginalExtension();
            $request->hotel_image->move(public_path('hotel_images'), $filename);
            $hotel->hotel_image = 'hotel_images/' . $filename;
        }

        // Save the hotel
        $hotel->save();

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the hotel by ID or fail
        $hotel = Hotel::findOrFail($id);
        // Retrieve the list of countries and destinations
        $destinations = Destination::all();

        return view('admin.edithotel', compact('hotel',  'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'hotel_name' => 'required|string|max:255',
            'hotel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hotel_description' => 'nullable|string',
        ]);

        $hotel = Hotel::findOrFail($id);
        $hotel->destination_id = $request->destination_id;
        $hotel->hotel_name = $request->hotel_name;
        // Handle file upload
        if ($request->hasFile('hotel_image')) {
            // Delete the old image if it exists
            if ($hotel->hotel_image) {
                $oldImagePath = public_path('storage/' . $hotel->hotel_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $hotel->hotel_image = $request->file('hotel_image')->store('hotel_images', 'public');
        }

        $hotel->hotel_description = $request->hotel_description;
        $hotel->save();

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the hotel by ID or fail
        $hotel = Hotel::findOrFail($id);
        // Delete the hotel record
        $hotel->delete();

        // Redirect with success message
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
