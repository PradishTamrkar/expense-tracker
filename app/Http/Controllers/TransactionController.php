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
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Transaction::query()
              -> where('user_id',$user->id)
              -> with('category:category_id,name,slug,type,icon,color,created_at,updated_at');
        
        //Filter by type(income/expense)
        if($request -> has('type')){
            $query->where('type',$request->type);
        }

        //filter by category
        if($request -> has('category_id')){
            $query->where('category_id',$request->category_id);
        }

        //filter by date range
        if($request -> has('start_date')){
            $query->whereDate('transaction_date','>=',$request->start_date);
        }

        if($request -> has('end_date')){
            $query->whereDate('transaction_date','<=',$request->end_date);
        }

        //filter by month and year
        if($request -> has('month')){
            $query->whereMonth('transaction_date',$request->month);
        }

        if($request -> has('year')){
            $query->whereYear('transaction_date',$request->year);
        }

        // search in description
        if($request -> has('search')){
            $query->where('description','ilike','%'.$request->search.'%');
        }

        //filter by amount range
        if($request -> has('min_amount')){
            $query->where('amount','>=',$request->min_amount);
        }

        if($request -> has('max_amount')){
            $query-> where('amount','<=',$request->max_amount);
        }

        //sorting
        $sortBy = $request->get('sort_by','transaction_date');
        $sortOrder = $request->get('sort_order','desc');

        //validate sort feilds
        $allowedSortFields = ['transaction_date','amount','created_at'];
        if(in_array($sortBy, $allowedSortFields)){
            $query->orderBy($sortBy,$sortOrder);
        }

        //add secondasry sort by created_at
        if($sortBy !== 'created_at'){
            $query->orderBy('created_at','desc');
        }

        //pagination
        $perPage = $request->get('per_page',15);
        $perPage = min($perPage, 100); //max 100 per page

        $transaction = $query->paginate($perPage);

        return TransactionResource::collection($transaction);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/transactions
     */
    public function store(StoreTransactionRequest $request)
    {
        try{
            $validated = $request->validated();

            $validated['user_id'] = $request->user()->id;

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
    public function show(Request $request, string $id)
    {
        $transaction = Transaction::with('category')
                    -> where('user_id', $request->user()->id)
                    -> where('transaction_id', $id)
                    -> first();
        
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
        $transaction = Transaction::where('user_id',$request->user()->id)
                                  ->where('id',$id)
                                  ->first();
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
        
        try {
            $validated = $request->validated();
            
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
    public function destroy(Request $request, string $id)
    {
        $transaction = Transaction::where('user_id',$request->user()->id)
                                  ->where('id',$id)
                                  ->first();
        
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
