<?php

namespace App\Http\Requests;

use App\Booking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'room_id'    => [
                'required',
                'integer'],
            'user_id'    => [
                'required',
                'integer'],
            'title'      => [
                'required'],
            'start_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')],
            'end_time'   => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')],
        ];

    }
}
