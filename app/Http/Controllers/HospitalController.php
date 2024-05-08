<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $hospitals = Hospital::all();
        $hospitalsArray = [];

        foreach ($hospitals as $hospital) {
            $hospitalsArray[] = [
                'id' => $hospital->id,
                'name' => $hospital->h_name,
                'lat' => $hospital->lat,
                'lng' => $hospital->lng,
                'alamat' => $hospital->address,
                'gambar' => $hospital->picture
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
    public function create(Request $request)
    {
        $data = $request->only('h_name', 'lat', 'lng', 'address', 'picture');
        $validator = Validator::make($data, [
            'h_name' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'address' => 'required|string',
            'picture' => 'image|file|max:2000'
        ]);

        if ($validator->fails()){
            return response()->json([
                'success'=> false,
                'message'=> $validator->errors()->first(),
            ]);
        }

        $hospital = Hospital::create([
            'h_name' => $request->h_name,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'address' => $request->address,
            'picture' => $request->file('picture')->store('images')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hospital created successfully',
            'data' => $hospital
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hospital = Hospital::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => ([
                'id' => $hospital['id'],
                'name'=> $hospital['h_name'],
                'lat'=> $hospital['lat'],
                'lng'=> $hospital['lng'],
                'address'=> $hospital['address'],
                'picture'=> $hospital['picture'],
            ])
        ], 200);
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
    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Hospital updated successfully',
            'data'=> ([
                'id' => $hospital['id'],
                'name' => $hospital['h_name'],
                'lat' => $hospital['lat'],
                'lng' => $hospital['lng'],
                'address' => $hospital['address'],
            ])
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();
        return response()->json(([
            'success' => true,
            'message' => 'Hospital updated successfully',
            'data'=> ([
                'id' => $hospital['id'],
                'name' => $hospital['h_name'],
                'lat' => $hospital['lat'],
                'lng' => $hospital['lng'],
                'address' => $hospital['address'],
            ])
        ]), 200);
    }
}
