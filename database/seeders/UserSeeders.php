<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Truncate();
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('Angelos31'),
            'photo' => 'avatar.png',
            'phone' => '+905063786080'

        ]);

        User::create([
            'name' => 'System User',
            'email' => 'user@user.com',
            'password' => Hash::make('Angelos31'),
            'photo' => 'avatar2.png',
            'phone' => '+905063786080'

        ]);
    }
}
