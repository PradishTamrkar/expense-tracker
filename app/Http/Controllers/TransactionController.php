<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all /api/transactions
     */
    public function index()
    {
        $transaction = Transaction::with('category')->get(); //to include category data

        return TransactionResource::collection($transaction);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/transactions
     */
    public function store(StoreTransactionRequest $request)
    {
        try{
            $validated = $request->validate();

            $transaction = Transaction::create($validated);

            $transaction->load('category');

            return response()->json([
                'success'=>true,
                'message'=>'Transaction created successfully',
                'data'=>$transaction
            ],201);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'success'=>false,
                'message'=>'Validation failed',
                'errors'=>$e->errors()
            ],422);
        }
        catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Error creating transaction',
                'errors'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     * get /api/transaction/{id}
     */
    public function show(string $id)
    {
        $transaction = Transaction::with('category')->find($id);
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Transaction retrieved successfully',
            'data' => $transaction
        ]);
    }


    /**
    * Update the specified resource in storage.
    * put /api/transactions/{id}
    */
    public function update(UpdateTransactionRequest $request, string $id)
    {
        $transaction = Transaction::find($id);
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
        
        try {
            $validated = $request->validate();
            
            $transaction->update($validated);
            $transaction->load('category');
            
            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully',
                'data' => $transaction
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * Delete /api/transaction/{id}
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
        
        try {
            $transaction->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
