<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\EventFormRequest;
use App\Event;
use Carbon\Carbon;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('date', '>', Carbon::now())->get();

        if($events){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'All upcoming events retrived successfully',
                'data'          => $events,
            ], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventFormRequest $request)
    {
        $event = Event::create([
            'name'          => $request->name,
            'date'          => $request->date,
            'artist'        => $request->artist,
            'free_tables'   => $request->free_tables,
        ]);

        if($event){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Event created successfully',
                'data'          => $event,
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
        $event = Event::where('id', $id)->get();

        if($event){
            return response()->json([
                'status_code'   => 201,
                'message'       => 'Event retrived successfully',
                'data'          => $event,
            ], 201);
        }
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
