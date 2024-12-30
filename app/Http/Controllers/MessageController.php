<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'phone_number' => 'required|phone:ID' 
        // ]);

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        }


        $res = Http::withHeaders([
            "Authorization" => "Bearer " . env("WA_BUSINESS_KEY")
        ])->withBody(json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "+62895397096742",
            "type" => "text",
            "text" => [
                "preview_url" => true,
                "body" => "As requested, here's the link to our latest product: https://www.meta.com/quest/quest-3/"
            ]
        ]), 'application/json')->post('https://graph.facebook.com/v21.0/449645901574957/messages');


        return response()->json($res->json());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
