<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = JWTAuth::authenticate($request->token);
        $hospitals = Hospital::all();
        $hospitalsArray = [];

        foreach ($hospitals as $hospital) {
            $pic = $hospital->picture;
            $base64Pic = base64_encode($pic);

            $hospitalsArray[] = [
                'id' => $hospital->id,
                'name' => $hospital->h_name,
                'lat' => $hospital->lat,
                'lng' => $hospital->lng,
                'alamat' => $hospital->address,
                'gambar' => $base64Pic
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get hospital info',
            'data' => $hospitalsArray,  
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = JWTAuth::authenticate($request->token);
        $data = $request->only('h_name', 'lat', 'lng', 'address');

        $validator = Validator::make($data, [
            'h_name' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'address' => 'required|string'
        ]);

        $hospital = Hospital::create([
            'h_name' => $request->h_name,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hospital created successfully',
            'data' => $hospital
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        //
    }
}
