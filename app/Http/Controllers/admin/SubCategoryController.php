<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Model\admin\SubCategoryModel;

use App\Model\admin\CategoryModel;


use DB;

use Session;

class SubCategoryController extends Controller

{

    var $objSubCategoryModel;

    /**
     * this function load models and authenticate user Request
     * SubCategoryController constructor.
     */
    public function __construct()
    {
        $this->objSubCategoryModel = new SubCategoryModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for admin Dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subCategoryList(Request $request)
    {
        return view('admin.subcategory.subCategoryList');
    }

    /**
     * add sub category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addSubcategory(Request $request)
    {
        $categoryList = CategoryModel::where(['is_delete' => 0])->pluck('category_name', 'id');
        return view('admin.subcategory.addSubCategory', compact('categoryList'));
    }

    /**
     * This method save Sub category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSubCategory(Request $request)
    {
        $requestData = unsetData($request->all(), array('_token'));
        if (empty($request->subcategory_id)) {
            $requestData['created_at'] = date('y-m-d h:i:s');
            SubCategoryModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'addSubCategory')
                ->with('success_msg', ' Sub Category added successfully.');
        } else {
            $subCategoryId = $request->subcategory_id;
            $requestData['updated_at'] = date('y-m-d h:i:s');
            unset($requestData['subcategory_id']);
            SubCategoryModel::where('id', $subCategoryId)->update($requestData);
            return redirect(config('constants.ADMIN_URL') . 'listSubCategory')
                ->with('success_msg', 'Sub Category updated successfully.');
        }
    }

    /**
     * This method update category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editSubCategory(Request $request)
    {
        $id = $request->id;
        $data = SubCategoryModel::with('REL_Category_Subcategory')
            ->select('id', 'category_id', 'subcategory_name')
            ->where(['id' => $id])
            ->first();
        $categoryList = CategoryModel::where(['is_delete' => 0])->pluck('category_name', 'id');
        return view('admin.subcategory.editSubCategory', compact('data', 'categoryList'));
    }

    /**
     * This method delete Category
     * @param Request $request
     * @throws \Exception
     */
    public function deleteSubCategory(Request $request)
    {
        $categoryId = $request->id;
        $resource = SubCategoryModel::where('id', $categoryId);
        $resource->delete();
    }

    /**
     * this validate user input
     * @param Request $request
     */
    private function _user_validation(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);
        return;
    }

    /**
     * this return data in datatable format
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSubCategoryJson(Request $request)
    {
        $search = $request->input('search');
        $data = DB::table('event_subcategory as SC')
            ->selectRaw('
                        SC.id,
                        SC.subcategory_name,
                        EC.category_name
                    ')
            ->leftjoin('event_category as EC', 'EC.id', '=', 'SC.category_id')
            ->when($search['value'], function ($query) use ($search) {
                $query->where('subcategory_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orwhere('category_name', 'LIKE', '%' . $search['value'] . '%');
            })
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
                $value->category_name,
                $value->subcategory_name,
                $index
            ]);
        }
        return response()->json($resourceDatatable);
    }
}
