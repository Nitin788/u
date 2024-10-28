<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Homepage;

class HomepageController extends Controller
{
    public function index()
    {
        $homepages = Homepage::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($homepages->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($homepages);
    }

    public function location()
    {
        // Eager load destinations along with their hotels
        $locations = Country::with(['destinations.hotels'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($locations->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        // Format the response if needed
        $formattedLocations = $locations->map(function ($country) {
            return [
                'id' => $country->id,
                'country_name' => $country->country_name,
                'country_image' => $country->country_image,
                'created_at' => $country->created_at,
                'updated_at' => $country->updated_at,
                'destinations' => $country->destinations->map(function ($destination) {
                    return [
                           'id' => $destination->id,
                        'destination_name' => $destination->destination_name,
                        'destination_image' => $destination->destination_image,
                        'country_id' => $destination->country_id,
                        'created_at' => $destination->created_at,
                        'updated_at' => $destination->updated_at,
                        'hotels' => $destination->hotels->map(function ($hotel) {
                            
                            return [
                                'id' => $hotel->id,
                                'hotel_name' => $hotel->hotel_name,
                                'hotel_image' => $hotel->hotel_image,
                                'hotel_description' => $hotel->hotel_description,
                                'destination_id' => $hotel->destination_id,
                                'created_at' => $hotel->created_at,
                                'updated_at' => $hotel->updated_at,
                            ];
                        }),
                    ];
                }),
            ];
        });
        return response()->json($formattedLocations);
    }

}
