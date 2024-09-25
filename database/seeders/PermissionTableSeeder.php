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

            [
              'group_name' => 'dashboard',
              'permissions' => [
                'dashboard',
              ]
            ],


            [
              'group_name' => 'user',
              'permissions' => [
                'user-access',
                'user-list',
                'user-create',
                'user-edit',
                'user-delete',
              ]
            ],

            [
              'group_name' => 'role',
              'permissions' => [
                 'role-access',
                 'role-list',
                 'role-create',
                 'role-edit',
                 'role-delete',
              ]
            ],


            [
              'group_name' => 'sales',
              'permissions' => [
                 'sales-access',
                 'sales-list',
                 'sales-create',
                 'sales-edit',
                 'sales-delete',
              ]
            ],

            [
              'group_name' => 'purchase',
              'permissions' => [
                 'purchase-access',
                 'purchase-list',
                 'purchase-create',
                 'purchase-edit',
                 'purchase-delete',
              ]
            ],

            [
              'group_name' => 'stock',
              'permissions' => [
                 'stock-access',
              ]
            ],

            [
              'group_name' => 'return',
              'permissions' => [
                 'return-access',
              ]
            ],


            [
              'group_name' => 'damage',
              'permissions' => [
                 'damage-access',
                 'damage-list',
                 'damage-create',
                 'damage-edit',
                 'damage-delete',
              ]
            ],

            [
              'group_name' => 'customer',
              'permissions' => [
                 'customer-access',
                 'customer-list',
                 'customer-create',
                 'customer-edit',
                 'customer-delete',
              ]
            ],

            [
              'group_name' => 'customer-group',
              'permissions' => [
                 'customer-group-access',
                 'customer-group-list',
                 'customer-group-create',
                 'customer-group-edit',
                 'customer-group-delete',
              ]
            ],

            [
              'group_name' => 'supplier',
              'permissions' => [
                 'supplier-access',
                 'supplier-list',
                 'supplier-create',
                 'supplier-edit',
                 'supplier-delete',
              ]
            ],

            [
              'group_name' => 'category',
              'permissions' => [
                 'category-access',
                 'category-list',
                 'category-create',
                 'category-edit',
                 'category-delete',
              ]
            ],

            [
              'group_name' => 'brand',
              'permissions' => [
                 'brand-access',
                 'brand-list',
                 'brand-create',
                 'brand-edit',
                 'brand-delete',
              ]
            ],


            [
              'group_name' => 'unit',
              'permissions' => [
                 'unit-access',
                 'unit-list',
                 'unit-create',
                 'unit-edit',
                 'unit-delete',
              ]
            ],

            [
              'group_name' => 'product',
              'permissions' => [
                 'product-access',
                 'product-list',
                 'product-create',
                 'product-edit',
                 'product-delete',
              ]
            ],


            [
              'group_name' => 'expense',
              'permissions' => [
                 'expense-access',
                 'expense-list',
                 'expense-create',
                 'expense-edit',
                 'expense-delete',
              ]
            ],

            [
              'group_name' => 'expense-category',
              'permissions' => [
                 'expense-category-access',
                 'expense-category-list',
                 'expense-category-create',
                 'expense-category-edit',
                 'expense-category-delete',
              ]
            ],


            [
              'group_name' => 'sales-report',
              'permissions' => [
                 'sales-report-access',
                 'sale-todays-report-access',
                 'sale-weekend-report-access',
                 'sale-month-report-access',
                 'sale-daily-report-access',
                 'sale-monthly-report-access',
                 'sale-between-report-access',
              ]
            ],


            [
              'group_name' => 'purchase-report',
              'permissions' => [
                 'purchases-report-access',
                 'purchase-todays-report-access',
                 'purchase-weekend-report-access',
                 'purchase-month-report-access',
                 'purchase-daily-report-access',
                 'purchase-monthly-report-access',
                 'purchase-between-report-access',
              ]
            ],


            [
              'group_name' => 'settings',
              'permissions' => [
                 'company-profile-access',
              ]
            ],

        ];


         // Create Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
            }
        }

    }
}
