<?php

// app/Traits/UserStamps.php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CustomStamps
{
    protected static function bootCustomStamps()
    {
        static::creating(function ($model) {
            // Only stamp if a user is logged in
            if (Auth::check()) {
                $model->created_by = \auth()->id();
                $model->created_at = now();
            }
        });

        static::updating(function ($model) {
            // Only stamp if a user is logged in
            if (Auth::check()) {
                $model->updated_by = \auth()->id();
                $model->updated_at = now();
            }
        });
    }
}
