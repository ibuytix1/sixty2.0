<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\CategoryModel;


use DB;
use Session;

class CategoryController extends Controller
{
    var $objCategoryModel;


    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-feb-2019>
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
        $this->objCategoryModel = new CategoryModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-02-2019>
     * @Project:         <Event Ticketing>
     * @Function:        <Home Page>
     * @Description:     <This function  use for admin Dashboard>
     * @Parameters:      <NO>
     * @Method:          <NO>
     * @Returns:         <NO>
     * @Return Type:     <NO>
     */
    public function categoryList(Request $request)
    {
        $data = CategoryModel::select('id', 'category_name')
            ->where(['is_delete' => 0])
            ->get();
        return view('admin.category.categoryList', compact('data'));
    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-02-2019>
     * @Project:         <Event Ticketing>
     * @Function:        <Add Category>
     * @Description:     <This function  use for add category>
     * @Parameters:      <NO>
     * @Method:          <NO>
     * @Returns:         <NO>
     * @Return Type:     <NO>
     */
    public function addCategory(Request $request)
    {
        $data = array();
        return view('admin.category.addCategory', $data);
    }

    /*
    * @Class:           <CategoryController>
    * @Function:        <saveCategory>
    * @Author:          Rishikesh Singh
    * @Created On:      <22-Feb-2019>
    * @Last Modified By:
    * @Last Modified:
    * @Description:     < This methode save category>
    */
    public function saveCategory(Request $request)
    {


        $requestData = unsetData($request->all(), array('_token'));
        if (empty($request->categoryId)) {
            $this->_data_validation($request);

            $requestData['created_at'] = date('y-m-d h:i:s');

            CategoryModel::insert($requestData);

            return redirect(config('constants.ADMIN_URL') . 'addCategory/')->with('success_msg', 'Category added successfully.');
        } else {

            $this->_data_validation_update($request);
            $categoryId = $request->categoryId;
            $requestData['updated_at'] = date('y-m-d h:i:s');
            unset($requestData['categoryId']);

            CategoryModel::where('id', $categoryId)->update($requestData);

            return redirect(config('constants.ADMIN_URL') . 'listCategory')->with('success_msg', 'Category updated successfully.');
        }
    }

    /*
    * @Class:           <CategoryController>
    * @Function:        <updateCategory>
    * @Author:          Rishikesh Singh
    * @Created On:      <22-Feb-2019>
    * @Last Modified By:
    * @Last Modified:
    * @Description:     < This methode update category>
    */
    public function editCategory(Request $request)
    {
        $id = $request->id;
        $data = CategoryModel::select('id', 'category_name', 'category_description')
            ->where(['id' => $id])
            ->first();
        return view('admin.category.editCategory', compact('data'));
    }

    /*
   * @Class:           <CategoryController>
   * @Function:        <deleteCategory>
   * @Author:          Rishikesh Singh
   * @Created On:      <22-Feb-2019>
   * @Last Modified By:
   * @Last Modified:
   * @Description:     < This methode delete Category>
   */
    public function deleteCategory(Request $request)
    {
        $categoryId = $request->id;
        $resource = CategoryModel::where('id', $categoryId);
        $resource->delete();

    }

    /*
    * @Class:           <CategoryController>
    * @Function:        <deleteCategory>
    * @Author:          Rishikesh Singh
    * @Created On:      <22-Feb-2019>
    * @Last Modified By:
    * @Last Modified:
    * @Description:     < This methode delete Category>
    */
    public function listCategoryJson(Request $request)
    {

        $search = $request->input('search');
        $data = CategoryModel::select('*')
            ->when($search['value'], function ($query) use ($search) {

                $query->where('category_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('category_description', 'LIKE', '%' . $search['value'] . '%');

            })
            ->paginate(10);
        //dd($data);
        $resourceDatatable = array(

            //"search":$search,
            "recordsTotal" => $data->total(),
            "recordsFiltered" => $data->total(),
            "recordsTotal" => $data->total(),
            "data" => array(),


        );

        foreach ($data as $key => $value) {

            $index = ($data->currentPage() - 1) . $key + 1;

            array_push($resourceDatatable["data"], [
                $value->id,
                $value->category_name,
                $value->category_description,
                $index
            ]);

        }

        return response()->json($resourceDatatable);

    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <1-04-2019>
     * @Project:        <Event Ticketing>
     * @Function:        <_data_validation>
     * @Description:     <this validate user inputs>
     * @Parameters:      <>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <error>
     */
    private function _data_validation(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|unique:event_category,category_name'
        ]);
        return;
    }

    private function _data_validation_update(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required'
        ]);
        return;
    }
}

