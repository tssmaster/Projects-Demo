<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Projects;

class ValidProject implements Rule
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
        $project = Projects::where([
            'id' => $value,
            'deleted' => 0
        ])->get();
        
        return $project->count() ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid project id.';
    }
}
