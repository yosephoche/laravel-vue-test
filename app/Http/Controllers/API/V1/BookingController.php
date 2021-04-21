<?php


namespace App\Http\Controllers\API\V1;


use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends BaseController
{
    protected $booking;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->middleware('auth:api');
        $this->booking = $booking;
    }

    public function index(Request $request)
    {
        $bookings = $this->booking->all();
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:m:s');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:m:s');
            $bookings = $this->booking->whereBetween('booking_date', [$start_date, $end_date])->get();
        }
        return $this->sendResponse($bookings, 'Booking List');
    }

}
