<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidStatus implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (in_array($value, config('app.projects_tasks_statuses'))) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid status. Valid values are: ' . implode(', ', config('app.projects_tasks_statuses'));
    }
}
