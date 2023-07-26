<?php

namespace App\Providers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
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
        
        $this->configurePermissions();
        
        Jetstream::deleteUsersUsing(DeleteUser::class);
        
        // Fortify::authenticateUsing(function (Request $request) {
        //     $user = Lecturer::where('email', $request->email)->first();
    
        //     if ($user &&
        //         Hash::check($request->password, $user->password)) {
        //         return $user;
        //     }
        // });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
