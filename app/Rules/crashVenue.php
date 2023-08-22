<?php

namespace App\Rules;

use Closure;
use App\Models\Slot;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class crashVenue implements ValidationRule, DataAwareRule
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
        (array_key_exists("slot_id",$this->data)) ? $slots = Slot::all()->except($this->data['slot_id']) : $slots = Slot::all();
        $date = $this->data['date'];
        $time = $this->data['timeslot']; 
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));

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
