<?php

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\Models\User;

beforeEach(
    fn() => $this
        ->actingAs(User::factory()
        ->create())
);

it(
    'shows dashboard',
    fn() => $this
        ->get('/')
        ->assertOk()
        ->assertViewIs('index')
);

it(
    'shows test run list',
    fn() => $this
        ->get(route('list'))
        ->assertOk()
        ->assertViewIs('list')
);

it(
    'shows error if test run not found',
    fn() => $this
        ->get(route('details', 'test'))
        ->assertNotFound()
);

it(
    'shows details',
    function() {
        /** @var TestRun $testRun */
        $testRun = TestRun::factory()->create();

        TestRunDetail::factory()->count(20)->create([
            'test_run_id' => $testRun->id,
        ]);

        return $this
            ->get(route('details', $testRun))
            ->assertOk()
            ->assertViewIs('details')
            ->assertViewHas('testRun', $testRun)
            ->assertSeeText($testRun->created_at->toDateString());
    }
);
