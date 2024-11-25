<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::orderBy('id', 'desc')->paginate(10);
        return view('admin.countrylist', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.addcountry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'country' => 'required|string|max:255|unique:countries,country_name', // Assuming 'countries' is the table name and 'name' is the column
            'counry_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle the file upload
        if ($request->hasFile('counry_image')) {
            $file = $request->file('counry_image');

            // Define the path to save the image
            $path = 'country_images/';

            // Generate a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Store the image in the public path
            $file->move(public_path($path), $filename);

            // Create a new country entry in the database
            Country::create([
                'country_name' => $request->country,
                'country_image' => $path . $filename,
            ]);

            return redirect()->route('destinations.create')->with('success', 'Country added successfully!');
        }
        return redirect()->back()->with('error', 'Image upload failed.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $countries, $id)
    {
        $countries = Country::findOrFail($id); // Find the country by ID
        return view('admin.editcountry', compact('countries')); // Pass the country to the view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $countries, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_image' => 'nullable|image|mimes:jpg,jpeg,png', // Validation for the image
        ]);

        $countries = Country::findOrFail($id);

        // Update the country name
        $countries->country_name = $request->input('name');

        // If a new image is uploaded, store it and update the country record
        if ($request->hasFile('country_image')) {
            // Delete the old image from storage if it's being replaced
            if ($countries->image) {
                $oldImagePath = public_path('country_images/' . $countries->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);  // Delete the old image
                }
            }

            // Get the file and move it to the public directory
            $file = $request->file('country_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();  // Create a unique filename
            $path = 'country_images/' . $filename;

            // Move the file to the public directory
            $file->move(public_path('country_images'), $filename);

            // Update the image path in the database
            $countries->country_image = $path;
        }

        // Save the updated country
        $countries->save();

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
