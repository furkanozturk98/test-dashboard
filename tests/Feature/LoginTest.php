<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

it(
    'shows login page',
    fn() => $this->get(route('login'))
        ->assertOk()
        ->assertViewIs('auth.login')
);

it(
    'validates login request',
    fn() => $this->post(route('login'))
        ->assertRedirect()
        ->assertSessionHasErrors([
            'email'    => trans('validation.required', ['attribute' => 'email']),
            'password' => trans('validation.required', ['attribute' => 'password']),
        ])
);

it(
    'requires email to be string in login request',
    fn() => $this->post(route('login'), [
        'email' => 1,
    ])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'email' => trans('validation.string', ['attribute' => 'email']),
        ])
);

it(
    'requires password to be string in login request',
    fn() => $this->post(route('login'), [
        'password' => 1,
    ])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'password' => trans('validation.string', ['attribute' => 'password']),
        ])
);

it('logs in', function() {
    /** @var User $user */
    $user = User::factory()->create([
        'email'    => faker()->unique()->email,
        'password' => faker()->password,
    ]);

    $this->post(route('login'), [
        'email'    => $user->email,
        'password' => $user->password,
    ])
        ->assertRedirect('/');
});
