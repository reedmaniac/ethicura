<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactorController extends Controller
{
    /**
     * Show the user's two factory setup settings page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request): Response
    {
        $this->validateTwoFactorAuthenticationState($request);

        return Inertia::render('settings/TwoFactorAuthentication', [
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }

    /**
     * Validate the two factor authentication state for the request.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    protected function validateTwoFactorAuthenticationState(Request $request)
    {
        if (! Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
            return;
        }

        $currentTime = time();

        // Notate totally disabled state in session...
        if ($this->twoFactorAuthenticationDisabled($request)) {
            $request->session()->put('two_factor_empty_at', $currentTime);
        }

        // If was previously totally disabled this session but is now confirming, notate time...
        if ($this->hasJustBegunConfirmingTwoFactorAuthentication($request)) {
            $request->session()->put('two_factor_confirming_at', $currentTime);
        }

        // If the profile is reloaded and is not confirmed but was previously in confirming state, disable...
        if ($this->neverFinishedConfirmingTwoFactorAuthentication($request, $currentTime)) {
            app(DisableTwoFactorAuthentication::class)(Auth::user());

            $request->session()->put('two_factor_empty_at', $currentTime);
            $request->session()->remove('two_factor_confirming_at');
        }
    }

    /**
     * Determine if two factor authenticatoin is totally disabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function twoFactorAuthenticationDisabled(Request $request)
    {
        return is_null($request->user()->two_factor_secret) &&
            is_null($request->user()->two_factor_confirmed_at);
    }

    /**
     * Determine if two factor authentication is just now being confirmed within the last request cycle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasJustBegunConfirmingTwoFactorAuthentication(Request $request)
    {
        return ! is_null($request->user()->two_factor_secret) &&
            is_null($request->user()->two_factor_confirmed_at) &&
            $request->session()->has('two_factor_empty_at') &&
            is_null($request->session()->get('two_factor_confirming_at'));
    }

    /**
     * Determine if two factor authentication was never totally confirmed once confirmation started.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $currentTime
     * @return bool
     */
    protected function neverFinishedConfirmingTwoFactorAuthentication(Request $request, $currentTime)
    {
        return ! array_key_exists('code', $request->session()->getOldInput()) &&
            is_null($request->user()->two_factor_confirmed_at) &&
            $request->session()->get('two_factor_confirming_at', 0) !== $currentTime;
    }
}
