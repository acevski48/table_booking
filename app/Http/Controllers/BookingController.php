<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingFormRequest;
use App\Booking;
use App\Event;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingFormRequest $request)
    {
        $event = Event::findOrFail($request->event_id);

        $allBookedTablesForEvent = Booking::where('event_id', $request->event_id)->get()->pluck('table_number')->toArray();

        $availableTables = array_diff(range(1, $event->free_tables), $allBookedTablesForEvent);

        if($event->date < Carbon::now()){
            return response()->json([
                'status_code'   => 400,
                'message'       => 'Event no longer available',
            ], 400);
        }

        if(in_array($request->table_number, $allBookedTablesForEvent)){
            return response()->json([
                'status_code'   => 400,
                'message'       => 'Table is allredy booked',
            ], 400);
        }

        if($request->table_number < 1 || $request->table_number > $event->free_tables){
            return response()->json([
                'status_code'   => 400,
                'message'       => 'Invalid table number, table number can be one of following ' .implode(',', $availableTables),
            ]);
        }

        $booking = Booking::create([
            'user_id'       => $request->user_id,
            'event_id'      => $request->event_id,
            'table_number'  => $request->table_number,
            'date'          => $event->date,
            'free_tables'   => $request->free_tables,
        ]);

        if($booking){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Booking created successfully',
                'data'          => $booking,
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
