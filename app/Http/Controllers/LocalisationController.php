<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use App\Http\Requests\StoreLocalisationRequest;
use App\Http\Requests\UpdateLocalisationRequest;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionReparateur;

class LocalisationController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all localisation of autobulances managed by auth admin ;
        $staff =Auth::guard('staff')->user();
        $localisations =Localisation::select
        ('transaction_reparateurs.autobulance_id', 'localisations.latitude', 'localisations.longitude')
        ->join('transaction_reparateurs', 'transaction_reparateurs.autobulance_id',"=",'localisations.autobulance_id')
       
       ->where('transaction_reparateurs.detached_at',null)
       ->where('transaction_reparateurs.staff_id', $staff['id'])->get(["transaction_reparateurs.autobulance_id","localisations.latitude","localisations.longitude"]);
        return  response()->json([
            'data' => $localisations,
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //auth manager post his autobulance localisation 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalisationRequest $request)
    {
        //auth manager post his autobulance localisation 
        $request->validated($request->all());
        $manager =Auth::guard('staff')->user();
        $trans =TransactionReparateur::where('staff_id',$manager['id'])->where('detached_at',null)->first();
        if(!$trans){
            return $this->error('', ' not found any autobulance', 404);
        }
        else {
          
        $localisation = Localisation::where('autobulance_id',$trans['autobulance_id'])->first();
        if (!$localisation){
        $localisation = Localisation::create(['latitude'=>$request->latitude,
        'longitude'=>$request->longitude,
        'autobulance_id'=>$trans['autobulance_id'],]);}
        else {
            $localisation->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }
        return response()->json([
            'data' => $localisation,
        ], 200);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $staff=Auth::guard('staff')->user();
        $isOwn =TransactionReparateur::where('staff_id',$staff['id'])->where('autobulance_id',$id)->where('detached_at',null)->first();
        if ($isOwn){
            $localisation = Localisation::where('autobulance_id',$id)->first();
        if (!$localisation){
            return $this->error('', ' not found  autobulance', 404);
        }
        else {
            return response()->json([
                'data' => $localisation,
            ], 200);
    
        }
        
    }
    else {
        return $this->error('', ' not found autobulance', 401);
    }}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localisation $localisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocalisationRequest $request, Localisation $localisation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localisation $localisation)
    {
        //
    }
}
