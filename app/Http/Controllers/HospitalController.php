<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            $pic = $hospital->picture;
            $base64Pic = base64_encode($pic);
            $hospitalsArray[] = [
                'id' => $hospital->id,
                'name' => $hospital->h_name,
                'lat' => $hospital->lat,
                'lng' => $hospital->lng,
                'alamat' => $hospital->address,
                'gambar' => $base64Pic,
                'tipe' => $hospital->type
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
        $data = $request->only('h_name', 'lat', 'lng', 'address', 'picture', 'type');
        $validator = Validator::make($data, [
            'h_name' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'address' => 'required|string',
            'picture' => 'image|file|max:2000',
            'type' => 'string',
        ]);

        if ($validator->fails()){
            return response()->json([
                'success'=> false,
                'message'=> $validator->errors()->first(),
            ]);
        }

        $hospital = new Hospital();
        $hospital->h_name = $request->h_name;
        $hospital->lat = $request->lat;
        $hospital->lng = $request->lng;
        $hospital->address = $request->address;
        $hospital->type = $request->type;
        // Mengambil data gambar dan menyimpannya ke dalam kolom 'picture' sebagai BLOB
        $hospital->picture = file_get_contents($request->file('picture'));
        
        $hospital->save();

        return response()->json([
            'success' => true,
            'message' => 'Hospital created successfully'
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
        $pic = $hospital->picture;
        $base64Pic = base64_encode($pic);
        return response()->json([
            'success' => true,
            'data' => ([
                'id' => $hospital['id'],
                'name'=> $hospital['h_name'],
                'lat'=> $hospital['lat'],
                'lng'=> $hospital['lng'],
                'address'=> $hospital['address'],
                'type'=> $hospital['type'],
                'picture'=> $base64Pic,
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
        $hospital = Hospital::find($id);
        $hospital->h_name = $request->h_name;
        $hospital->address = $request->address;
        $hospital->type = $request->type;
         // Mengambil data gambar dan menyimpannya ke dalam kolom 'picture' sebagai BLOB
         $hospital->picture = file_get_contents($request->file('picture')->getRealPath());
        $hospital->save();

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Hospital updated successfully',
            'data' => [
                'id' => $hospital['id'],
                'name'=> $hospital['h_name'],
                'address'=> $hospital['address'],
                'type'=> $hospital['type'],
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hId = $hospital->id;
        $hospital->delete();
        return response()->json(([
            'success' => true,
            'message' => "Hospital {$hId} deleted successfully",
            'data'=> ([
                'name' => $hospital['h_name'],
                'lat' => $hospital['lat'],
                'lng' => $hospital['lng'],
                'address' => $hospital['address'],
            ])
        ]), 200);
    }
}
