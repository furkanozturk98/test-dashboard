<?php

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\Models\User;

it(
    'requires authentication',
    fn() => $this->getJson('/api/test-run-statuses')
        ->assertUnauthorized()
);

it('returns statuses of test runs', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    TestRunDetail::factory()->count(20)->create([
        'test_run_id' => $testRun->id,
    ]);

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-run-statuses')
        ->assertOk();
});

it('returns statuses of a particular test run', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    TestRunDetail::factory()->count(20)->create([
        'test_run_id' => $testRun->id,
    ]);

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-run-statuses?test_run_id=' . $testRun->id)
        ->assertOk();
});

it('returns statuses of test runs by given range', function() {
    /** @var TestRun $testRun */
    $testRun = TestRun::factory()->create();

    TestRunDetail::factory()->count(20)->create([
        'test_run_id' => $testRun->id,
    ]);

    $this->actingAs(User::factory()->create(), 'api')
        ->getJson('/api/test-run-statuses?from=' . $testRun->id . '&to=' . $testRun->id)
        ->assertOk();
});
