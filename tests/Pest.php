<?php

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(Tests\TestCase::class)->in('Feature');

uses(RefreshDatabase::class);

/** @phpstan-ignore-next-line */
function faker(string $locale = null): \Faker\Generator
{
    return Factory::create($locale ?? Factory::DEFAULT_LOCALE);
}
