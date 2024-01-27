<?php

namespace App\Providers;

use App\Filament\MyLogoutResponse;
use App\Livewire\DaftarTa;
use App\Livewire\DaftarBaru;
use App\Livewire\StatusPendaftaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

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
        $this->app->bind(LogoutResponseContract::class, MyLogoutResponse::class);

        Livewire::component('daftarta', DaftarTa::class);
        Livewire::component('daftarbaru', DaftarBaru::class);
        Livewire::component('statuspendaftaran', StatusPendaftaran::class);
        Model::unguard();
    }
}
