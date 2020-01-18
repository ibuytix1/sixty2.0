<?php

namespace App\Http\Controllers\api\v1;

use App\Model\Follow;
use App\Model\Helpdesk;
use App\Model\HelpdeskCategory;
use App\Model\HelpdeskImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Model\PromotionRequest;
use App\Model\organizer\Event_Model;
use App\User;

class PromotersController extends Controller
{

    public function checkUser()
    {
        if (auth()->user()->user_type != 3) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Not a promoter', 'code' => 0
            );
            return response()->json($response);
        }
        return false;
    }

    /**
     * Request Organizer to promote or sell event
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function promotionRequest(Request $request)
    {
        //check if the user is a promoter or a normal user
        // validate fields
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
            'request_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => new \ stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        }

        //search if the event is exists or not
        $event = Event_Model::find($request->get('event_id'));
        if (!$event) {
            return response()->json([
                'payload' => new \ stdClass(), 'message' => 'Event not found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        //check if this request already exists
        $promo_request = PromotionRequest::where('event_id', $event->id)
            ->where('promoter_id', auth()->user()->id)
            ->exists();
        if ($promo_request) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'you have already sent a promotion request for this event',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        //creating new request
        $promo_request = new PromotionRequest();
        $promo_request->organizer_id = $event->organizer_id;
        $promo_request->event_id = $event->id;
        $promo_request->promoter_id = auth()->user()->id;
        $promo_request->request_type = $request->get('request_type');
        $promo_request->request_status = 'pending';
        //save the request into database.
        if (!$promo_request->save()) {
            $request = array(
                'payload' => new \ stdClass(), 'message' => 'Request Not Sent',
                'dev_message' => 'error saving in database', 'code' => 0
            );
            return response()->json($request);
        }
        if (auth()->user()->user_type == 1) {
            $user = User::find(auth()->user()->id);
            $user->user_type = 3;
            $user->save();
            $response = [
                'payload' => $promo_request, 'message' => 'Promotion request sent successfully. You are now a Promoter',
                'dev_message' => '', 'code' => 1
            ];
        } else {
            $response = array(
                'payload' => $promo_request, 'message' => 'Promotion request sent successfully.',
                'dev_message' => '', 'code' => 1
            );
        }
        return response()->json($response);
    }

    /**
     * get all my promo request
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function getAllPromo(Request $request)
    {
        $request_type = $request->get('request_type');
        if($request_type == 'pending'){
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        }else if($request_type == 'rejected'){
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        }else if($request_type == 'accepted'){
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        }else{
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)->paginate(10);
        }
        if ($promotion->isEmpty()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No Promotion Request Found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $promotion, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    // promoter becomes organizer
    public function becomesOrganizer()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->count() == 0) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'no user found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        if ($user->user_type == 2) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'You are already an organizer',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $user->user_type = 2;
        $user->save();
        $response = array(
            'payload' => $user, 'message' => 'successfully registered as an organizer',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * list of the following organizer.
     * @return mixed
     */
    public function getFollowing(){
        $id = auth()->user()->id;
        $following = Follow::with('organizer')->where('follower_user_id', $id)
            ->orderBy('created_at', 'DESC')->paginate(10);
        if($following->isEmpty()){
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'You are not following any organizer',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $following, 'message' => 'list of following',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * get list of all the helpdesk categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpdeskCategories()
    {
        $helpdesk_categories = HelpdeskCategory::all();
        if ($helpdesk_categories->count() == 0) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No Category Found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $helpdesk_categories, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }


    /**
     * create a helpdesk ticket
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
                'dev_message' => $validator->errors(),'code' => 0
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
                'dev_message' => '','code' => 0
            );
            return response()->json($response);
        }
        $organizer_email = User::find($organizer_id)->email;
        if (!HelpdeskCategory::where('id', $help_category)->exists()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Helpdesk category not found',
                'dev_message' => '','code' => 0
            );
            return response()->json($response);
        }

        /*if (Helpdesk::where('user_id', $user_id)->where('organizer_id', $organizer_id)
            ->where('category_id', $help_category)->exists()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Helpdesk ticket already found.',
                'dev_message' => '','code' => 0
            );
            return response()->json($response);
        }*/

        $helpdesk = new Helpdesk();
        $helpdesk->user_id = $user_id;
        $helpdesk->organizer_id = $organizer_id;
        $helpdesk->category_id = $help_category;
        $helpdesk->subject = $subject;
        $helpdesk->message = $message;
        $helpdesk->status = $status;
        $helpdesk->save();
        if ($request->hasFile('image_one')) {
            $image = $request->image_one;
            $name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path() . '/helpdesk', $name);
            $help_image_one = new HelpdeskImages();
            $help_image_one->helpdesk_id = $helpdesk->id;
            $help_image_one->image = $name;
            $help_image_one->save();

        }
        if ($request->hasFile('image_two')) {
            $image = $request->image_two;
            $name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path() . '/helpdesk', $name);
            $help_image_two = new HelpdeskImages();
            $help_image_two->helpdesk_id = $helpdesk->id;
            $help_image_two->image = $name;
            $help_image_two->save();

        }
        if ($request->hasFile('image_three')) {
            $image = $request->image_three;
            $name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path() . '/helpdesk', $name);
            $help_image_three = new HelpdeskImages();
            $help_image_three->helpdesk_id = $helpdesk->id;
            $help_image_three->image = $name;
            $help_image_three->save();
        }
        if ($request->hasFile('image_four')) {
            $image = $request->image_four;
            $name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path() . '/helpdesk', $name);
            $help_image_four = new HelpdeskImages();
            $help_image_four->helpdesk_id = $helpdesk->id;
            $help_image_four->image = $name;
            $help_image_four->save();
        }
        Mail::send([], [], function ($mess) use ($organizer_email, $subject, $message) {
            $mess->from('noreply@ibuytix.com', $subject);
            $mess->to($organizer_email)->subject($subject)->setBody($message);
        });
        $response = array(
            'payload' => $helpdesk, 'message' => 'Helpdesk ticket created successfully',
            'dev_message' => '','code' => 1
        );
        return response()->json($response);
    }

    /**
     * get list of all the helpdesk ticket of current logged in user.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpdeskTickets()
    {
        $help_ticket = Helpdesk::with('images', 'category', 'organizer')
            ->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')
            ->paginate(10);
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

    /**
     * get the details of a help desk ticket.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpdeskTicket(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'helpdesk_id' => 'required|numeric',
        ));
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(),'code' => 0
            );
            return response()->json($response);
        }
        $user_id = auth()->user()->id;
        $helpdesk_id = $request->get('helpdesk_id');
        $helpdesk = Helpdesk::with('images', 'category', 'organizer')
            ->where('user_id', $user_id)->find($helpdesk_id);
        if (!$helpdesk) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No helpdesk ticket found',
                'dev_message' => '','code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $helpdesk, 'message' => '',
            'dev_message' => '','code' => 1
        );
        return response()->json($response);
    }

    /**
     * update message sent to support team.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateHelpdeskMessage(Request $request){
        $validate = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'message' => 'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        $id = $request->get('id');
        $message = $request->get('message');
        $ticket = Helpdesk::find($id);
        if(!$ticket){
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Ticket Not Found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        $ticket->message = $message;
        if(!$ticket->save()){
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

}

