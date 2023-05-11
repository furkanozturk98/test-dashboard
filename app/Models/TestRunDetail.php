<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TestRunDetail
 *
 * @property int $id
 * @property int $test_run_id
 * @property int $status
 * @property string $file
 * @property string $method
 * @property string $time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|TestRunDetail newModelQuery()
 * @method static Builder|TestRunDetail newQuery()
 * @method static Builder|TestRunDetail query()
 * @method static Builder|TestRunDetail whereCreatedAt($value)
 * @method static Builder|TestRunDetail whereFile($value)
 * @method static Builder|TestRunDetail whereId($value)
 * @method static Builder|TestRunDetail whereMethod($value)
 * @method static Builder|TestRunDetail whereStatus($value)
 * @method static Builder|TestRunDetail whereTestRunId($value)
 * @method static Builder|TestRunDetail whereTime($value)
 * @method static Builder|TestRunDetail whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TestRunDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
