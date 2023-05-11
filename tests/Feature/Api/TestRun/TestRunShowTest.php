<?php

use App\Http\Resources\TestRunResource;
use App\Models\TestRun;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/test-runs/1')
        ->assertUnauthorized()
);

it('returns details', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-runs/' . $testRun->id)
        ->assertOk()
        ->assertExactJson([
            'data' => (new TestRunResource($testRun))->jsonSerialize(),
        ]);
});
