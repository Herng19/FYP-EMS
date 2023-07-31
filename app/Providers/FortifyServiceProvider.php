<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if(request()->role == 'lecturer') {
            config()->set('fortify.guard', 'web');
            config()->set('fortify.passwords', 'lecturers');
            config()->set('default.guard', 'web');
        }
        else if(request()->role == 'student') {
            config()->set('fortify.guard', 'student');
            config()->set('default.guard', 'student');
        }       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

                
        Fortify::authenticateUsing(function (Request $request) {
            if($request->role == 'lecturer') {
                $user = Lecturer::where('email', $request->email)->first();
            }
            else if($request->role == 'student') {
                $user = Student::where('email', $request->email)->first(); 
            }
    
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }

        });
    }
}
