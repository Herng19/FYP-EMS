<?php

namespace App\Rules;

use Closure;
use App\Models\Slot;
use App\Models\Student;
use App\Models\EvaluatorList;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class evaluatorCrashTimeslot implements ValidationRule, DataAwareRule
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
        $student = Student::find($this->data['name']);
        (array_key_exists("slot_id",$this->data)) ? $slots = Slot::all()->except($this->data['slot_id']) : $slots = Slot::all();
        $date = $this->data['date'];
        $time = $this->data['timeslot']; 
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        
        foreach($slots As $slot) {
            if($date_time == $slot->start_time && $slot->student->research_group_id == $student->research_group_id) {
                $evaluator_timeslots = EvaluatorList::where('student_id', '=', $slot->student_id)->get(); 
                foreach($evaluator_timeslots as $evaluator_timeslot) {
                    if($evaluator_timeslot->lecturer_id == $value) {
                        $fail('This evaluator is not available at this timeslot');
                    }
                }
            }
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
