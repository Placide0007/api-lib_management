<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'message' => 'Loans loaded',
            'loans' => LoanResource::collection($loans)
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
        ],201);
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
        ],200);

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
        ],200);
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
        ],200);

    }
}
