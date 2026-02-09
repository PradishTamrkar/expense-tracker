<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions=[
            //expense
            [
                'user_id'=>1,
                'category_id'=>1,
                'amount'=>5000.00,
                'type'=>'expense',
                'description'=>'Monthly groceries from Mart',
                'transaction_date'=>'2025-01-05',
            ],
            [
                'user_id'=>1,
                'category_id'=>2,
                'amount'=>1500.00,
                'type'=>'expense',
                'description'=>'Monthly fuel refill',
                'transaction_date'=>'2025-01-06',
            ],
            [
                'user_id'=>1,
                'category_id'=>3,
                'amount'=>12000.00,
                'type'=>'expense',
                'description'=>'Monthly rent',
                'transaction_date'=>'2025-01-01',
            ],
            [
                'user_id'=>1,
                'category_id'=>4,
                'amount'=>1200.00,
                'type'=>'expense',
                'description'=>'Internet bill',
                'transaction_date'=>'2025-01-10',
            ],
            [
                'user_id'=>1,
                'category_id'=>5,
                'amount'=>3000.00,
                'type'=>'expense',
                'description'=>'Doctor visit and medicine',
                'transaction_date'=>'2025-01-12',
            ],
            [
                'user_id'=>1,
                'category_id'=>7,
                'amount'=>800.00,
                'type'=>'expense',
                'description'=>'Movie ticket',
                'transaction_date'=>'2025-01-15',
            ],
            [
                'user_id'=>1,
                'category_id'=>8,
                'amount'=>4500.00,
                'type'=>'expense',
                'description'=>'New clothes',
                'transaction_date'=>'2025-01-20',
            ],

            //income
            [
                'user_id' => 1,
                'category_id' => 9,  // Salary
                'amount' => 45000.00,
                'type' => 'income',
                'description' => 'Monthly salary - January',
                'transaction_date' => '2025-01-01',
            ],
            [
                'user_id' => 1,
                'category_id' => 10, // Freelance
                'amount' => 15000.00,
                'type' => 'income',
                'description' => 'Freelance project payment',
                'transaction_date' => '2025-01-20',
            ],
            // User 2 transactions
            [
                'user_id' => 2,
                'category_id' => 1,  // Food
                'amount' => 3500.00,
                'type' => 'expense',
                'description' => 'Weekly groceries',
                'transaction_date' => '2025-01-08',
            ],
            [
                'user_id' => 2,
                'category_id' => 9,  // Salary
                'amount' => 35000.00,
                'type' => 'income',
                'description' => 'Monthly salary',
                'transaction_date' => '2025-01-01',
            ],
        ];

        foreach($transactions as $transaction){
            Transaction::create($transaction);
        }

        $this->command->info('Transaction seeded successfully');
    }
}
