<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    // Tampil semua data Services
    public function index()
    {
        $data = Service::paginate(10);
        return response()->json([
            'message' => 'success',
            'data' => $data,
        ]);
    }

    // Tampil detail data services
    public function getServices($id)
    {
        $data = Service::find($id);
        if ($data) {
            return response()->json([
                'message' => 'success',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
            ]);
        }
    }

    // Tampil data services berdasarkan user seller
    public function getServicesByUserId()
    {
        // return 'halohalo';
        $data = Service::where('user_id', Auth::user()->id)->get();
        if ($data) {
            return response()->json([
                'message' => 'success',
                'data' => $data,
            ]);
        }
    }

    public function store(Request $request)
    {
        $data = Service::create($request->all());
        return response()->json([
            'message' => 'success',
            'data' => $data,
        ]);
    }
}
