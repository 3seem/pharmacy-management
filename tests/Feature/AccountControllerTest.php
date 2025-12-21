<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AccountControllerTest extends TestCase
{
    public function test_user_can_update_profile()
    {
        $user = User::first(); 

        $response = $this->actingAs($user)
                         ->put(route('account.update'), [
                             'name'    => 'Ahmed Test',
                             'email'   => 'ahmedtest@example.com',
                             'Phone'   => '0123456789',
                             'Address' => 'Cairo, Egypt',
                         ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Profile updated successfully');
    }
}
