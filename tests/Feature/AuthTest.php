<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

it(
    'it redirects to home page if already authenticated',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->get(route('login'))
        ->assertRedirect(RouteServiceProvider::HOME)
);
