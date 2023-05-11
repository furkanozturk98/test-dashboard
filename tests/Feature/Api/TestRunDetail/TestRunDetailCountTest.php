<?php

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/test-duration-count/1')
        ->assertUnauthorized()
);

it(
    'return error if test run not found for test duration count',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-duration-count/test')
        ->assertOk()
);

it('returns test duration count data', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    TestRunDetail::factory()->count(100)->create([
        'test_run_id' => $testRun->id,
    ]);

    return $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-duration-count/' . $testRun->id)
        ->assertOk();
});
