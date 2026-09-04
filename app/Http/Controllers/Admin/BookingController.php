<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceived;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceOption;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    
    public function index()
    {
        $locale = app()->getLocale();
        $categories = Category::with(['translations.language'])
            ->where('status', 1)
            ->get()
            ->map(function ($category) use ($locale) {
                $translation = $category->translations
                    ->firstWhere('language.code', $locale);
                $category->translated_name = $translation->name ?? '';
                return $category;
            });

        $services = Service::with(['translations.language', 'options'])
            ->where('status', 1)
            ->get()
            ->map(function ($service) use ($locale) {
                $translation = $service->translations->firstWhere('language.code', $locale);
                $service->translated_name = $translation ? $translation->name : $service->name;
                $option = $service->options->first();
                $service->duration = $option->duration ?? null;
                if ($locale === 'vi') {
                    $service->price = $option->price_vnd ?? null;
                    $service->sale_price = $option->sale_price_vnd ?? null;
                } else {
                    $service->price = $option->price_usd ?? null;
                    $service->sale_price = $option->sale_price_usd ?? null;
                }

                $service->category_name = $service->category->translated_name ?? 'Other';
                return $service;
            });

        return view('booking', compact('categories', 'services'));
    }
    public function store(BookingRequest $request)
    {
        $bookingDate = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $locale = 'vi';
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'country_name' => $request->input('country_name'),
            'country_code' => $request->input('country_code'),
            'phone' => $request->input('phone'),
            'full_phone' => $request->input('country_code') . ' ' . $request->input('phone'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'guestCount' => (int) $request->input('guestCount', 1),
            'guests' => $request->input('guests', []),
            'notes' => $request->input('notes'),
        ];
        $booking = Booking::create([
            'customer_name' => $data['name'],
            'customer_phone' => $data['phone'],
            'number_of_people' => $data['guestCount'],
            'booking_date' => $bookingDate,
            'booking_time' => $data['time'],
            'note' => $data['notes'],
            'status' => 'Đã đặt', 
        ]);

        foreach ($data['guests'] as &$guest) {
            $option = ServiceOption::with([
                'service.translations.language',
                'service.category.translations.language'
            ])->find($guest['service_option_id']);

            if ($option && $option->service) {
                $translation = $option->service->translations->firstWhere('language.code', $locale);
                $guest['service_name'] = $translation->name ?? '---';
                $guest['duration'] = $option->duration ?? '?';
                  if (!empty($option->sale_price_vnd) && $option->sale_price_vnd > 0) {
                    $guest['price'] = number_format($option->sale_price_vnd, 0, ',', '.') . ' VND';
                } else {
                    $guest['price'] = number_format($option->price_vnd, 0, ',', '.') . ' VND';
                }
                
            } else {
                $guest['service_name'] = '---';
                $guest['duration'] = '?';
                $guest['price'] = '---';
            }
                 BookingDetail::create([
                'booking_id' => $booking->id,
                'service_id' => $option->service_id ?? null,  
                'service_option_id' => $option->id ?? null,
                'person_name' => $guest['name'], 
                'note' => $guest['note'] ?? null,
            ]);
                }
        Mail::to(env('ADMIN_EMAIL'))->send(new BookingReceived($data));

        return back()->with('success', __('messages.booking_success'));
    }
public function list(Request $request)
{
    $sortBy = $request->get('sortBy', 'booking_date');
    $sortOrder = $request->get('sortOrder', 'desc');

    if (!in_array($sortBy, ['booking_date', 'status'])) {
        $sortBy = 'booking_date';
    }

    $query = Booking::with([
        'bookingDetails.service.translations.language',
        'bookingDetails.serviceOption'
    ]);

    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('customer_name', 'like', "%$keyword%")
              ->orWhere('customer_phone', 'like', "%$keyword%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->filled('date')) {
        $query->whereDate('booking_date', $request->input('date'));
    }

    $bookings = $query->orderBy($sortBy, $sortOrder)->paginate(10);

    $bookings->appends($request->query());

    return view('admin.booking.list', compact('bookings'));
}

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return response()->json(['success' => true]);
    }

}
