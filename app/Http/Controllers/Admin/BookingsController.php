<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Room;
use App\Services\BookingService;
use Carbon\Carbon;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingsController extends Controller
{
    public function searchRoom(Request $request)
    {
        $rooms = null;
        if($request->filled(['start_time', 'end_time', 'capacity'])) {
            $times = [
                Carbon::parse($request->input('start_time')),
                Carbon::parse($request->input('end_time')),
            ];

            $rooms = Room::where('capacity', '>=', $request->input('capacity'))
                ->whereDoesntHave('bookings', function ($query) use ($times) {
                    $query->whereBetween('start_time', $times)
                        ->orWhereBetween('end_time', $times)
                        ->orWhere(function ($query) use ($times) {
                            $query->where('start_time', '<', $times[0])
                                ->where('end_time', '>', $times[1]);
                        });
                })
                ->get();
        }

        return view('admin.bookings.search', compact('rooms'));
    }

    public function bookRoom(Request $request, BookingService $bookingService)
    {
        $request->merge([
            'user_id' => auth()->id()
        ]);

        $request->validate([
            'title'   => 'required',
            'room_id' => 'required',
        ]);

        $room = Room::findOrFail($request->input('room_id'));

        if ($bookingService->isRoomTaken($request->all())) {
            return redirect()->back()
                    ->withInput()
                    ->withErrors(['recurring_until' => 'This room is not available until the recurring date you have chosen']);
        }

        if (!auth()->user()->is_admin && !$bookingService->chargeHourlyRate($request->all(), $room)) {
            return redirect()->back()
                    ->withInput()
                    ->withErrors(['Please add more credits to your account. <a href="' . route('admin.balance.index') . '">My Credits</a>']);
        }

        $booking = Booking::create($request->all());

        if ($request->filled('recurring_until')) {
            $bookingService->createRecurringBookings($request->all());
        }

        return redirect()->route('admin.systemCalendar')->withStatus('A room has been successfully booked');
    }


    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::all();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookings.create', compact('rooms', 'users'));
    }

    public function store(StoreBookingRequest $request, BookingService $bookingService)
    {
        if ($bookingService->isRoomTaken($request->all())) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors('This room is not available at the time you have chosen');
        }

        $booking = Booking::create($request->all());

        if ($request->filled('recurring_until')) {
            $bookingService->createRecurringBookings($request->all());
        }

        return redirect()->route('admin.bookings.index');

    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('room', 'user');

        return view('admin.bookings.edit', compact('rooms', 'users', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');

    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('room', 'user');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();

    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
