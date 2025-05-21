<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator; // Tambahkan baris ini


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // Tambahkan baris ini

        // Mendaftarkan aturan validasi kustom
        Validator::extend('allowed_domain', function ($attribute, $value, $parameters, $validator) {
            $allowedDomains = ['example.com', 'example.net', 'example.org', 'gmail.com', 'yahoo.com']; // Daftar domain yang diizinkan

            $domain = substr(strrchr($value, "@"), 1); // Ambil domain dari email
            return in_array($domain, $allowedDomains);
        });

        Validator::replacer('allowed_domain', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be an email address with an allowed domain.');
        });
    }
}