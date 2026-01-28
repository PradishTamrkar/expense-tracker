<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/status', function() {
//     return response()-> json([
//         'status'=> 'API is running',
//         'laravel_version'=>app() -> version(),
//         'timestamp'=>now()
//     ]);
// });

// Route::get('/greet/{name}', function ($name) {
//     return response() -> json([
//         'message' => "Hello, $name!"
//     ]);
// });

// Route::get('/calculate/{num1}/{num2}', function ($num1, $num2) {
//     return response()->json([
//         'num1' => (int)$num1,
//         'num2' => (int)$num2,
//         'sum' => $num1 + $num2,
//         'product' => $num1 * $num2,
//         'difference' => $num1 - $num2
//     ]);
// });

// Route::post('/echo', function(Request $request) {
//     return response() -> json(([
//         'message'=> 'Data recieved Successfully',
//         'your-data' => $request->all(),
//         'method' => $request->method() 
//     ]));
// });


//CATEGORY

// //create category - POST Method
// Route::post('/categories', function (Request $request) {

//     //validate incomming data
//     $validated = $request -> validate([
//         'name'=>'required|string|max:255',
//         'type'=>'required|in:income,expense',
//         'icon'=>'nullable|string',
//         'color'=>'nullable|string|max:7',
//         'description'=>'nullable|string' 
//     ]);

//     //Generate slug for name
//     $validated['slug']=Str::slug($validated['name']);

//     //create category
//     $categories = Category::create($validated);

//     return response() -> json([
//         'message'=> 'Category created successfully',
//         'data'=>$categories
//     ],201);
// });

// //read all category-GET all method
// Route::get('/categories', function () {
//     $categories = Category::all();

//     return response() -> json ([
//         'message'=>'Categories retrived successfully',
//         'data'=> $categories
//     ]);
// });

// //read specfic category - GET by id
// Route::get('/categories/{id}', function($id){
//     $category = Category::find($id);

//     if(!$category){
//         return response()->json([
//             'message'=>'Category not found'
//         ],404);
//     }

//     return response()->json([
//         'message'=>'Category retrived successfully',
//         'data'=>$category
//     ]);
// });

// //update category - put method
// Route::put('/categories/{id}',function(Request $request, $id){
//     $category = Category::find($id);

//     if(!$category){
//         return response()->json([
//             'message'=>'Category not found'
//         ],404);
//     }

//     $validated = $request -> validate([
//         'name'=>'sometimes|string|max:255',
//         'type'=>'sometimes|in:income,expense',
//         'icon'=>'nullable|string',
//         'color'=>'nullable|string|max:7',
//         'description'=>'nullable|string',
//         'is_active'=>'sometimes|boolean' 
//     ]);

//     if (isset($validated['name'])){
//         $validated['slug']=Str::slug($validated['name']);
//     }

//     $category->update($validated);

//     return response()->json([
//         'message'=>'Category updates successfully',
//         'data'=>$category
//     ]);
// });

// //delete category
// Route::delete('/categories/{id}', function($id){
//     $category = Category::find($id);

//     if(!$category){
//         return response()->json([
//             'message'=>'Category not found'
//         ],404);
//     }

//     $category->delete();

//     return response()->json([
//         'message'=>'Category deleted successfully'
//     ]);
// });


//TRANSACTION

// //create transaction - POST method
// Route::post('/transactions', function (Request $request){
//     try{
//         $validated = $request->validate([
//             'category_id' => 'required|exists:categories,category_id',
//             'amount' => 'required|numeric|min:0',
//             'type' => 'required|in:income,expense',
//             'description' => 'nullable|string',
//             'transaction_date' => 'required|date'
//         ]);

//         $transaction = Transaction::create($validated);

//         return response()->json([
//             'success'=>true,
//             'message'=>'Transaction created successfully',
//             'data'=>$transaction
//         ],201);
//     }catch(\Illuminate\Validation\ValidationException $e){
//         return response()->json([
//             'success'=>false,
//             'message'=>'Validation failed',
//             'errors'=>$e->errors()
//         ],422);
//     }catch(\Exception $e) {
//         return response()->json([
//             'success'=>false,
//             'message'=>'Error creating transaction',
//             'errors'=>$e->getMessage()
//         ],500);
//     }
// });

// //read all transaction-GET ALL method
// Route::get('/transactions',function(){
//     $transaction = Transaction::with('category')->get(); //to include category data

//     return response()->json([
//         'success'=>true,
//         'message'=>'Transaction retrieved successfully',
//         'data'=>$transaction,
//         'count'=>$transaction->count()
//     ]);
// });

// //read one transaction- GET BY ID method
// Route::get('/transactions/{id}', function($id){
//     $transaction = Transaction::with('category')->find($id);

//     if(!$transaction){
//         return response()->json([
//             'success'=>false,
//             'message'=>'Transaction not found'
//         ],404);
//     }

//     return response()->json([
//         'success'=>true,
//         'data'=>$transaction
//     ]);
// });

// //update transaction- PUT method
// Route::put('/transactions/{id}', function(Request $request, $id){
//     $transaction = Transaction::find($id);

//     if(!$transaction){
//         return response()->json([
//             'success'=>false,
//             'message'=>'Transaction not found'
//         ],404);
//     }

//     $validated = $request ->validate([
//         'category_id'=>'sometimes|required|exists:categories,category_id',
//         'amount'=>'sometimes|required|numeric|min:0',
//         'type'=>'sometimes|required|in:income,expense',
//         'description'=>'nullable|string',
//         'transaction_date'=>'sometimes\required|date'
//     ]);

//     $transaction->update($validated);

//     return response()->json([
//         'success'=>true,
//         'message'=>'Transaction updated successfully',
//         'data'=>$transaction
//     ]);
// });

// //delete transaction
// Route::delete('/transactions/{id}', function($id) {
//     $transaction = Transaction::find($id);

//     if(!$transaction){
//         return response()->json([
//             'success'=>false,
//             'message'=>'Transaction not found'
//         ],404);
//     }

//     $transaction->delete();

//     return response()->json([
//         'sucsess'=>true,
//         'message'=>'Transaction deleted successfully'
//     ]);
// });

//use controller:

//Routes that need no authetication
Route::post('/register', [AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//Routes that need authetication
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('transactions',TransactionController::class);
});
