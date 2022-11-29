<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'discount',
           'policy',
           
           'bookings',
           'rooms',
           'rates',
           'packages',
           'activities',
           'services',
           'badges',
           'flat-rate',
           'facilities',
           'customers',
           'email-management',
           'roles',
           'site-settings',
           'payment-methods'

        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}