<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', auth()->id())->with('book')->get();

        return response()->json([
            'message' => 'Reservations loaded',
            'reservations' => ReservationResource::collection($reservations)
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        $fields = $request->validated();

        $fields['user_id'] = auth()->id();

        $fields['reserved_at'] = $fields['reserved_at'] ?? now();

        $fields['status'] = $fields['status'] ?? 'pending';

        $reservation = Reservation::create($fields);

        $reservation->load('book');

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => new ReservationResource($reservation)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        return response()->json([
            'message' => 'Reservation fetched successfully',
            'reservation' => ReservationResource::make($reservation)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $fields = $request->validated();

        $reservation->update($fields);

        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => ReservationResource::make($reservation)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully ',
        ], 200);
    }
}
