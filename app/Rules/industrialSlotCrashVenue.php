<?php

namespace App\Rules;

use Closure;
use App\Models\IndustrialEvaluationSlot;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class industrialSlotCrashVenue implements ValidationRule, DataAwareRule
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
        // If industrial slot id exist, get all slots except for this slot, else get all slots
        (array_key_exists("industrial_slot_id",$this->data)) ? $slots = IndustrialEvaluationSlot::all()->except($this->data['industrial_slot_id']) : $slots = IndustrialEvaluationSlot::all();

        // Convert date and time to datetime format
        $date = $this->data['date'];
        $time = $this->data['timeslot']; 
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));

        // For each slot, if the time and venue if same as current data, then it is not available
        foreach ($slots as $slot) {
            if ($slot->venue_id == $value && $date_time == $slot->start_time) {
                $fail('This venue is not available at this timeslot');
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
