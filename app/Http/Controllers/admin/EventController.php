<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\EventModel;
use DB;
use Session;

class EventController extends Controller
{
    var $objEventModel;

    /**
     * @Author:          Rishikesh Singh
     * @Last modified:   <28-feb-2019>
     * @Project:         <Event Ticketing>
     * @Function:        <__construct>
     * @Description:     <this function load models and authenticate user Request >
     * @Parameters:      <NO>
     * @Method:          <NO>
     * @Returns:         <NO>
     * @Return Type:     <NO>
     */

    public function __construct()
    {
        $this->objEventModel = new EventModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for admin Event List
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventList(Request $request)
    {
//        $data = EventModel::with('REL_Event_Category', 'REL_Event_Organizer')->get();
//        return view('admin.events.listEvent', compact('data'));
        return view('admin.events.listEvent');
    }

    /**
     * This function  give single data about event
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewEvent(Request $request)
    {
        $event = EventModel::with('REL_Event_Category', 'organizer',
            'REL_Event_Image', 'REL_event_ticket', 'REL_event_subcategory')
            ->where('id', $request->id)->first();
        return view('admin.events.eventDetail', compact('event'));
    }

    /**
     * toggle event status
     * @param Request $request
     * @return false|string
     */
    public function activeEvent(Request $request)
    {
        $eventId = $request->id;
        $eventData = EventModel::find($eventId);
        $eventData['event_status'] = ($eventData['event_status'] == 1) ? 0 : 1;
        $eventData->save();
        return json_encode($eventData['event_status']);
    }

    /**
     * list of events to show in datatables.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function EventListDatatable(Request $request)
    {
        $search = $request->input('search');
        $events = EventModel::with('REL_Event_Organizer', 'REL_event_Category')
            ->when($search['value'], function ($query) use ($search) {
                $query->where('event_title', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('event_description', 'LIKE', '%' . $search['value'] . '%');
            })
            ->where('is_delete', 0)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $resourceDatatable = array(
            "recordsTotal" => $events->total(),
            "recordsFiltered" => $events->total(),
            "data" => array(),
        );
        foreach ($events as $key => $event) {
            $index = ($events->currentPage() - 1) . $key + 1;
            if(strlen($event->event_title) > 15){
                $event->event_title = substr($event->event_title, 0, 15).'...';
            }
            array_push($resourceDatatable["data"], [
                $event->id,
                $event->event_title,
                $event->REL_event_Category->category_name,
                $event->REL_Event_Organizer->first_name . ' ' . $event->REL_Event_Organizer->last_name,
                $event->event_location,
                '<a href="'.url('/event/'. $event->event_url).'" target="_blank">'.url('/event/' . $event->event_url).'</a>',
                $event->status, $index
            ]);
        }
        return response()->json($resourceDatatable);
    }
}
