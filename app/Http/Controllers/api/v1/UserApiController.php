<?php

namespace App\Http\Controllers\api\v1;

use App\Model\admin\TicketModel;
use App\Model\HelpdeskCategory;
use App\Model\Order;
use App\Model\UserCard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Model\admin\OrganizerModel;
use App\Model\admin\EventModel;
use App\Model\admin\BankAccountModel;
use App\Model\admin\PayPalAccountModel;
use App\Model\organizer\Coupon_Model;
use App\Model\organizer\ContactModel;
use App\Model\admin\CategoryModel;
use App\Model\admin\SubCategoryModel;
use App\Model\admin\TagsModel;
use App\Model\Follow;
use App\Model\CartItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Events\SendMail;
use Carbon\Carbon;
use App\Model\Helpdesk;
use App\Model\HelpdeskImages;

class UserApiController extends Controller
{
    /**
     * Handles Search event Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEvent(Request $request)
    {
        $search = $request->all();
        $events = EventModel::with(
            'REL_Event_Category', 'REL_Event_Organizer', 'REL_event_ticket',
            'REL_Event_Image', 'REL_event_subcategory')
            ->when($search, function ($query) use ($search) {
                if (isset($search['q'])) {
                    $query->where('event_title', 'LIKE', '%' . $search['q'] . '%');
                }
                if (!empty($search['location'])) {
                    $query->where('address', 'LIKE', '%' . $search['location'] . '%');
                }
                if (!empty($search['start_date'])) {
                    $query->where('start_date', '=', date('Y-m-d', strtotime($search['start_date'])));
                }
                if (!empty($search['category'])) {
                    $query->where('category_id', '=', $search['category']);
                }
            })->where('event_status', '1')->where('start_date', '>=', date('Y-m-d'))
            ->where('is_private', '0')->paginate(10);
        if ($events->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $events, 'message' => 'Live Event List',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * paginate Category list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryList()
    {
        $categories = CategoryModel::paginate(6);
        if ($categories->isEmpty()) {
            return response()->json([
                'payload' => [], 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $categories, 'message' => 'Category  List',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * return all category list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allCategoryList()
    {
        $categories = CategoryModel::all();
        if ($categories->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $categories, 'message' => 'All Category  List',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * Handles event list by Category id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventListByCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(),
                'message' => 'Validation Failed',
                'dev_message' => $validator->errors(),
                'type' => 'ERROR',
                'code' => 0
            ]);
        } else {
            $mytime = Carbon::now();
            $currentTime = date('H:i', strtotime($mytime->toDateTimeString()));
            $data = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
            }, 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                $query->select('id', 'subcategory_name');
            }])
                ->where(['category_id' => $request->category_id])
                ->where('event_status', '1')
                // ->where('end_date','>=',date('Y-m-d'))
                // ->where('end_time','>=',$currentTime)
                // ->where('start_date','<=',date('Y-m-d'))
                // ->where('start_time','<=',$currentTime)
                ->paginate(5);
            if (!$data->isEmpty()) {
                return response()->json([
                    'payload' => $data,
                    'message' => 'Event list by category',
                    'dev_message' => new \stdClass(),
                    'type' => 'SUCCESS',
                    'code' => 1
                ]);
            } else {
                return response()->json([
                    'payload' => new \stdClass(),
                    'message' => 'data not available',
                    'dev_message' => '',
                    'type' => 'ERROR',
                    'code' => 0
                ]);
            }
        }
    }

    /**
     * Handles  Category Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewSingleEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        }
        $slug = $request->get('id');
        $event = EventModel::with(['tags', 'REL_Event_Category', 'REL_event_ticket' => function ($query) {
            $query->select('price', 'id', 'event_id', 'quantity', 'ticket_type', 'description',
                DB::raw("CASE WHEN event_type= '1' THEN 'Free' 
                        WHEN event_type= '2' 
                        THEN 'Paid' ELSE 'Donation' 
                        END as event_type"));
            $query->orderBy('price', 'ASC');
        }, 'REL_Event_Organizer', 'REL_Event_Image'])->where('event_url', $slug)->first();
        if (!$event) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Event not found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $event, 'message' => 'event data',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * Handles  Upcoming Event List  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeklyUpcomingEventList()
    {
        $carbon = Carbon::now();
        $today = new \stdClass();
        $today->date = $carbon->toDateString();
        $today->time = date('H:i', strtotime($carbon->toDateTimeString()));
        $today->dateAfterSevenDays = $carbon->addDays(7)->toDateString();
        $event = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
            $query->select(
                'price', 'id', 'event_id', 'quantity',
                DB::raw(
                    "CASE WHEN event_type= '1' 
                            THEN 'Free' WHEN event_type= '2' 
                            THEN 'Paid' ELSE 'Donation' 
                            END as event_type"
                )
            );
            $query->orderBy('price', 'ASC');
        }
            , 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                $query->select('id', 'subcategory_name');
            }])
            ->where('event_status', '1')
            ->where('start_date', '>=', $today->date)
            ->where('start_date', '<=', $today->dateAfterSevenDays)
            ->orderBy('start_date')
            ->paginate(3);
        if ($event->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $event, 'message' => 'All upcoming event List',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * Handles  Upcoming Event List  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcomingEventListByMonth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(),
                'message' => 'Validation Failed',
                'dev_message' => $validator->errors(),
                'code' => 0
            ]);
        } else {
            $data = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
                $query->select('price', 'id', 'event_id',
                    DB::raw("CASE WHEN event_type= '1' 
                        THEN 'Free' WHEN event_type= '2' 
                        THEN 'Paid' ELSE 'Donation' 
                        END as event_type"));
                $query->orderBy('price', 'ASC');
            }
                , 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                    $query->select('id', 'subcategory_name');
                }])
                ->where('event_status', '1')
                ->whereMonth('start_date', '=', date('m', strtotime($request->date)))
                ->paginate(7);
            if ($data) {

                return response()->json([
                    'payload' => $data,
                    'message' => 'All upcoming event List',
                    'dev_message' => '',
                    'code' => 1
                ]);
            } else {
                return response()->json([
                    'payload' => new \stdClass(),
                    'message' => 'data not available',
                    'dev_message' => 'data not available',
                    'code' => 0
                ]);
            }
        }
    }

    /**
     * Handles  Upcoming Event List  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventListByWeek(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(),
                'message' => 'Validation Failed',
                'dev_message' => $validator->errors(),
                'code' => 0
            ]);
        } else {
            // DB::enableQueryLog()
            $data = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
                $query->select('price', 'id', 'event_id',
                    DB::raw("CASE WHEN event_type= '1' 
                        THEN 'Free' WHEN event_type= '2' 
                        THEN 'Paid' ELSE 'Donation' 
                        END as event_type"));
                $query->orderBy('price', 'ASC');
            }
                , 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                    $query->select('id', 'subcategory_name');
                }])
                ->where('event_status', '1')
                ->where(DB::raw('yearweek(DATE(start_date), 1)'), DB::raw('yearweek(curdate(), 1)'))
                ->where('start_date', '>=', date('Y-m-d'))
                ->paginate(7);
            /*DB::getQueryLog()*/
            if ($data) {

                return response()->json([
                    'payload' => $data,
                    'message' => 'All upcoming event in this week',
                    'dev_message' => '',
                    'code' => 1
                ]);
            } else {
                return response()->json([
                    'payload' => new \stdClass(),
                    'message' => 'data not available',
                    'dev_message' => 'data not available',
                    'code' => 0
                ]);
            }
        }
    }

    /**
     * Handles  Upcoming Event List  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function schedulesEventList(Request $request)
    {
        $requestData = $request->all();
        $data = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
            $query->select('price', 'id', 'event_id',
                DB::raw("CASE WHEN event_type= '1' 
                    THEN 'Free' WHEN event_type= '2' 
                    THEN 'Paid' ELSE 'Donation' 
                    END as event_type"));
            $query->orderBy('price', 'ASC');
        }
            , 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                $query->select('id', 'subcategory_name');
            }]);
        $data->where('event_status', '1');
        if (isset($requestData['date'])) {
            $data->where('start_date', '=', $request->date);
        }
        if (isset($requestData['key'])) {
            $data->Where('event_title', 'like', '%' . $requestData['key'] . '%');
        }
        if (isset($requestData['month_year'])) {
            $monthYear = date('Y-m-d', strtotime($requestData['month_year']));
            $data->where('end_date', '<=', DB::raw('LAST_DAY("' . $monthYear . '")'));
            $data->where('start_date', '>=',
                DB::raw('date_add(date_add(LAST_DAY("' . $monthYear . '"),interval 1 DAY),interval -1 MONTH)'));
        }
        if (isset($requestData['year'])) {
            $data->Where(DB::raw('YEAR(start_date)'), 'like', '%' . $requestData['year'] . '%');
        }
        $data->orderBy('start_date', 'ASC');
        $data = $data->paginate(7);
        if (!$data->isEmpty()) {
            return response()->json([
                'payload' => $data, 'message' => 'All upcoming event in this week',
                'dev_message' => '', 'code' => 1
            ]);
        } else {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
    }

    /**
     * Handles  Follow Organizer  Request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * * @throws \Exception
     */

    public function followOrganizer(Request $request)
    {
        $follower_user_id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'followed_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        } else {
            $data = Follow::where([
                'follower_user_id' => $follower_user_id,
                'followed_user_id' => $request->followed_user_id
            ])->count();
            if ($data > 0) {
                return response()->json([
                    'payload' => new \stdClass(), 'message' => 'You already follow this user',
                    'dev_message' => 'data already exist', 'code' => 0
                ]);
            } else {
                $insertData = array(
                    'follower_user_id' => $follower_user_id,
                    'followed_user_id' => $request->followed_user_id,
                    'created_at' => new \DateTime(),
                );
                $data = Follow::Insert($insertData);
                if ($data) {
                    return response()->json([
                        'payload' => new \stdClass(), 'message' => 'Followed successfully',
                        'dev_message' => '', 'code' => 1
                    ]);
                } else {
                    return response()->json([
                        'payload' => new \stdClass(), 'message' => 'Something went wrong please try after some time',
                        'dev_message' => '', 'code' => 0
                    ]);
                }
            }
        }
    }

    /**
     * Handles  Unfollow Organizer  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function UnfollowOrganizer(Request $request)
    {
        $follower_user_id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'followed_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        }
        $following = Follow::where([
            'follower_user_id' => $follower_user_id,
            'followed_user_id' => $request->followed_user_id
        ])->first();
        if (!$following) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'You are not following this user',
                'dev_message' => '', 'code' => 0
            ]);
        }
        if (!$following->delete()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Something went wrong please try after some time',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => new \stdClass(), 'message' => 'Unfollow successfully',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * Handles  Unfollow Organizer  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewOrganizerProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed please enter valid user_id',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available with this user_id',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $user, 'message' => 'Organizer Detail',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * Handles  Unfollow Organizer  Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventListByOrganizer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed please enter valid user_id',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $events = EventModel::where('organizer_id', $request->user_id)
            ->where('is_private', 0)
            ->where('event_status', 1)->get();
        if ($events->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $events, 'message' => 'Event List',
            'dev_message' => '', 'code' => 0
        ]);

    }

    /**
     * Handles add to cart Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTicketToCart(Request $request)
    {
        // validate form data
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Validation failed',
                'dev_message' => $validator->errors(),
                'code' => 0
            );
            return response()->json($response);
        }
        $user_id = auth()->user()->id;
        // get ticket data if exists
        $ticket = TicketModel::find($request->get('ticket_id'));
        if (!$ticket) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Ticket Not Found',
                'dev_message' => '',
                'code' => 0
            );
            return response()->json($response);
        }
        // show error if ticket quantity is less then user's selected quantity
        if ($request->get('quantity') > $ticket->quantity) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Not enough tickets',
                'dev_message' => 'ticket quantity is less then user ticket quantity',
                'code' => 0
            );
            return response()->json($response);
        }
        // cart data
        $cartData = array(
            'quantity' => $request->get('quantity'),
            'price' => $request->get('quantity') * $ticket->price,
            'ticket_type' => $ticket->ticket_type,
            'user_id' => $user_id,
            'ticket_id' => $ticket->id,
        );
        $matchData = array(
            'ticket_id' => $ticket->id,
            'user_id' => $user_id,
        );
        /* if user id and ticket id already exists then update item
         else delete the cart item */
        $data = CartItem::updateOrCreate($matchData, $cartData);
        if ($data->wasRecentlyCreated) {
            $response = array(
                'payload' => $data,
                'message' => 'Added to cart successfully',
                'dev_message' => $validator->errors(),
                'code' => 1
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $data,
            'message' => 'Cart updated successfully',
            'dev_message' => $validator->errors(),
            'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles remove from cart Request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeFormCart(Request $request)
    {
        // validate form data
        $validator = Validator::make($request->all(), [
            'cartitem_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Valodation failed',
                'dev_message' => $validator->errors(),

                'code' => 0
            );
            return response()->json($response);
        }
        $user_id = auth()->user()->id;
        // find cart item if exists
        $data = CartItem::where('user_id', $user_id)->find($request->get('cartitem_id'));
        if (!$data) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Cart item not found',
                'dev_message' => '',

                'code' => 0
            );
            return response()->json($response);
        }
        // delete cart item from the database
        $data->delete();
        return response()->json([
            'payload' => $data,
            'message' => 'Item removed successfully',
            'dev_message' => '',

            'code' => 1
        ]);
    }

    /**
     * Handles add to cart Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cartList(Request $request)
    {
        // current logged in user's cart items
        $cartItems = CartItem::where('user_id', auth()->user()->id)->get();
        if (!$cartItems->count()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Cart is empty',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $cartItems, 'message' => 'Cart list',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'event_id' => 'required',
            'coupon_code' => 'required',
            'total_price' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        }
        $coupon_code = $request->get('coupon_code');
        $event_id = $request->get('event_id');
        $total_price = $request->get('total_price');
        $coupon = Coupon_Model::where('coupon', $coupon_code)
            ->where('status', 1)->first();
        if (!$coupon) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Coupon not found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        // validating coupon is made for the event or not
        if ($coupon->redeem_on != $event_id) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'This coupon cannot be applied on this event',
                'dev_message' => '', 'code' => 0
            ]);
        }
        // checking if coupon is applied early or expired
        $today = date('Y-m-d');
        if ($today < $coupon->start_date) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Coupon cannot be applied before ' . $coupon->start_date,
                'dev_message' => '', 'code' => 0
            ]);
        }

        if ($today > $coupon->end_date) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Coupon Expired',
                'dev_message' => '', 'code' => 0
            ]);
        }
        // applying coupon on the basis of coupon type
        if ($coupon->type == 'amt') {
            $payload = array(
                'new_total' => (int)($total_price - $coupon->amount)
            );
            return response()->json([
                'payload' => $payload, 'message' => 'Coupon applied successfully',
                'dev_message' => '', 'code' => 1
            ]);
        } elseif ($coupon->type == '%') {
            $discounted_price = ($coupon->amount / 100) * $total_price;
            $payload = array(
                'new_total' => ($total_price - $discounted_price)
            );
            return response()->json([
                'payload' => $payload, 'message' => 'Coupon applied successfully',
                'dev_message' => '', 'code' => 1
            ]);
        } else {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Technical issues',
                'dev_message' => 'coupon code is not amt or %', 'code' => 0
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpdeskCategories()
    {
        $helpdesk_categories = HelpdeskCategory::all();
        if ($helpdesk_categories->count() == 0) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'No Category Found',
                'dev_message' => '',

                'code' => 0
            );
            return response()->json($response);
        }

        $response = array(
            'payload' => $helpdesk_categories,
            'message' => '',
            'dev_message' => '',

            'code' => 1
        );
        return response()->json($response);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function helpdesk(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'organizer_id' => 'required|numeric',
            'help_category' => 'required|numeric',
            'subject' => 'required',
            'message' => 'required',
        ));
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }
        $user_id = auth()->user()->id;
        $organizer_id = (int)$request->get('organizer_id');
        $help_category = $request->get('help_category');
        $subject = $request->get('subject');
        $message = $request->get('message');
        $status = 'pending';
        if (!User::where('id', $organizer_id)->where('user_type', 2)->exists()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Organizer not found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $organizer_email = User::find($organizer_id)->email;
        if (!HelpdeskCategory::where('id', $help_category)->exists()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Helpdesk category not found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        if (Helpdesk::where('user_id', $user_id)->where('organizer_id', $organizer_id)
            ->where('category_id', $help_category)->exists()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Helpdesk ticket already found.',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        $helpdesk = new Helpdesk();
        $helpdesk->user_id = $user_id;
        $helpdesk->organizer_id = $organizer_id;
        $helpdesk->category_id = $help_category;
        $helpdesk->subject = $subject;
        $helpdesk->message = $message;
        $helpdesk->status = $status;
        $helpdesk->save();
        if ($request->hasFile('help_image')) {
            foreach ($request->file('help_image') as $image) {
                $name = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path() . '/helpdesk', $name);
                $help_image = new HelpdeskImages();
                $help_image->helpdesk_id = $helpdesk->id;
                $help_image->image = $name;
                $help_image->save();
            }
        }
        Mail::send([], [], function ($mess) use ($organizer_email, $subject, $message) {
            $mess->from('noreply@ibuytix.com', $subject);
            $mess->to($organizer_email)->subject($subject)->setBody($message);
        });
        $response = array(
            'payload' => $helpdesk, 'message' => 'Helpdesk ticket created successfully',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    public function getHelpdeskTickets()
    {
        $user_id = auth()->user()->id;
        $help_ticket = Helpdesk::with('images', 'category', 'organizer')->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')->paginate(10);
        if ($help_ticket->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No helpdesk ticket found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $help_ticket, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    public function getHelpdeskTicket(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'helpdesk_id' => 'required|numeric',
        ));
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }
        $user_id = auth()->user()->id;
        $helpdesk_id = $request->get('helpdesk_id');
        $helpdesk = Helpdesk::with('images', 'category')
            ->where('user_id', $user_id)->find($helpdesk_id);
        if (!$helpdesk) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No helpdesk ticket found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $helpdesk, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    public function allEvents(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'lat' => 'required',
            'lng' => 'required'
        ));
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        }
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $distance = 50;
        $carbon = Carbon::now();
        $today = new \stdClass();
        $today->date = $carbon->toDateString();
        $today->time = date('H:i', strtotime($carbon->toDateTimeString()));
        $today->dateAfterSevenDays = $carbon->addDays(7)->toDateString();
        $query = EventModel::getByDistance($lat, $lng, $distance);
        if (empty($query)) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No event found near you.',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $ids = [];
        //Extract the id's
        foreach ($query as $q) {
            array_push($ids, $q->id);
        }
        // Get the listings that match the returned ids
        $events = EventModel::with(['REL_Event_Category', 'REL_event_ticket' => function ($query) {
            $query->select(
                'price', 'id', 'event_id', 'quantity',
                DB::raw(
                    "CASE WHEN event_type= '1' 
                            THEN 'Free' WHEN event_type= '2' 
                            THEN 'Paid' ELSE 'Donation' 
                            END as event_type"
                )
            );
            $query->orderBy('price', 'ASC');
        }
            , 'REL_Event_Organizer', 'REL_Event_Image', 'REL_event_subcategory' => function ($query) {
                $query->select('id', 'subcategory_name');
            }])
            ->whereIn('id', $ids)
            ->where('event_status', '1')
            ->where('start_date', '>=', $today->date)
            ->paginate(9);
        if ($events->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No events found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $events, 'message' => 'All upcoming event List',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function followingList()
    {
        $id = auth()->user()->id;
        $following = Follow::with('organizer')->where('follower_user_id', $id)
            ->orderBy('created_at', 'DESC')->paginate(10);
        if ($following->count() <= 0) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'not following anyone',
                'dev_message' => '', 'code' => 0,
            ]);
        }
        return response()->json([
            'payload' => $following, 'message' => 'list of following people',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function organizerList()
    {
        $organizers = User::where('user_type', 2)
            ->select('id', 'first_name', 'last_name')->get();
        if ($organizers->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No organizers Found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $organizers, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * order list of current user with past events.
     * @return \Illuminate\Http\JsonResponse
     */
    public function pastEventOrders()
    {
        // getting the list of orders where event start date is less then today's date
        $orders = Order::with('event', 'order_tickets')
            ->where('customer_id', auth()->user()->id)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '<', date('Y-m-d'));
            })->orderBy('created_at', 'DESC')->paginate(10);
        // code 0 if orders not found
        if ($orders->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'no orders found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        // send orders details in json format
        return response()->json([
            'payload' => $orders, 'message' => 'past events order list',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * order list of current user with upcoming events.
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcomingEventOrders()
    {
        // getting the list of orders where event
        // start date is greater then and equal today's date
        $orders = Order::with('event', 'order_tickets')->where('customer_id', auth()->user()->id)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>=', date('Y-m-d'));
            })->orderBy('created_at', 'DESC')->paginate(10);
        // code 0 if orders not found
        if ($orders->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'no orders found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        // send orders details in json format
        return response()->json([
            'payload' => $orders, 'message' => 'past events order list',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * update message sent to the support team
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateHelpdeskMessage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'message' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        $id = $request->get('id');
        $message = $request->get('message');
        $ticket = Helpdesk::find($id);
        if (!$ticket) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Ticket Not Found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $ticket->message = $message;
        if (!$ticket->save()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'An unexpected error occurred please try again letter.',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => new \stdClass(), 'message' => 'Message updated successfully',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * add credit/debit card
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCard(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name_on_card' => 'required',
            'card_number' => 'required|numeric',
            'expiration_date' => 'required',
            'cvv' => 'required|numeric',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required|numeric',
            'phone_number' => 'required',
            'agree' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'please fill all the fields',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        if (UserCard::where('user_id', auth()->user()->id)
            ->where('card_number', $request->card_number)->exists()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'this card is already added',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $card = new UserCard();
        $card->user_id = auth()->user()->id;
        $card->name = $request->name_on_card;
        $card->card_number = $request->card_number;
        $card->expiration_date = $request->expiration_date;
        $card->cvv = $request->cvv;
        $card->country = $request->country;
        $card->address = $request->address;
        $card->city = $request->city;
        $card->state = $request->state;
        $card->postal_code = $request->postal_code;
        $card->phone_number = $request->phone_number;
        if (!$card->save()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Oops! having some problems saving 
                your card please try again letter',
                'dev_message' => 'Card not saved in database', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $card, 'message' => 'card added successfully',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * debit/credit card list
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardList()
    {
        $cards = UserCard::with('user')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        if ($cards->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'cards not found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $cards, 'message' => 'list of all cards',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * update user's debit/credit card details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCard(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name_on_card' => 'required',
            'card_number' => 'required|numeric',
            'expiration_date' => 'required',
            'cvv' => 'required|numeric',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required|numeric',
            'phone_number' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'please fill all the fields',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        $card = UserCard::where('user_id', auth()->user()->id)
            ->where('id', $request->id)->first();
        if (!$card) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Card not found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $card->name = $request->name_on_card;
        $card->card_number = $request->card_number;
        $card->expiration_date = $request->expiration_date;
        $card->cvv = $request->cvv;
        $card->country = $request->country;
        $card->address = $request->address;
        $card->city = $request->city;
        $card->state = $request->state;
        $card->postal_code = $request->postal_code;
        $card->phone_number = $request->phone_number;
        if (!$card->save()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Facing problem in updating card details.',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $card, 'message' => 'Card details updated successfully',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * delete user's credit/debit card.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteCard(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        if (!UserCard::where('user_id', auth()->user()->id)->where('id', $request->id)->delete()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Error deleting this card',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => new \stdClass(), 'message' => 'Card deleted successfully',
            'dev_message' => '', 'code' => 1
        ]);
    }
}
