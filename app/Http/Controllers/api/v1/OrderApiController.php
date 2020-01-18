<?php

namespace App\Http\Controllers\api\v1;

use App\Model\admin\TicketModel;
use App\Model\Order;
use App\Model\OrderTicket;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use phpDocumentor\Reflection\Types\Integer;

class OrderApiController extends Controller
{
    public function __construct(){
        ini_set('max_execution_time', '120'); //300 seconds = 5 minutes
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $order = new Order();
        $order_data = $request->all();
        $order->customer_id = auth()->user()->id;
        $order->event_id = $order_data['event']['id'];
        $order->organizer_id = $order_data['event']['organizer_id'];

        $order->purchaser_first_name = $order_data['buyer']['first_name'];
        $order->purchaser_last_name = $order_data['buyer']['last_name'];
        $order->purchaser_email = $order_data['buyer']['email'];
        $order->purchaser_phone = $order_data['buyer']['phone'];
        $order->billing_address = $order_data['buyer']['billing_address'];
        $order->billing_address_2 = $order_data['buyer']['billing_address_2'];
        $order->billing_country = $order_data['buyer']['billing_country'];
        $order->billing_city = $order_data['buyer']['billing_city'];
        $order->billing_state = $order_data['buyer']['billing_state'];
        $order->billing_zip = $order_data['buyer']['billing_zip'];
        $order->billing_landmark = $order_data['buyer']['billing_landmark'];
        $order->ticket_details = json_encode($order_data['ticket_details']);
        $order->total_amount = $order_data['total_price'];
        $order->coupon_id = $order_data['coupon']['id'];
        $order->status = $order_data['status'];
        $order->payer_email = $order_data['payer']['email_address'];
        $order->payer_first_name = $order_data['payer']['name']['given_name'];
        $order->payer_last_name = $order_data['payer']['name']['surname'];
        $order->payer_id = $order_data['payer']['payer_id'];
        $order->checkin_status = false;
        $order->payed_with = '';
        $order->barcode = $order->generateBarcodeNumber();

        $order->save();
        if($order_data['ticket_details']){
            foreach($order_data['ticket_details'] as $ticket){
                if($ticket['selected'] > 0){
                    $order_ticket = new OrderTicket();
                    $order_ticket->order_id = $order->id;
                    $order_ticket->event_id = $ticket['event_id'];
                    $order_ticket->ticket_id = $ticket['id'];
                    $order_ticket->quantity = $ticket['selected'];
                    $order_ticket->price = $ticket['price'];
                    $order_ticket->ticket_type = $ticket['ticket_type'];
                    $order_ticket->event_type = $ticket['event_type'];
                    $order_ticket->total_price = $ticket['selected'] * $ticket['price'];
                    $order_ticket->attendees = $ticket['attendees'];
                    $order_ticket->save();
                    //updating ticket quantity in event_tickets table
                    if($order->total_amount == 0 && $order->status == 'completed') {
                        $event_ticket = TicketModel::find($ticket['id']);
                        $event_ticket->quantity = $event_ticket->quantity - $ticket['selected'];
                        $event_ticket->save();
                    }
                }
            }
        }
        if($order->total_amount == 0 && $order->status == 'completed'){
            $this->sendTicketEmail($order->id);
        }

        $response = [
            'payload' => $order, 'message' => 'Order Created Successfully!',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * update order details after payment.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        // validation
        $validate = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'status' => 'required'
        ]);
        if($validate->fails()){
            return response()->json(array(
                'payload' => new \stdClass(), 'message' => 'validation failed',
                'dev_message' => $validate->errors(), 'code' => 0
            ));
        }
        // setting payer details
        $payer_id = $request->get('payer_id');
        $payer_first_name = $request->get('payer_first_name');
        $payer_last_name = $request->get('payer_last_name');
        $payer_email = $request->get('payer_email');
        $payed_with = $request->get('payed_with');
        // getting order details
        $order = Order::with('order_tickets', 'event', 'user')->find($request->get('order_id'));
        // error if order not found
        if(!$order){
            return response()->json(array(
                'payload' => new \stdClass(), 'message' => 'Order not found',
                'dev_message' => '', 'code' => 0
            ));
        }
        // setting payment details
        $order->status = $request->get('status');
        $order->payer_id = $payer_id;
        $order->payer_first_name = $payer_first_name;
        $order->payer_last_name = $payer_last_name;
        $order->payer_email = $payer_email;
        $order->payed_with = $payed_with;
        // reducing quantity of tickets form the database after success full payment
        foreach($order->order_tickets as $ticket){
            $event_ticket = TicketModel::find($ticket->ticket_id);
            $event_ticket->quantity = $event_ticket->quantity - $ticket->quantity;
            $event_ticket->save();
        }
        // updating payment details of order
        if(!$order->save()){
            return response()->json(array(
                'payload' => new \stdClass(), 'message' => 'Values not updated please contact support.',
                'dev_message' => 'Payer data not updated in database.', 'code' => 0
            ));
        }
        if($order->payed_with == 'paypal' && strtolower($order->status) == 'completed'){
            $this->sendTicketEmail($order->id);
        }
        $response = [
            'payload' => $order, 'message' => 'Payment Data updated Successfully!',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * send ticket details to user on email id.
     * @param $order_id
     * @return bool
     */
    public function sendTicketEmail($order_id)
    {
        // get order details with event details and user details.
        $order = Order::with('event', 'user')->find($order_id);
        if(!$order){
            return false;
        }
        // path to store pdf file
        $pdf_path = public_path('ticket/pdf/'.$order->barcode);
        // object to store necessary values for email and pdf view template rendering
        $data = new \stdClass();
        $data->title = 'Ticket Details';
        $data->order = $order;
        $data->name = $order->user->first_name . ' ' . $order->user->last_name;
        $data->event = $order->event;
        $data->email = $order->user->email;
        // generating QR code for ticket
        $d2 = new DNS2D();
        $d2->setStorPath(public_path('ticket/barcode/'));
        $d2->getBarcodePNGPath($order->barcode, "QRCODE", 7, 7);
        // generating C39 code for ticket
        $d1 = new DNS1D();
        $d1->setStorPath(public_path('ticket/barcode/c39/'));
        $d1->getBarcodePNGPath($order->barcode, 'C39');
        // setting path of the generated barcode image
        $data->barcode_path = asset('public/ticket/barcode/' . $order->barcode . '.png');
        $data->barcode_c39 = asset('public/ticket/barcode/c39/' . $order->barcode . '.png');
        // converting file into pdf and saving into directory
        PDF::loadView('mails.ticket', ['data' => $data])->save($pdf_path.'.pdf');
        // sending ticket in email with the pdf file attached
        Mail::send('mails.ticket', ['data' => $data], function ($message) use ($data, $pdf_path){
            $message->to($data->email)->subject("Event Ticket");
            $message->attach($pdf_path . '.pdf', [
                'as' => 'ticket.pdf',
                'mime' => 'application/pdf',
            ]);
        });
        return true;
    }

}
