<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Sprint
 * @package App\Models
 * @author pimen@doogether.id
 *
 * @method static find(int $int)
 */

class Sprint extends Model
{
    use HasFactory;

    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
