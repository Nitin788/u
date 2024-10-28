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
            'counry_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
