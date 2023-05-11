<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TestRun
 *
 * @property int $id
 * @property string|null $file
 * @property int $tests
 * @property int $assertions
 * @property float $time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|TestRun newModelQuery()
 * @method static Builder|TestRun newQuery()
 * @method static Builder|TestRun query()
 * @method static Builder|TestRun whereAssertions($value)
 * @method static Builder|TestRun whereCreatedAt($value)
 * @method static Builder|TestRun whereFile($value)
 * @method static Builder|TestRun whereId($value)
 * @method static Builder|TestRun whereTests($value)
 * @method static Builder|TestRun whereTime($value)
 * @method static Builder|TestRun whereUpdatedAt($value)
 * @mixin Eloquent
 *
 * @property string|null $title
 * @property int $created_by
 *
 * @method static Builder|TestRun whereCreatedBy($value)
 * @method static Builder|TestRun whereTitle($value)
 *
 * @property-read Collection|TestRunDetail[] $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User $user
 */
class TestRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'tests',
        'assertions',
        'time',
        'created_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'time'       => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return HasMany
     */
    public function details()
    {
        return $this->hasMany(TestRunDetail::class, 'test_run_id');
    }
}
