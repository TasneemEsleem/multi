<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(CartReposotories::class, function () {
        //     new CartReposotories();
        // });
            $this->app->bind('cart_id' , function(){
                $cookie_id = Cookie::get('cart_cookie_id');
                if (!$cookie_id) {
                    $cookie_id =  Str::uuid();
                    Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 60);
                }
                return $cookie_id;
            });

            $this->app->bind('cart', function ($app) {

                $cart = Cart::where('cookie_id', $app->make('cart_id'))->get();
                return $cart;
            });

            $this->app->bind('delete_cart', function ($app) {

                $cart = Cart::where('cookie_id', $app->make('cart_id'))->delete();
                return $cart;
            });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
