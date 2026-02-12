<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Admin_homecontroller extends Controller
{
    public function index(){
        $serviceCount = Service::count();
        $bookingCount = Booking::count();
        $completedBookingCount = Booking::where('status', 'Đã hoàn thành')->count();
        $chartLabels = [];
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = Carbon::create()->month($month)->format('F'); 
            $count = Booking::whereMonth('booking_date', $month)
                            ->whereYear('booking_date', Carbon::now()->year)
                            ->count();
            $chartData[] = $count;
        }

        $statusCounts = Booking::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total','status')->toArray();

        return view('admin.home', compact(
            'serviceCount', 
            'bookingCount', 
            'completedBookingCount',
            'chartLabels',
            'chartData',
            'statusCounts'
        ));
    }
}
