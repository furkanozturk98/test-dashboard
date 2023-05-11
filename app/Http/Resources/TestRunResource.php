<?php

namespace App\Http\Resources;

use App\Models\TestRun;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TestRun
 */
class TestRunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'file'       => $this->file,
            'tests'      => $this->tests,
            'assertions' => $this->assertions,
            'time'       => $this->time,
            'created_by' => $this->user->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
