<?php
namespace Database\Seeders;

use App\Models\Master\Branch;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Master\Category;
use App\Models\Master\Role;
// use App\Models\User;
use App\Models\Master\SubCategory;
use App\Models\Master\UnitMeasure;
use App\Models\Master\Warehouse;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleArray = [
            ['role_name' => 'Superadmin', 'status' => '1'],
        ];
        Role::create($roleArray);

        $userArray = [
            ['name' => 'superadmin', 'email' => 'superadmin@mail.com', 'password' => bcrypt('adminsuper123'), 'role_id' => '1', 'username' => 'superadmin'],
        ];
        User::create($userArray);

        $branchArray = [
            ['branch_name' => 'Surabaya', 'branch_code' => 'SBY'],
        ];
        Branch::create($branchArray);

        $warehouseArray = [
            ['branch_id' => '1', 'warehouse_name' => 'Pakuwon Tower', 'warehouse_code' => 'PT'],
        ];
        Warehouse::create($warehouseArray);

        $categoryArray = ['packaging'];
        Category::create($categoryArray);

        $subCategoryArray = ['food packaging', 'food container'];
        SubCategory::create($subCategoryArray);

        $unitArray = [
            ['unit_measure_name' => 'Pcs'],
        ];
        UnitMeasure::create($unitArray);
    }
}
