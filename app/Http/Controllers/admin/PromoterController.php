<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\PromoterModel;
use DB;
use Illuminate\Support\Facades\Hash;
use Session;

class PromoterController extends Controller
{
    var $objPromoterModel;

    /**
     * this function load models and authenticate user Request
     * PromoterController constructor.
     */
    public function __construct()
    {
        $this->objPromoterModel = new PromoterModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for promoter list
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promoterList(Request $request)
    {
        /*$data = PromoterModel::select('*')->where('is_delete', '0')->get();
        /*return view('admin.promoter.promoterList', compact('data'));*/
        return view('admin.promoter.promoterList');
    }

    /**
     * This method delete promoter
     * @param Request $request
     * @return int
     * @throws \Exception
     */
    public function deletePromoter(Request $request)
    {
        $resource = User::find($request->id);
        return $resource->delete() ? 0 : 1;
    }

    /**
     * This method active Inactive  Organizer
     * @param Request $request
     * @return false|string
     */
    public function activePromoter(Request $request)
    {
        $userId = $request->id;
        $userData = PromoterModel::find($userId);
        $userData['status'] = ($userData['status'] == 1) ? 0 : 1;
        $userData->save();
        return json_encode($userData['status']);
    }

    /**
     * This method active promoter detail
     * @param Request $requestData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promoterDetail(Request $requestData)
    {
        $promoterData = PromoterModel::find($requestData->id);
        return view('admin.promoter.promoterDetail', compact('promoterData'));
    }

    /**
     * show add promoter form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPromoter(Request $request)
    {
        return view('admin.promoter.addPromoter');
    }

    /**
     * show edit promoter form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePromoter(Request $request)
    {
        $data = PromoterModel::find($request->id);
        return view('admin.promoter.editPromoter', compact('data'));
    }

    /**
     * This method store/update promoter details into database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function savePromoter(Request $request)
    {
        $this->_user_validation($request);
        $requestData = unsetData($request->all(), array('_token', 'confirm_email'));
        $requestData['fb_url'] = checkUrl($requestData['fb_url']);
        $requestData['twitter'] = checkUrl($requestData['twitter']);
        $requestData['snapchat'] = checkUrl($requestData['snapchat']);
        $requestData['insta_url'] = checkUrl($requestData['insta_url']);
        // create new promoter
        if (empty($request->promoter_id)) {
            $requestData['email_confirm'] = 1;
            $requestData['email_confirm_code'] = '';
            $requestData['status'] = 0;
            $requestData['user_type'] = 3;
            $requestData['password'] = Hash::make($request->get('password'));
            $requestData['created_at'] = new \ DateTime();
            PromoterModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'promoterList')
                ->with('success_msg', 'Promoter added successfully.');
        }
        // update promoter details
        $promoter_id = $request->promoter_id;
        $requestData['updated_at'] = new \ DateTime();
        unset($requestData['promoter_id']);
        PromoterModel::where('id', $promoter_id)->update($requestData);
        return redirect(config('constants.ADMIN_URL') . 'promoterList')
            ->with('success_msg', 'Promoter updated successfully.');
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
     * this validate user email exist or not
     * @param Request $request
     * @return int
     */
    public function checkmail(Request $request)
    {
        $email = $request->email;
        $data = PromoterModel::where('email', $email)->count();
        return $data;
    }

    /**
     * export promoters data into csv file
     * @param Request $request
     */
    public function excelPromoter(Request $request)
    {
        $data = PromoterModel::selectRaw('id,first_name,last_name,email,mobile_number,location,unique_url,website,fb_url,insta_url,twitter,snapchat,about_promoter')
            ->where(['is_delete' => 0])
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
            'About Promoter'
        );
        generateCSV($header, $data, 'Promoters List.csv');
    }

    /**
     * Promoter List datatable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function PromoterListDatatable(Request $request)
    {
        $search = $request->input('search');
        $data = PromoterModel::select('*')
            ->when($search['value'], function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('email', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('mobile_number', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('website', 'LIKE', '%' . $search['value'] . '%');
                $query->orWhere('about_organizer', 'LIKE', '%' . $search['value'] . '%');
            })
            ->where('user_type', 3)
            ->orderBy('created_at', 'DESC')
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
}
