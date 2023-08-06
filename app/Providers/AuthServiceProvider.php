<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use App\Policies\CategoryPolicy;
use App\Policies\DataEntryPolicy;
use App\Policies\FinancialPolicy;
use App\Policies\ItemPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class =>CategoryPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Item::class => ItemPolicy::class,
        User::class => DataEntryPolicy::class,
        User::class => FinancialPolicy::class,



    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}
