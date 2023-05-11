<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it(
    'requires authentication',
    fn() => $this->postJson('/api/test-runs')
        ->assertUnauthorized()
);

it(
    'requires file',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->postJson('/api/test-runs/')
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'file' => trans('validation.required', ['attribute' => 'file']),
        ])
);

it(
    'validates file mime',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->postJson('/api/test-runs', [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'file' => trans('validation.mimes', ['attribute' => 'file', 'values' => 'xml']),
        ])
);

it(
    'validates file size',
    fn() => $this->actingAs(User::factory()->create(), 'api')
        ->postJson('/api/test-runs', [
            'file' => UploadedFile::fake()->create('test.xml')->size(4069),
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'file' => trans('validation.max.file', ['attribute' => 'file', 'max' => '2048']),
        ])
);

it('uploads file', function() {
    Storage::fake();

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson('/api/test-runs', [
            'title' => 'test',
            'file'  => UploadedFile::fake()
                ->createWithContent(
                    'test.xml',
                    '<?xml version="1.0" encoding="UTF-8"?>
<testsuites>
  <testsuite name="" tests="4" assertions="25" failures="0" skipped="0" errors="0" time="0.83513">
    <testsuite name="Tests\Unit\Console\Commands\ApiTokenHashCommandTest" tests="4" assertions="25" failures="0" errors="0" time="0.417565" file="/tests/Unit/Console/Commands/ApiTokenHashCommandTest.php">
      <testcase name="it_hashes_api_tokens" class="Tests\Unit\Console\Commands\ApiTokenHashCommandTest" file="/tests/Unit/Console/Commands/ApiTokenHashCommandTest.php" line="22" assertions="6" time="0.175430"/>
      <testcase name="it_does_not_hash_tokens_if_they_already_hashed" class="Tests\Unit\Console\Commands\ApiTokenHashCommandTest" file="/tests/Unit/Console/Commands/ApiTokenHashCommandTest.php" line="49" assertions="5" time="0.103886"/>
      <testcase name="it_does_not_let_second_run" class="Tests\Unit\Console\Commands\ApiTokenHashCommandTest" file="/tests/Unit/Console/Commands/ApiTokenHashCommandTest.php" line="72" assertions="9" time="0.043540"/>
      <testcase name="it_does_not_executed_when_user_not_confirm" class="Tests\Unit\Console\Commands\ApiTokenHashCommandTest" file="/tests/Unit/Console/Commands/ApiTokenHashCommandTest.php" line="104" assertions="5" time="0.094709">
        <error message="Error message" type=""/>
        <failure message="Failure message" type=""/>
      </testcase>
    </testsuite>
  </testsuite>
</testsuites>'
                ),
        ])
        ->assertCreated();

    $this->assertDatabaseHas('test_runs', [
        'title'      => 'test',
        'tests'      => 4,
        'assertions' => 25,
        'time'       => 0.84,
        'created_by' => $user->id,
    ]);
});

it('uploads file when file is browser test report', function() {
    Storage::fake();

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson('/api/test-runs', [
            'title' => 'test',
            'file'  => UploadedFile::fake()
                ->createWithContent(
                    'test.xml',
                    '<?xml version="1.0" encoding="UTF-8"?>
<testsuites>
  <testsuite name="" tests="44" assertions="92" errors="0" warnings="0" failures="0" skipped="0" time="112.111680">
    <testsuite name="Browser Test Suite" tests="44" assertions="92" errors="0" warnings="0" failures="0" skipped="0" time="112.111680">
      <testsuite name="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" tests="11" assertions="26" errors="0" warnings="0" failures="0" skipped="0" time="31.789875">
        <testcase name="can_insert_files_button" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="23" assertions="2" time="3.570791"/>
        <testcase name="can_insert_publish_button_open_modal_and_cancel_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="57" assertions="2" time="2.668627"/>
        <testcase name="can_insert_publish_button_open_modal_and_publish_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="92" assertions="3" time="2.676178"/>
        <testcase name="can_insert_delete_button_open_modal_and_cancel_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="132" assertions="2" time="2.131705"/>
        <testcase name="can_insert_delete_button_open_modal_and_delete_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="170" assertions="3" time="2.280281"/>
        <testcase name="can_insert_delete_button_open_modal_and_dont_delete_test_in_edit_page" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="211" assertions="2" time="2.758414"/>
        <testcase name="can_insert_delete_button_open_modal_and_delete_test_in_edit_page" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="247" assertions="3" time="3.208295"/>
        <testcase name="can_insert_share_button_share_modal_close_test_edit_page" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="286" assertions="2" time="2.857532"/>
        <testcase name="can_insert_duplicate_button_grid_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="320" assertions="2" time="2.801610"/>
        <testcase name="can_insert_duplicate_button_edit_page_test" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="353" assertions="2" time="3.639021"/>
        <testcase name="can_insert_cancel_button_in_edit_page" class="Tests\Browser\SplashPageTests\SplashPageAddTests\SplashPagesAddTest" classname="Tests.Browser.SplashPageTests.SplashPageAddTests.SplashPagesAddTest" file="/home/kerim/Sites/wifi/tests/Browser/SplashPageTests/SplashPageAddTests/SplashPagesAddTest.php" line="386" assertions="3" time="3.197419"/>
      </testsuite>
    </testsuite>
  </testsuite>
</testsuites>'
                ),
        ])
        ->assertCreated();

    $this->assertDatabaseHas('test_runs', [
        'title'      => 'test',
        'tests'      => 44,
        'assertions' => 92,
        'time'       => 112.11,
        'created_by' => $user->id,
    ]);
});
