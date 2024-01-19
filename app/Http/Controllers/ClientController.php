<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginClientRequest;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class ClientController extends Controller
{
    use HttpResponses;


    //only admins can execute this function
    public function index()
    {
        $clients = Client::all();
        return $this->success([
            'clients' => $clients,
        ], "All Clients");
    }


    //anyone can excute this 
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

    //anyone can excute this 
    public function login(LoginClientRequest $request)
    {
        //return response()->json('Login function');
        $request->validated($request->only(['email', 'password']));
        $client = Client::where('email', $request->email)->first();
        if (!$client || !Hash::check($request->password, $client->password)) {
            return $this->error('', 'Credentials do not match', 422);
        }
        return $this->success([
            'client' => $client,
            'token' => $client->createToken('client-token')->plainTextToken
        ], "Client logged in successfully");
    }

    //executed by logged in clients only
    public function logout()
    {
        //return response()->json('Logout function');
        $client = Auth::guard('client')->user();
        if ($client) {
            $client->tokens()->where('name', 'client-token')->delete();
            return $this->success([], "You have succesfully been logged out as a client and your token(s) has been removed");
        } else {
            return $this->error('', 'The client is not logged in', 401);
        }
    }


    public function edit(UpdateClientRequest $request, $client_id)
    {
        $client = Client::find($client_id);
        if (!$client) {
            return $this->error('', 'The client you want to edit is not found', 401);
        }
        $new_data = $request->validated();
        $client->update($new_data);
        return $this->success([
            'client' => $client,
        ], "Client updated successfully");
    }

     public function editProfile(UpdateClientRequest $request)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'The client you want to edit is not found', 401);
        }
        $new_data = $request->validated();
        $client->update($new_data);
        return $this->success([
            'client' => $client,
        ], "Client updated successfully");
    }

    public function show($client_id)
    {
        $client = Client::find($client_id);
        if (!$client) {
            return $this->error('', 'Client not found or invlaid Client id', 401);
        }
        return $this->success([
            'client' => $client,
        ], "Client found");
    }


    public function destroy($client_id)
    {
        $client = Client::find($client_id);
        if (!$client) {
            return $this->error('', 'The client you want to delete doesn\'t exist', 401);
        }
        $client->delete();
        return $this->success([
            'client' => $client,
        ], "Client deleted successfully");
    }
    //executed by the client
    public function showProfile()
    {
        // if (Auth::guard('client')->user()->id !== (int)$client_id) {
        //     return $this->error('', 'You are unauthorized to make this request', 401);
        // }
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        return $this->success([
            'client' => $client,
        ], "Client profile found");
    }

    public function search($url)
    {
        return Client::where("full_name", "like", "%" . $url . "%")->get();
    }

    public function localisation(Request $request)
    {
         if ($request->has(['latitude', 'longitude'])) {
         $localisation  =   new \App\Models\localisation ([
         'latitude' => $request->latitude,
         'longitude' => $request->longitude,
         'autobulance_id'=> 1 
     ]);
        event( new  \App\Events\SendLocalisation());
        return response()->json(['data' => $localisation], 200);
    }
    }
    public function ressetPassword(Request $request)
    {
          if ($request->has('password')) {
            $client = Auth::guard('client')->user();
        if ($client) {
             $user->update(['password' => Hash::make($request->password)]);
            return $this->success([], "You have succesfully resset your password ");
        } else {
            return $this->error('', 'The client is not logged in', 401);
        }
          }else{
             return $this->error('', $request, 405);
          }
    }
}
