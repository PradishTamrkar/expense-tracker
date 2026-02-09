<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    //Get dashboard stats get/api/stats

    public function index(Request $request){
        $user = $request->user();

        //total income
        $totalIncome = Transaction::where('user_id',$user->id)
                    -> where('type','income')
                    -> sum('amount');

        //total expense
        $totalExpense = Transaction::where('user_id',$user->id)
                     -> where('type','expense')
                     -> sum('amount');
        
        //balance
        $balance = $totalIncome - $totalExpense;

        //Transaction count
        $transactionCount = Transaction::where('user_id',$user->id)->count();

        //This month's income
        $monthlyIncome = Transaction::where('user_id',$user->id)
                      -> where('type','income')
                      -> whereYear('transaction_date',now()->year)
                      -> whereMonth('transaction_date',now()->month)
                      -> sum('amount');

        //This month's expense
        $monthlyExpenses = Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereYear('transaction_date', now()->year)
                        ->whereMonth('transaction_date', now()->month)
                        ->sum('amount');
        
        //category wise expense
        $expensesByCategory = Transaction::where('user_id',$user->id)
                           -> where('type','expense')
                           -> select('category_id', DB::raw('SUM(amount) as total'))
                           -> with('category:category_id,name,color,icon')
                           -> groupBy('category_id')
                           -> orderBy('total','desc')
                           -> limit(5)
                           -> get();

        //Recent Transaction
        $recentTransactions = Transaction::where('user_id',$user->id)
                           -> with('category:category_id,name,color,icon')
                           -> orderBy ('transaction_date','desc')
                           -> orderBy ('created_at','desc')
                           -> limit(5)
                           -> get();

        return response()->json([
            'success'=>true,
            'data'=>[
                'summary' => [
                    'total_income' => number_format($totalIncome, 2),
                    'total_expense' => number_format($totalExpense, 2),
                    'balance' => number_format($balance, 2),
                    'transaction_count' => $transactionCount,
                ],
                'monthly' => [
                    'income' => number_format($monthlyIncome, 2),
                    'expense' => number_format($monthlyExpenses, 2),
                    'balance' => number_format($monthlyIncome - $monthlyExpenses, 2)
                ],
                'top_categories' => $expensesByCategory,
                'recent_transactions' => $recentTransactions,
            ]
        ]);
    }

    //get monthly summary of the year /api/stats/monthly?year=2025
    public function monthly(Request $request)
    {
        $user = $request->user();
        $year = $request->get('year', now()->year);

        $monthlyData=[];

        for($month = 1; $month <= 12; $month++){
             $income = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $month)
                ->sum('amount');
            
            $expenses = Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $month)
                ->sum('amount');
            
            $monthlyData[] = [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
                'income' => number_format($income, 2),
                'expenses' => number_format($expenses, 2),
                'balance' => number_format($income - $expenses, 2),
            ];
        }

        return response()->json([
            'success' => true,
            'year' => $year,
            'data' => $monthlyData
        ]);
    }
}
