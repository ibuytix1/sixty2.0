<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Model\admin\UserModel;
use DB;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    var $objUserModel;

    /**
     * this function load models and authenticate user Request
     * UserController constructor.
     */
    public function __construct()
    {
        $this->objUserModel = new UserModel();
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for admin Dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersList(Request $request)
    {
        return view('admin.users.usersList');
    }

    /**
     * add user view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AddUser()
    {
        return view('admin.users.addUsers');
    }

    /**
     * This method save user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function saveUsers(Request $request)
    {
        $requestData = unsetData($request->all(), array('_token'));
        if (empty($request->userId)) {
            $requestData['email_confirm'] = 1;
            $requestData['email_confirm_code'] = '';
            $requestData['status'] = 0;
            $requestData['user_type'] = 1;
            $requestData['password'] = Hash::make($request->get('password'));
            $requestData['created_at'] = new \ DateTime();
            UserModel::insert($requestData);
            return redirect(config('constants.ADMIN_URL') . 'usersList/')
                ->with('success_msg', 'User added successfully.');
        }
        $userId = $request->userId;
        $requestData['updated_at'] = new \ DateTime();
        unset($requestData['userId']);
        UserModel::where('id', $userId)->update($requestData);
        return redirect(config('constants.ADMIN_URL') . 'usersList')
            ->with('success_msg', 'User updated successfully.');
    }

    /**
     * This method delete Category
     * @param Request $request
     * @return int
     * @throws \Exception
     */
    public function deleteUser(Request $request)
    {
        $user = UserModel::find($request->id);
        return ($user->delete()) ? 0 : 1;
    }

    /**
     * This method active Inactive  Organizer
     * @param Request $request
     * @return false|string
     */
    public function activeUser(Request $request)
    {
        $userId = $request->id;
        $userData = UserModel::find($userId);
        $userData['status'] = ($userData['status'] == 1) ? 0 : 1;
        $userData['updated_at'] = time();
        $userData->save();
        return json_encode($userData['status']);
    }

    /**
     * This method active Inactive  Organizer
     * @param Request $requestData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userDetail(Request $requestData)
    {
        $user = UserModel::find($requestData->id);
        return view('admin.users.usersDetail', compact('user'));
    }

    /**
     * this validate user inputs
     * @param Request $request
     */
    public function excelUsers(Request $request)
    {
        $data = UserModel::selectRaw('id,first_name,last_name,email,mobile_number')
            ->where('user_type', 1)
            ->get()->toArray();
        $header = array(
            'Id',
            'First name',
            'Last Name',
            'Email',
            'Mobile No'
        );
        generateCSV($header, $data, 'Users List.csv');
    }

    /**
     * this validate user mail exist or not
     * @param Request $request
     * @return int
     */
    public function checkUserEmailExist(Request $request)
    {
        return user::where('email',  $request->email)->count();
    }

    /**
     * user data for datatable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listUserJson(Request $request)
    {
        $search = $request->input('search');
        $data = User::select('*')
            ->when($search['value'], function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', '%' . $search['value'] . '%');
                    $query->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search['value'] . '%');
                    $query->orWhere('mobile_number', 'LIKE', '%' . $search['value'] . '%');
                });
            })
            ->where('user_type', 1)
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
                $value->status,
                $index
            ]);
        }
        return response()->json($resourceDatatable);
    }
}
