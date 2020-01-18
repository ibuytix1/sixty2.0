<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\OrganizerModel;
use Excel;

use DB;
use Illuminate\Support\Facades\Hash;
use Session;

class OrganizerController extends Controller
{
    var $objOrganizer;

    /**
     * this function load models and authenticate user Request
     * OrganizerController constructor.
     */
    public function __construct()
    {
        $this->objCategoryModel = new OrganizerModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for Organizer list
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function OrganizerList(Request $request)
    {
        /*$data = OrganizerModel::select('*')
        ->where(['is_delete' => 0])
        ->get();*/
        $data = OrganizerModel::where('user_type', 2)->get();
        return view('admin.Organizer.OrganizerList', compact('data'));
    }

    /**
     * This function  use for add Organizer
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addOrganizer(Request $request)
    {
        $data = array();
        return view('admin.Organizer.addOrganizer', $data);
    }

    /**
     * This method save category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function saveOrganizer(Request $request)
    {
        $this->_user_validation($request);
        $requestData = unsetData($request->all(), array('_token', 'confirm_email'));
        $requestData['fb_url'] = checkUrl($requestData['fb_url']);
        $requestData['twitter'] = checkUrl($requestData['twitter']);
        $requestData['snapchat'] = checkUrl($requestData['snapchat']);
        $requestData['insta_url'] = checkUrl($requestData['insta_url']);

        if (empty($request->organizer_id)) {
            $requestData['email_confirm'] = 1;
            $requestData['email_confirm_code'] = '';
            $requestData['status'] = 0;
            $requestData['user_type'] = 2;
            $requestData['password'] = Hash::make($request->get('password'));
            $requestData['created_at'] = new \ DateTime();
            OrganizerModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'listOrganizer')
                ->with('success_msg', 'Organizer added successfully.');
        }
        $organizer_id = $request->organizer_id;
        $requestData['updated_at'] = new \ DateTime();
        unset($requestData['organizer_id']);
        OrganizerModel::where('id', $organizer_id)->update($requestData);
        return redirect(config('constants.ADMIN_URL') . 'listOrganizer')
            ->with('success_msg', 'Orgnizer updated successfully.');
    }

    /**
     * This method update Organizer
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editOrganizer(Request $request)
    {
        $id = $request->id;
        $data = OrganizerModel::select('*')
            ->where(['id' => $id])
            ->first();
        return view('admin.Organizer.editOrganizer', compact('data'));
    }

    /**
     * This method delete Organizer
     * @param Request $request
     * @throws \Exception
     */
    public function deleteOrganizer(Request $request)
    {
        $organizerId = $request->id;
        $resource = OrganizerModel::where('id', $organizerId);
        $resource->delete();
    }

    /**
     * This method active Inactive  Organizer
     * @param Request $request
     * @return false|string
     */
    public function activeOrgnizer(Request $request)
    {
        $orgnizerId = $request->input('id');
        $orgnizerData = OrganizerModel::find($orgnizerId);
        $orgnizerData['status'] = ($orgnizerData['status'] == 1) ? 0 : 1;
        $orgnizerData->save();
        return json_encode($orgnizerData['status']);
    }

    /**
     * This method display Organizer details
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewOrgnizerProfile(Request $request)
    {
        $orgnizerId = $request->id;
        $organizerData = OrganizerModel::find($orgnizerId);
        return view('admin.Organizer.viewOrgnizerProfile', compact('organizerData'));
    }


    /**
     * this validate user inputs
     * @param Request $request
     */
    private function _user_validation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);
        return;
    }

    /**
     * convert organizers list into cvv
     * @param Request $request
     */
    public function excelOrginer(Request $request)
    {
        $data = OrganizerModel::selectRaw('id,first_name,last_name,email,mobile_number,location,unique_url,website,fb_url,insta_url,twitter,snapchat,about_organizer')
            ->where('user_type', 2)
            ->get()->toArray();
        $header = array(
            'id',
            'First Name',
            'Last Name',
            'Email',
            'Mobile Number',
            'Location',
            'Unique Url',
            'Website',
            'Facebook',
            'Instagram',
            'Twitter',
            'Snapchat',
            'About Organizer'
        );
        generateCSV($header, $data, 'Organizers.csv');
    }

    /**
     * send organizers list for datatable to show list of organizers.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function OrganizerListDatatable(Request $request)
    {
        $search = $request->input('search');
        $data = OrganizerModel::select('*')
            ->when($search['value'], function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('email', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('mobile_number', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('website', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('about_organizer', 'LIKE', '%' . $search['value'] . '%');
            })
            ->where('user_type', 2)
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
                $value->first_name . ' ' . $value->last_name,
                $value->email,
                $value->mobile_number,
                $value->website,
                $value->about_organizer,
                $value->status,
                $index
            ]);
        }
        return response()->json($resourceDatatable);
    }

    /**
     * @param Request $request
     * @return int
     */
    public function checkmail(Request $request)
    {
        $email = $request->email;
        $data = OrganizerModel::where('email',$email)->count();
        return $data;
    }

}