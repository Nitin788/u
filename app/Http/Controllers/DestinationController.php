<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\Country;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::with('country')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.adddestination', compact('destinations'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.adddestination', compact('countries'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_name' => 'required|string|max:255|unique:destinations,destination_name',
            'destination_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'country_id' => 'required|exists:countries,id',
        ]);
        $destination = new Destination($request->all());
        if ($request->hasFile('destination_image')) {
            $filename = time() . '.' . $request->destination_image->getClientOriginalExtension();
            $request->destination_image->move(public_path('destination_images'), $filename);
            $destination->destination_image = 'destination_images/' . $filename;
        }
        $destination->save();

        return redirect()->route('hotels.create')->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        //
    }
}
