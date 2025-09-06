<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get(); // Charge user et book

        return response()->json([
            'message' => 'Loans loaded',
            'loans' => $loans
        ], 200);
    }


    public function adminIndex()
    {
        $loans = Loan::with(['user', 'book'])->get();

        return response()->json([
            'message' => 'Loans loaded for admin',
            'loans' => $loans->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'book_title' => $loan->book->title,
                    'book_author' => $loan->book->author,
                    'name' => $loan->user->name,
                    'email' => $loan->user->email,
                    'borrowed_at' => $loan->borrowed_at,
                    'due_date' => $loan->due_date,
                    'returned_at' => $loan->returned_at,
                ];
            })
            
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {
        $fields = $request->validated();

        $loan = Loan::create($fields);

        return response()->json([
            'message' => 'loan created successfully',
            'loan' => LoanResource::make($loan)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = Loan::findOrFail($id);

        return response()->json([
            'message' => 'category fetched successfully',
            'loan' => LoanResource::make($loan)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, string $id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update($request->validated());

        return response()->json([
            'message' => 'category updated successfully',
            'loan' => LoanResource::make($loan)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);

        $loan->delete();

        return response()->json([
            'message' => 'category deleted successfully',
        ], 200);
    }

    public function borrowFromReservation($reservationId)
    {
        try {
            $reservation = Reservation::findOrFail($reservationId);

            if ($reservation->status !== 'pending') {
                return response()->json(['message' => 'Réservation déjà traitée'], 400);
            }

            $loan = Loan::create([
                'user_id' => $reservation->user_id,
                'book_id' => $reservation->book_id,
                'borrowed_at' => now(),
                'due_date' => now()->addWeeks(2),
            ]);

            $reservation->update(['status' => 'approved']);

            $loan->refresh();

            return response()->json([
                'message' => 'Livre emprunté avec succès',
                'loan' => LoanResource::make($loan)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur serveur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
