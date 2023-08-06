<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // // SuperAdmin

        Permission::create(['name'=> 'Create-Role','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-Role','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-Role','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-Role','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Create-Restaurant','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-Restaurant','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-Restaurant','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-Restaurant','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Create-Category','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-Category','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-Category','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-Category','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Trashed-Restaurant','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Read-Permission','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Create-DataEntry','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-DataEntry','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-DataEntry','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-DataEntry','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Create-Financial','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-Financial','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-Financial','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-Financial','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Create-Item','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Read-items','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Update-Item','guard_name'=> 'user' ]);
        Permission::create(['name'=> 'Delete-Item','guard_name'=> 'user' ]);

        Permission::create(['name'=> 'Read-Orders','guard_name'=> 'user' ]);




    }
}
