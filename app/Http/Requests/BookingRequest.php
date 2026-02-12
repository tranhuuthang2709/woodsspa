<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'guestCount' => 'required|integer|min:1|max:50',
            'guests' => 'required|array|min:1|max:50',
            'guests.*.name' => 'required|string|max:255',
            'guests.*.service_option_id' => 'required|exists:service_options,id',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('validation.attributes.name')]),
            'email.email' => __('validation.email', ['attribute' => __('validation.attributes.email')]),
            'phone.required' => __('validation.required', ['attribute' => __('validation.attributes.phone')]),
            'date.required' => __('validation.required', ['attribute' => __('validation.attributes.date')]),
            'date.after_or_equal' => __('validation.after_or_equal', ['attribute' => __('validation.attributes.date'), 'date' => __('validation.today')]),
            'time.required' => __('validation.required', ['attribute' => __('validation.attributes.time')]),
            'time.date_format' => __('validation.date_format', ['attribute' => __('validation.attributes.time')]),
            'guestCount.required' => __('validation.required', ['attribute' => __('validation.attributes.guestCount')]),
            'guestCount.integer' => __('validation.integer', ['attribute' => __('validation.attributes.guestCount')]),

            // Mảng khách
            'guests.required' => __('validation.required', ['attribute' => __('validation.attributes.guests')]),
            'guests.array' => __('validation.array', ['attribute' => __('validation.attributes.guests')]),
            'guests.*.name.required' => __('validation.required', ['attribute' => __('validation.attributes.guest_name')]),
            'guests.*.service_option_id.required' => __('validation.required', ['attribute' => __('validation.attributes.service_option')]),
            'guests.*.service_option_id.exists' => __('validation.exists', ['attribute' => __('validation.attributes.service_option')]),
        ];
    }
}
