<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "pickup_date" => "required",
            "pickup_time" => "required",
            "hand_luggage" => "required",
            "mid_luggage" => "required",
            "large_luggage" => "required",
            "trip_reason" => "required",
            "contact_name" => "required",
            "contact_email" => "required",
            "contact_phone" => "required"
        ];
    }

    public function messages()
    {
        return [
            "pickup_date" => "PickUp Date is Required",
            "pickup_time" => "PickUp Time is Required",
            "hand_luggage" => "Hand Luggage is Required",
            "mid_luggage" => "Medium Luggage is Required",
            "large_luggage" => "Large Luggage is Required",
            "trip_reason" => "Trip Reason is Required",
            "contact_name" => "Contact Name is Required",
            "contact_email" => "Contact Email is Required",
            "contact_phone" => "Contact Phone is Required"
        ];
    }
}
