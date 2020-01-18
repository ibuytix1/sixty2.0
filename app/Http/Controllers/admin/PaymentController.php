<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\PaymentModel;


use DB;
use Session;
class PaymentController extends Controller
{
   var $objPaymentModel;
    /**
    * @Author:          Rishikesh
    * @Last modified:   15-03-2018
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
        $this->objPaymentModel = new PaymentModel(); 
        $this->middleware('CheckAdminLogin');
       
    }
    /**
    * @Author:          Rishikesh
    * @Last modified:   15-03-2018
    * @Project:         <Event Ticketing>
    * @Function:        <List plan>  
    * @Description:     <This function  use for admin Dashboard>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
    public function listPayment(Request $request)
    {
        $data = PaymentModel::get();
        return view('admin.payment.paymentList', compact('data'));
    }
}
