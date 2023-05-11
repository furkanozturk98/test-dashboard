<?php

use App\Models\TestRunDetail;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/dashboard/history')
        ->assertUnauthorized()
);

it('returns data', function() {
    TestRunDetail::factory()->create();

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/dashboard/history')
        ->assertOk();
});
