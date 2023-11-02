<?php

namespace App\Rules;

use Closure;
use App\Models\Slot;
use App\Models\Student;
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
        $psm_year = Student::find($this->data['name'])->psm_year;

        // If slot id exist, get all slots except for this slot, else get all slots
        (array_key_exists("slot_id",$this->data)) ? $slots = Slot::all()->except($this->data['slot_id']) : $slots = Slot::all();

        if(array_key_exists("slot_id",$this->data)) {
            if($psm_year == 1){
                $slots = Slot::where('slot_id', '!=', $this->data['slot_id'])->where('venue_id', '!=', null)->get();
            }
            else{
                $slots = Slot::where('slot_id', '!=', $this->data['slot_id'])->where('booth_id', '!=', null)->get();
            }
        }
        else {
            if($psm_year == 1){
                $slots = Slot::where('venue_id', '!=', null)->get();
            }
            else{
                $slots = Slot::where('booth_id', '!=', null)->get();
            }
        }

        // Convert date and time to datetime format
        $date = $this->data['date'];
        $time = $this->data['timeslot']; 
        $date_time = date('Y-m-d H:i:s', strtotime("$date $time"));

        // Foreach slot, check if the venue is the same as the venue chosen by the user and if the date and time is the same as the date and time chosen by the user
        if($psm_year == 1){
            foreach ($slots as $slot) {
                if ($slot->venue_id == $value && $date_time == $slot->start_time) {
                    $fail('This venue is not available at this timeslot');
                }
            }
        }
        else{
            foreach ($slots as $slot) {
                if ($slot->booth_id == $value && $date_time == $slot->start_time) {
                    $fail('This booth is not available at this timeslot');
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
