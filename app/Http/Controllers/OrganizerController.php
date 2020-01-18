<?php

namespace App\Http\Controllers;

use App\Model\admin\AttendeeModel;
use App\Model\organizer\ContactModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class OrganizerController extends Controller
{
    private $user_data;

    public function __construct()
    {
        $email = getCookie('email');
        $this->user_data = User::where('email', $email)->first();
        if (!$this->user_data) {
            $this->middleware('auth');
        } elseif ($this->user_data->user_type == 2) {
            auth()->loginUsingId($this->user_data->id);
        } else {
            $this->middleware('auth');
            $this->middleware('organizer');
        }
    }

    /* return dashboard view */
    public function dashboard(Request $request)
    {
        /*$came_from_single = getCookie('came_from_single');
        if ($came_from_single == 1) {
            unsetCookie('came_from_single', '/decipher');
            return redirect('/checkout');
        } elseif (session()->get('redirect_to') == 'create-event') {
            session()->forget('redirect_to');
            return redirect()->route('org-event-create');
        }*/
        return view('organizer.dashboard');
    }

    /* logout user */
    public function logout()
    {
        auth()->logout();
        unsetCookie('email', '/decipher');
        return redirect('/login');
    }

    /* create event view */
    public function eventCreate()
    {
        return view('organizer.events.event-create');
    }

    /* live events */
    public function liveEvents()
    {
        return view('organizer.events.live');
    }

    /* draft events */
    public function draftEvents()
    {
        return view('organizer.events.draft');
    }

    /* draft events */
    public function pastEvents()
    {
        return view('organizer.events.past');
    }

    /* my profile view */
    public function myProfile()
    {
        return view('organizer.me.profile');
    }

    /* coupon list view */
    public function couponList()
    {
        return view('organizer.coupon.list');
    }

    /* create coupon */
    public function createCoupon()
    {
        return view('organizer.coupon.create');
    }

    /* contact list */
    public function contactList()
    {
        return view('organizer.contact.list');
    }

    /* download contact details */
    public function exportContacts($type)
    {
        $organizer_id = auth()->user()->id;
        $contacts = ContactModel::selectRaw('first_name,last_name,email,created_at as Addon')
            ->where('organizer_id', $organizer_id)->get()->toArray();
        return \Excel::create('Contact List', function ($excel) use ($contacts) {
            $excel->sheet('Contact', function ($sheet) use ($contacts) {
                $sheet->fromArray($contacts);
            });
        })->download($type);
    }

    /* download contact details */
    public function exportAttendees($type)
    {
        $contacts = AttendeeModel::with(['event' => function ($query) {
            $query->select('id', 'event_title');
        }])->selectRaw('first_name, last_name, email, created_at, event_id')
            ->where('user_id', auth()->user()->id)->get()->toArray();
        if (count($contacts) <= 0) {
            return redirect()->back();
        }
        for ($i = 0; $i < count($contacts); $i++) {
            $contacts[$i]['event'] = $contacts[$i]['event']['event_title'];
            unset($contacts[$i]['event_id']);
        }
        return \Excel::create('Attendee List', function ($excel) use ($contacts) {
            $excel->sheet('Attendee', function ($sheet) use ($contacts) {
                $sheet->fromArray($contacts);
            });
        })->download($type);
    }

    /* add payment details */
    public function addAccountDetails()
    {
        return view('organizer.account.add-account');
    }

    /* manage accounts */
    public function manageAccounts()
    {
        return view('organizer.account.list');
    }

    /* attendees list */
    public function attendees()
    {
        return view('organizer.attendee.list');
    }

    /* list of all the promotion requests */
    public function promoRequests()
    {
        return view('organizer.promotions.list');
    }

    /* list of the followers */
    public function followers()
    {
        return view('organizer.followers.list');
    }

    /* orders list */
    public function orders()
    {
        return view('organizer.orders.list');
    }

    /* sales list */
    public function sales()
    {
        return view('organizer.orders.sales');
    }

    /* my sent promotions list */
    public function sentPromo()
    {
        return view('organizer.promotions.outgoing');
    }
}
