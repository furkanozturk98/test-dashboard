<?php

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/test-run-details/1')
        ->assertUnauthorized()
);

it(
    'returns error if test run not found',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-run-details/test')
        ->assertNotFound()
);

it('returns test run details', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    /** @var TestRunDetail $testRunDetails */
    $testRunDetails = TestRunDetail::factory()->make();

    $testRun->details()->create($testRunDetails->toArray());

    return $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-run-details/' . $testRun->id)
        ->assertOk()
        ->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
});
