<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|min:5',
            'sprint' => 'bail|required',
            'meeting_type' => 'bail|required',
            'location' => 'bail|required',
            'date' => 'bail|required|after:yesterday',
            'time_start' => 'bail|required',
            'time_end' => 'bail|required|after:time_start',
        ];
    }
}
