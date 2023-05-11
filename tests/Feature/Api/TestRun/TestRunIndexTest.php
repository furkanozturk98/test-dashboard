<?php

use App\Http\Resources\TestRunResource;
use App\Models\TestRun;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/test-runs')
        ->assertUnauthorized()
);

it('returns all test runs', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-runs')
        ->assertOk()
        ->assertJsonFragment([
            (new TestRunResource($testRun))->jsonSerialize(),
        ]);
});
