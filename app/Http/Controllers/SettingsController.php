<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function show(): View
    {
        return view('pages.menu', [
            'user' => $this->currentUser(),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $this->currentUser();

        $validated = $request->validateWithBag('passwordUpdate', [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Entre le mot de passe actuel.',
            'password.required' => 'Entre un nouveau mot de passe.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caracteres.',
            'password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return $this->redirectTo('password-form')
                ->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.',
                ], 'passwordUpdate');
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return $this->redirectTo('password-form')
            ->with('password_status', 'Mot de passe mis a jour avec succes.');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $user = $this->currentUser();

        $validated = $request->validateWithBag('passwordReset', [
            'reset_email' => ['required', 'email'],
            'reset_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'reset_email.required' => 'Entre l email du compte.',
            'reset_email.email' => 'Entre une adresse email valide.',
            'reset_password.required' => 'Entre un nouveau mot de passe.',
            'reset_password.min' => 'Le mot de passe doit contenir au moins 8 caracteres.',
            'reset_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (strcasecmp($validated['reset_email'], $user->email) !== 0) {
            return $this->redirectTo('reset-form')
                ->withErrors([
                    'reset_email' => 'Cet email ne correspond pas au compte local actif.',
                ], 'passwordReset')
                ->withInput($request->except(['reset_password', 'reset_password_confirmation']));
        }

        $user->update([
            'password' => $validated['reset_password'],
        ]);

        return $this->redirectTo('reset-form')
            ->with('reset_status', 'Mot de passe reinitialise. Tu peux maintenant utiliser le nouveau mot de passe.');
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $user = $this->currentUser();

        $validated = $request->validateWithBag('emailUpdate', [
            'new_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ], [
            'new_email.required' => 'Entre une adresse email.',
            'new_email.email' => 'Entre une adresse email valide.',
            'new_email.unique' => 'Cet email est deja utilise.',
        ]);

        $user->update([
            'email' => $validated['new_email'],
        ]);

        return $this->redirectTo('email-form')
            ->with('email_status', 'Adresse email mise a jour.');
    }

    public function updateAddress(Request $request): RedirectResponse
    {
        $user = $this->currentUser();

        $validated = $request->validateWithBag('addressUpdate', [
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'address.max' => 'L adresse est trop longue.',
        ]);

        $user->update([
            'address' => $validated['address'],
        ]);

        return $this->redirectTo('address-form')
            ->with('address_status', 'Adresse mise a jour.');
    }

    public function updatePhone(Request $request): RedirectResponse
    {
        $user = $this->currentUser();

        $validated = $request->validateWithBag('phoneUpdate', [
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+().\-\s]+$/'],
        ], [
            'phone.max' => 'Le numero est trop long.',
            'phone.regex' => 'Utilise seulement des chiffres et les symboles + ( ) . -',
        ]);

        $user->update([
            'phone' => $validated['phone'],
        ]);

        return $this->redirectTo('phone-form')
            ->with('phone_status', 'Numero de telephone mis a jour.');
    }

    private function currentUser(): User
    {
        return User::query()->oldest('id')->first() ?? User::query()->create([
            'name' => 'Compte Kairos',
            'email' => 'compte@kairos.local',
            'password' => Hash::make(Str::random(24)),
            'address' => null,
            'phone' => null,
        ]);
    }

    private function redirectTo(string $fragment): RedirectResponse
    {
        return redirect()->to(route('settings.index').'#'.$fragment);
    }
}
