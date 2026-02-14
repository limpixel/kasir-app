<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the customer user with email "customer@gmail.com"
        $customer = User::where('email', 'customer@gmail.com')->first();

        if ($customer) {
            // Update the customer's profile information
            $customer->update([
                'name' => 'Valued Customer',
                'avatar' => 'avatars/customer-avatar.png', // Specific avatar for customer account
            ]);

            $this->command->info('Customer profile for "customer@gmail.com" updated successfully!');
            $this->command->info('Name: ' . $customer->name);
            $this->command->info('Email: ' . $customer->email);
            $this->command->info('Avatar: ' . $customer->avatar);
        } else {
            $this->command->error('Customer with email "customer@gmail.com" not found.');
        }
    }
}