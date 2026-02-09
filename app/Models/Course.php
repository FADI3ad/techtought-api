<?php

namespace App\Models;
use App\Models\Course;
use Illuminate\Concurrency\ConcurrencyServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    /**
     * Get the user that owns the phone.
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}