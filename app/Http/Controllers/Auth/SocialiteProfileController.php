<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

use App\Models\User;
use App\Models\SocialiteProfile;

use App\Helper\UiAvatar;

class SocialiteProfileController extends Controller
{
    private $providers = ['github', 'google', 'facebook'];

    public function login($provider) {
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->redirect();
        }

        return view('auth.login');
    }

    public function callback(Request $request, $provider) {
        if (!$request->has('code') || $request->has('denied')) {
            return view('auth.login');
        }
        
        $userSocialite = Socialite::driver($provider)->user();
        
        if ($userSocialite) {
            $user = User::with('socialiteProfiles')->whereEmail($userSocialite->getEmail())->first();
            
            if (!$user) {
                $avatarUrl = UiAvatar::avatar($userSocialite->getName());

                $user = User::create([
                    'name' => $userSocialite->getName(),
                    'email' => $userSocialite->getEmail(),
                    'photo' => $avatarUrl
                ]);

                $user->assignRole('client');
            }

            $socialiteProfile = SocialiteProfile::whereUserIdAndProvider($user->id, $provider)->first();

            if (!$socialiteProfile) {
                SocialiteProfile::create([
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_id' => $userSocialite->getId()
                ]);
            }

            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME);
        } else {
            return view('auth.login');
        }
    }
}
