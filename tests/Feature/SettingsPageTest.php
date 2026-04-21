<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_page_creates_a_local_account_when_none_exists(): void
    {
        $response = $this->get('/menu');

        $response->assertOk();
        $response->assertSee('Parametres du compte');
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'compte@kairos.local',
        ]);
    }

    public function test_security_and_profile_forms_update_the_local_account(): void
    {
        $this->get('/menu');

        $user = User::query()->firstOrFail();

        $this->patch('/menu/password/reset', [
            'reset_email' => 'compte@kairos.local',
            'reset_password' => 'NouveauPass123',
            'reset_password_confirmation' => 'NouveauPass123',
        ])->assertRedirect('/menu#reset-form');

        $user->refresh();
        $this->assertTrue(Hash::check('NouveauPass123', $user->password));

        $this->patch('/menu/password', [
            'current_password' => 'NouveauPass123',
            'password' => 'EncorePlusFort123',
            'password_confirmation' => 'EncorePlusFort123',
        ])->assertRedirect('/menu#password-form');

        $this->patch('/menu/profile/email', [
            'new_email' => 'nouveau@kairos.test',
        ])->assertRedirect('/menu#email-form');

        $this->patch('/menu/profile/address', [
            'address' => 'Dakar, Medina, Rue 14, Villa 23',
        ])->assertRedirect('/menu#address-form');

        $this->patch('/menu/profile/phone', [
            'phone' => '+221 77 000 00 00',
        ])->assertRedirect('/menu#phone-form');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'nouveau@kairos.test',
            'address' => 'Dakar, Medina, Rue 14, Villa 23',
            'phone' => '+221 77 000 00 00',
        ]);

        $this->assertTrue(Hash::check('EncorePlusFort123', $user->fresh()->password));
    }
}
