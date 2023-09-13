<?php

namespace App\Rules;

use Closure;
use App\Models\Student;
use App\Models\SupervisorList;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class evaluatorCrashSupervisor implements ValidationRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supervisor_id = SupervisorList::where('student_id', $this->data['name'])->get()->first();

        if($supervisor_id->lecturer_id == $value) {
            $fail('This evaluator is already the supervisor of this student');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }
}
