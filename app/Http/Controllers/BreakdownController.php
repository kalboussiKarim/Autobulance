<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use App\Http\Requests\StoreBreakdownRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

class BreakdownController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breakdowns = Breakdown::all();
        return $this->success([
            'breakdowns' => $breakdowns,
        ]);
    }

    public function search($url)
    {
        return Breakdown::where("breakdown", "like", "%" . $url . "%")->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBreakdownRequest $request)
    {
        $request->validated($request->all());
        $breakdown = Breakdown::create([
            'breakdown' => $request->breakdown,
            'solution' => $request->solution,
            'description' => $request->description,
        ]);
        return $this->success([
            '$breakdown' => $breakdown,
        ], "breakdown stored successfully");
    }

    /**
     * Display the specified resource.
     */

    public function show($breakdown_id)
    {
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'the breakdown you want to see is not found', 401);
        }
        return $this->success([
            'request' => $breakdown,
        ], "Request found successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreBreakdownRequest $request, $breakdown_id)
    {
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'the breakdown you want to edit is not found', 401);
        }
        $new_data = $request->validated();
        $breakdown->update($new_data);
        return $this->success([
            'breakdown' => $breakdown,
        ], "breakdown modified successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($breakdown_id)
    {
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'the breakdown you want to delete is not found', 401);
        }
        $breakdown->delete();
        return $this->success([], "Breakdown deleted successfully");
    }



    public function avg()
    {

        $total =  DB::table('breakdown_requests')
            ->select(DB::raw('COUNT(breakdown_requests.id)  AS  nb '))
            ->pluck('nb')
            ->first();

        $averages = DB::table('breakdown_requests')
            ->join('breakdowns', 'breakdown_requests.breakdown_id', '=', 'breakdowns.id')
            ->select('breakdowns.breakdown', DB::raw('COUNT(breakdown_requests.request_id)  /' . $total . ' * 100 as average'))
            ->groupBy('breakdowns.breakdown')
            ->get();

        return response()->json($averages);
    }
}
