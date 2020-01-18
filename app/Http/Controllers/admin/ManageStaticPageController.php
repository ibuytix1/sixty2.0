<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\ManageStaticPageModel;


use DB;
use Session;
class ManageStaticPageController extends Controller
{
     var $objcmspage;


    /**
    * @Author:          Rishikesh
    * @Last modified:  <14-03-2019>
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
        $this->objcmspage = new ManageStaticPageModel(); 
        $this->middleware('CheckAdminLogin');
    }

    /**
    * @Author:           Rishikesh
    * @Last modified:   <14-03-2019>
    * @Project:         <Event Ticketing>
    * @Function:        <List CMS Pages>  
    * @Description:     <This function  cms page list>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
    public function cmspagelist(Request $request)
    {
        $data  = ManageStaticPageModel::get();
        return view('admin.cmspage.cmspageslist',compact('data'));
    }
    /**
    * @Author:           Rishikesh
    * @Last modified:   <14-03-2019>
    * @Project:         <Event Ticketing>
    * @Function:        <Add CMS Pages>  
    * @Description:     <This function  use for add page view>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
    public function addcmspages(Request $request)
    {
        
        return view('admin.cmspage.addCmsPages');
    }

       /*
     * @Class:           <ManageStaticPageController>
     * @Function:        <saveCMSPage>
     * @Author:          Rishikesh Singh
     * @Created On:      <14-03-2019>
     * @Last Modified By:
     * @Last Modified: 
     * @Description:     < This methode save cms page data>
     */
    public function saveCmsPages(Request $request) {

        $this->_user_validation($request);
        $requestData = unsetData($request->all(), array('_token'));
        
        if (empty($request->pageId)) 
        {
            $requestData['created_at'] = time();
            if(ManageStaticPageModel::where('page_title',$requestData['page_title'])->count())
            {
                 return redirect(config('constants.ADMIN_URL') . 'add-cms-pages')->with('success_msg', 'Page already exist you want to change it please update.');
            }
            ManageStaticPageModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') .'add-cms-pages')->with('success_msg', 'Page added successfully.');
        } 
        else 
        {
            $pageId = $request->pageId;
            $requestData['updated_at'] = time();
            unset($requestData['pageId']);
            ManageStaticPageModel::where('id', $pageId)->update($requestData);
            return redirect(config('constants.ADMIN_URL') . 'cms-pages-list')->with('success_msg', 'Page updated successfully.');
        }
    }

     /**
    * @Author:           Rishikesh
    * @Last modified:   <14-03-2019>
    * @Project:         <Event Ticketing>
    * @Function:        <Edit CMS Pages>  
    * @Description:     <This function  use for admin Dashboard>
    * @Parameters:      <NO>
    * @Method:          <NO>
    * @Returns:         <NO>
    * @Return Type:     <NO>
    */
    public function editCmsPage(Request $request)
    {   
        $id = $request->id;
        $data = ManageStaticPageModel::find($id);
        return view('admin.cmspage.editCmsPage',compact('data'));
    }

    /**
    * @Author:          Rishikesh
    * @Last modified:   <14-03-2019>
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
            'title' => 'required',
            'page_description' => 'required',
            'page_title' => 'required',
            'page_keyword' => 'required',
        ]);
        return;
    }
}
