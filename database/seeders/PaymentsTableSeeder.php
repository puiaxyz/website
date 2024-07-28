<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'user_id' => 2, // Assuming the ID of the student user is 2
            'amount' => 100.00,
            'status' => 'due',
            'transaction_id' => null,
            'order_id' => null,
            'signature' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
