<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\PlanModel;


use DB;
use Session;
class PlanController extends Controller
{
   var $objPlanModel;
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
        $this->objPlanModel = new PlanModel(); 
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
    public function planList(Request $request)
    {
        $data = PlanModel::get();
        return view('admin.plans.planList', compact('data'));
    }
     /**
    * @Author:          Rishikesh
    * @Last modified:   <15-03-2018>
    * @Project:         <Event Ticketing>
    * @Function:        <Add Plan>  
    * @Description:     <This function  use for add category>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
     public function addPlan(Request $request)
     {
        $data = array();
        return view('admin.plans.addPlans', $data);
    }
      /**
    * @Author:          Rishikesh
    * @Last modified:   <15-03-2018>
    * @Project:         <Event Ticketing>
    * @Function:        <View Plan>  
    * @Description:     <This function  use for add category>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
      public function viewPlan(Request $request)
      {
        $id = $request->id;
        $data = PlanModel::find($id); 
        return view('admin.plans.viewPlan', compact('data'));
    }
     /*
     * @Class:           <PlanController>
     * @Function:        <savePlan>
     * @Author:          Rishikesh Singh
     * @Created On:      <15-03-2018>
     * @Last Modified By:
     * @Last Modified: 
     * @Description:     < This methode save category>
     */
     public function savePlan(Request $request) 
     {

        $this->_user_validation($request);
        $requestData = unsetData($request->all(), array('_token'));
        $requestData['plan_expiry_date'] = strtotime($requestData['plan_expiry_date']);
        
        if(empty($request->planId)) 
        {
            if(PlanModel::where('plan_title',$requestData['plan_title'])->count())
            {
                return redirect(config('constants.ADMIN_URL') . 'add-plans')->with('success_msg', 'Plan already exist.');
            }
            $requestData['created_at'] = time();
            PlanModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'add-plans')->with('success_msg', 'Plan added successfully.');
        }
        else 
        {
            $planId = $request->planId;
            $requestData['updated_at'] = time();
            unset($requestData['planId']);
            PlanModel::where('id', $planId)->update($requestData);
            return redirect(config('constants.ADMIN_URL') . 'list-plans')->with('success_msg', 'Plan updated successfully.');
        }
    }
     /*
     * @Class:           <PlanController>
     * @Function:        <updatePlan>
     * @Author:          Rishikesh Singh
     * @Created On:      <15-03-2018>
     * @Last Modified By:
     * @Last Modified: 
     * @Description:     < This methode update category>
     */
     public function editPlan(Request $request)
     {
        $id = $request->id;
        $data = PlanModel::find($id);
        return view('admin.plans.editPlan',compact('data'));
    }
      /*
     * @Class:           <PlanController>
     * @Function:        <deletePlan>
     * @Author:          Rishikesh Singh
     * @Created On:      <15-03-2018>
     * @Last Modified By:
     * @Last Modified: 
     * @Description:     < This methode delete Category>
     */
      public function deletePlan(Request $request)
      {
        $planId = $request->id;
        $resource = PlanModel::where('id',$planId);
        $resource->delete();

    }

      /**
    * @Author:          Rishikesh
    * @Last modified:   <15-03-2019>
    * @Project:        <Event Ticketing>
    * @Function:        <_user_validation>
    * @Description:     <this validate user inputs>
    * @Parameters:      <>
    * @Method:          <NO>
    * @Returns:         <Yes>
    * @Return Type:     <error>
    */
      private function _user_validation(Request $request){
        $this->validate($request, [
            'plan_title' => 'required',
            'plan_expiry_date' => 'required|date',
            'plan_price'=>'required',
            'plan_description'=>'required',
        ]);
        return;
    }
}
