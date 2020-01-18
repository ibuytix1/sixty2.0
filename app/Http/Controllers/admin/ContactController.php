<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\ContactModel;
use App\Model\admin\EventModel;
use Validator;
use Session;
use Mail;
use DB;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckAdminLogin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactList()
    {
        return view('admin.contact.contactList');
    }

    /**
     * add contact view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addContact()
    {
        $eventList = EventModel::where('is_delete', 0)
            ->where('is_private', 0)
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('status', 1)
            ->pluck('event_title', 'id');
        $eventList ? $eventList : [];
        $events = array('' => 'Select Events');
        foreach ($eventList as $eveId => $event) {
            $events[$eveId] = $event;
        }
        return view('admin.contact.addContact', compact('events'));
    }

    /**
     * This method delete Category
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listContactJson(Request $request)
    {

        $search = $request->input('search');
        $data = ContactModel::when($search['value'], function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('email', 'LIKE', '%' . $search['value'] . '%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $resourceDatatable = array(
            "recordsTotal" => $data->total(),
            "recordsFiltered" => $data->total(),
            "data" => array(),
        );
        foreach ($data as $key => $value) {
            $index = ($data->currentPage() - 1) . $key + 1;
            array_push($resourceDatatable["data"], [
                $value->id,
                $value->first_name,
                $value->last_name,
                $value->email,
                $index
            ]);
        }
        return response()->json($resourceDatatable);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $organizer_id = Session::get('organizer_data')['id'];
        $event_id = $request->event_id;
        if ($request->hasFile('sample_file')) {
            $path = $request->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'first_name' => $value->first_name,
                        'last_name' => $value->last_name,
                        'email' => $value->email,
                        'create_at' => new \ DateTime(),
                        'event_id' => $event_id,
                        'organizer_id' => $organizer_id
                    ];
                }
                if (!empty($arr)) {
                    ContactModel::insert($arr);
                    return redirect('Organizer/contact/list')->with('status', 'Data uploaded successfully');
                }
            }
        }
        return redirect('Organizer/contact/list')->with('status', 'Data not available in file');
    }

    /**
     * contacts download in excel format
     * @param $type
     * @return mixed
     */
    public function downloadExcelFile($type)
    {
        $organizer_id = Session::get('organizer_data')['id'];
        $contacts = ContactModel::selectRaw('first_name,last_name,email,create_at as Addon')
            ->where('organizer_id', $organizer_id)->get()->toArray();
        return \Excel::create('Contact List', function ($excel) use ($contacts) {
            $excel->sheet('Contact', function ($sheet) use ($contacts) {
                $sheet->fromArray($contacts);
            });
        })->download($type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editContact($id)
    {
        $eventList = EventModel::where('is_delete', 0)
            ->where('event_status', 1)
            ->pluck('event_title', 'id');
        $eventList ? $eventList : [];
        $events = array('' => 'Select Events');
        foreach ($eventList as $eveId => $event) {
            $events[$eveId] = $event;
        }
        $data = ContactModel::with('event')->find($id);
        return view('admin.contact.editContact', compact('data', 'events'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function saveContact(Request $request)
    {
        $requestData = unsetData($request->all(), array('_token'));
        if (empty($request->contact_id)) {
            $this->_data_validation_update($request);
            ContactModel::insert($requestData);
            return redirect('Admin/contactList')->with('status', 'Contact added successfully');
        }
        $this->_data_validation_update($request);
        $contact_id = $request->contact_id;
        unset($requestData['contact_id']);
        ContactModel::where('id', $contact_id)->update($requestData);
        return redirect('Admin/contactList')->with('status', 'Contact added successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return bool|null
     * @throws \Exception
     */
    public function deleteContact(Request $request)
    {
        return (ContactModel::find($request->id)->delete()) ? 0: 1;
    }

    /**
     * send emails view
     * @param $ids
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendmail($ids)
    {
        return view('organizer.contact.sendMail', compact('ids'));
    }

    /**
     * send email code
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMailCode(Request $request)
    {
        $message = $request->mail_message;
        $ids = explode(',', $request->ids);
        $data = ContactModel::WhereIn('id', $ids)
            ->select('email', DB::raw('CONCAT(first_Name, " ", last_Name) AS full_name'))
            ->get();
        foreach ($data as $key => $userdata) {
            $email = $userdata->email;
            Mail::send('mails.notification', [
                'title' => 'Notification',
                'description' => $message,
                'name' => $userdata->full_name
            ], function ($message) use ($email) {
                $message->from('rishikeshdean@gmail.com', 'Event Booking Team');
                $message->to($email)->subject("Notification");
            });
        }
        return redirect('Organizer/contact/list')->with('status', 'Mail send successfully');
    }

    /**
     * data validation
     * @param Request $request
     */
    private function _data_validation_update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'event_id' => 'required',
        ]);
        return;
    }


}
