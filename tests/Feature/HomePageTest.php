<?php

use App\Models\User;

it(
    'it requires authentication',
    fn() => $this->get('/')
        ->assertRedirect(route('login'))
);


it(
    'it shows home page',
    fn() => $this->actingAs(User::factory()->create())
        ->get('/')
        ->assertOk()
);
