<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginClientRequest;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class ClientController extends Controller
{
    use HttpResponses;



    public function showAll()
    {
        $clients = Client::all();
        return response()->json(['data' => $clients], 200);
    }

    public function search($url)
    {
        return Client::where("full_name", "like", "%" . $url . "%")->get();
    }

    public function register(StoreClientRequest $request)
    {
        // return response()->json('Register functiton');
        $request->validated($request->all());
        $client = Client::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender
        ]);

        return $this->success([
            'client' => $client,
            'token' => $client->createToken('client-token')->plainTextToken,
        ], "Client registration was successful", 201); //200 ya3ni success et 201 ya3ni success + created
    }

    public function login(LoginClientRequest $request)
    {
        //return response()->json('Login function');
        $request->validated($request->only(['email', 'password']));
        $client = Client::where('email', $request->email)->first();
        if (!$client || !Hash::check($request->password, $client->password)) {
            return $this->error('', 'Credentials do not match', 401);
        }
        return $this->success([
            'client' => $client,
            'token' => $client->createToken('client-token')->plainTextToken
        ], "Client logged in successfully");
    }


    public function logout()
    {
        //return response()->json('Logout function');
        $client = Auth::guard('client')->user();
        if ($client) {
            $client->tokens()->where('name', 'client-token')->delete();
            return $this->success([
                'message' => 'You have succesfully been logged out as a client and your token(s) has been removed'
            ]);
        }
    }


    public function show($url)
    {
        if (Auth::guard('client')->user()->id !== (int)$url) {
            return $this->error('', 'You are unauthorized to make this request', 401);
        }
        $client = Auth::guard('client')->user();
        if (is_null($client)) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json(['data' => $client], 200);
    }
}
