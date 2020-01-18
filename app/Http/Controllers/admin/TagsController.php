<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\TagsModel;
use DB;
use Session;

class TagsController extends Controller
{
    var $objTagsModel;


    /**
     * this function load models and authenticate user Request
     * TagsController constructor.
     */
    public function __construct()
    {
        $this->objTagsModel = new TagsModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for admin Dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tagList(Request $request)
    {
        return view('admin.tags.tagsList');
    }

    /**
     * This function  use for add category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addTag(Request $request)
    {
        $data = array();
        return view('admin.tags.addTags', $data);
    }

    /**
     * This methode save category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveTag(Request $request)
    {
        $requestData = unsetData($request->all(), array('_token'));
        if (empty($request->tagId)) {
            $this->_data_validation($request);
            $requestData['created_at'] = date('y-m-d h:i:s');
            TagsModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'addTag/')
                ->with('success_msg', 'Tag added successfully.');
        } else {
            $this->_data_validation_update($request);
            $tagId = $request->tagId;
            $requestData['updated_at'] = date('y-m-d h:i:s');
            unset($requestData['tagId']);
            TagsModel::where('id', $tagId)->update($requestData);
            return redirect(config('constants.ADMIN_URL') . 'listTags')
                ->with('success_msg', 'Tag updated successfully.');
        }
    }

    /**
     * This method update category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editTag(Request $request)
    {
        $id = $request->id;
        $data = TagsModel::select('id', 'tag')
            ->where(['id' => $id])
            ->first();
        return view('admin.tags.editTags', compact('data'));
    }

    /**
     * This method delete Category
     * @param Request $request
     * @throws \Exception
     */
    public function deleteTag(Request $request)
    {
        $tagId = $request->id;
        $resource = TagsModel::where('id', $tagId);
        $resource->delete();
    }

    /**
     * This method delete Category
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listTagJson(Request $request)
    {
        $search = $request->input('search');
        $data = TagsModel::select('*')
            ->when($search['value'], function ($query) use ($search) {
                $query->where('tag', 'LIKE', '%' . $search['value'] . '%');
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
                $value->tag,
                $index
            ]);
        }
        return response()->json($resourceDatatable);
    }

    /**
     * this validate user inputs
     * @param Request $request
     */
    private function _data_validation(Request $request)
    {
        $this->validate($request, [
            'tag' => 'required|unique:tags,tag'
        ]);
        return;
    }

    /**
     * this validate user inputs
     * @param Request $request
     */
    private function _data_validation_update(Request $request)
    {
        $this->validate($request, [
            'tag' => 'required'
        ]);
        return;
    }
}
