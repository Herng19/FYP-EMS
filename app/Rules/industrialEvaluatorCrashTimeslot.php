<?php

namespace App\Rules;

use Closure;
use App\Models\IndustrialSlotEvaluator;
use App\Models\IndustrialEvaluationSlot;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class industrialEvaluatorCrashTimeslot implements ValidationRule, DataAwareRule
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
        (array_key_exists("industrial_slot_id",$this->data)) ? $slots = IndustrialEvaluationSlot::all()->except($this->data['industrial_slot_id']) : $slots = IndustrialEvaluationSlot::all();
        $date = $this->data['date'];
        $time = $this->data['timeslot']; 
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        
        // Iterate through each industrial slot to check if the industrial evaluator available at the timeslot on that day
        foreach($slots As $slot) {
            if($date_time == $slot->start_time) {
                foreach($slot->industrial_slot_evaluators->toArray() as $slot_evaluator) {
                    if($slot_evaluator['industrial_evaluator_id'] == $value) {
                        $fail('This industrial evaluator is not available at this timeslot');  
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
