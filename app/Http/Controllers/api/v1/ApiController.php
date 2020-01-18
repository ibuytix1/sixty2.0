<?php

namespace App\Http\Controllers\api\v1;

//use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\UserController;
use App\Model\admin\TicketModel;
use App\Model\Follow;
use App\Model\Helpdesk;
use App\Model\Order;
use App\Model\OrderTicket;
use App\Model\organizer\Event_Model;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


use App\Http\Controllers\Controller;
use App\Model\admin\OrganizerModel;
use App\Model\admin\EventModel;
use App\Model\admin\BankAccountModel;
use App\Model\admin\PayPalAccountModel;
use App\Model\organizer\Coupon_Model;
use App\Model\organizer\ContactModel;
use App\Model\admin\CategoryModel;
use App\Model\admin\SubCategoryModel;
use App\Model\admin\TagsModel;
use App\Model\admin\AttendeeModel;
use Mail;
use DB;
use Event;
use App\Events\SendMail;
use Carbon\Carbon;
use App\Model\PromotionRequest;

class ApiController extends Controller
{
    /* for successful response code = 1 and if error code = 0 */
    public function register(Request $request)
    {
        /** created this */
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => $validator->errors(),
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        $user = User::where('email', $request->email)->exists();
        if ($user) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Already Registered',
                'dev_message' => 'User already registered', 'code' => 0
            );
            return response()->json($response);
        }
        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->password = '';
        $token = str_random(32);
        $user->user_type = 1;
        $user->email_confirm = 0;
        $user->email_confirm_code = $token;
        $user->save();

        $url = url('complete-register/' . $token . '/' . $user->email);
        $title = "Activate Your Account";
        $mess = "Please activate your account to complete your registration!";
        $email = $user->email;
        $full_name = $user->first_name . ' ' . $user->last_name;
        Mail::send('mails.complete-register', ['title' => $title, 'description' => $mess,
            'url' => $url, 'name' => $full_name], function ($message) use ($email) {
            $message->from('info@ibuytix.com', 'Event Booking Team');
            $message->to($email)->subject("Activate Account");
        });

        $user_data = array(
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "user_type" => $user->user_type,
        );

        $response = array(
            'payload' => $user_data,
            'message' => 'Activation Email send successfully! Please check your email for activation link',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    public function completeRegister(Request $request)
    {
        /** working on this */
        //validating form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        //empty class object
        $userData = new \stdClass();
        //error if validation fails
        if ($validator->fails()) {
            $response = array(
                'payload' => $userData, 'message' => $validator->errors(),
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $email = $request->get('email');
        $token = $request->get('token');
        $password = $request->get('password');
        $user = User::where('email', $email)->where('email_confirm_code', $token)->first();
        if (!$user) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'User not exists or already active',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        // creating new user if validation passes
        $user->update([
            'email' => $request->email,
            'password' => Hash::make($password),
            'user_type' => 1,
            'email_confirm' => 1,
            'email_confirm_code' => ''
        ]);
        $redirect_url = 'user/dashboard';
        $token = $user->createToken('userToken')->accessToken;
        $payload['user'] = $user;
        $payload['token'] = $token;
        $payload['redirect_url'] = $redirect_url;
        $response = array(
            'payload' => $payload, 'message' => 'Registered successfully.',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_step_1(Request $request)
    {
        // checking if user exists in the database or not
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'email does not exist',
                'dev_message' => 'email does not exist', 'code' => 0]);
        }
        // getting user data if user exists in database
        /*$data = User::where('email', $request->email)->first();*/
        $userData = array(
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email
        );
        return response()->json([
            'payload' => $userData, 'message' => '',
            'dev_message' => '', 'code' => 1]);

    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // logging in user
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Invalid password.',
                'dev_message' => '', 'code' => 0]);
        }
        $token = auth()->user()->createToken('userToken')->accessToken;
        //logged in user data
        $userData = auth()->user();
        $userData['token'] = $token;
        if ($userData->user_type == 1) {
            $redirect_url = 'user/dashboard';
            session()->put('user_data', $userData);
        } elseif ($userData->user_type == 2) {
            $redirect_url = 'organizer/dashboard';
            session()->put('organizer_data', $userData);
        } elseif ($userData->user_type == 3) {
            $redirect_url = 'promoter/dashboard';
            session()->put('promoter/data', $userData);
        }
        return response()->json([
            'payload' => $userData, 'redirect_url' => $redirect_url, 'message' => 'Login successfully.',
            'dev_message' => '', 'code' => 1]);
    }

    /**
     * Handles forgot password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function sendForgetPasswordToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Email is required',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        } else {
            $email = $request->input('email');
            $userdata = User::where('email', $email)->first();
            $token = str_random(32);
            if (!$userdata) {
                $response = array(
                    'payload' => new \ stdClass(), 'message' => 'You are not a registered user.',
                    'dev_message' => '', 'code' => 0
                );
                return response()->json($response);
            }
            $url = url('/reset-password/' . $token);
            $title = "Password Reset Request";
            $mess = "Reset Password";
            Mail::send('mails.forgot-password',
                ['title' => $title, 'description' => $mess, 'url' => $url, 'name' => $userdata->full_name],
                function ($message) use ($email) {
                    $message->to($email)->subject("Reset Password");
                });
            DB::table('password_resets')->updateOrInsert(['email' => $userdata->email], [
                    'email' => $userdata->email, 'token' => $token,
                    'created_at' => new \DateTime()
                ]
            );
            return response()->json([
                'payload' => new \stdClass(),
                'message' => 'Passoword reset link has been send to your Email, please check for reset password',
                'dev_message' => '', 'code' => 1
            ]);
        }
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => $validator->errors(),
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        $reset_pass = DB::table('password_resets')->where('token', $request->get('token'))->first();
        if (!$reset_pass) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Cannot reset password',
                'dev_message' => 'Reset Password request not found', 'code' => 0
            );
            return response()->json($response);
        }
        $email = $reset_pass->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No user found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }

        $user->password = Hash::make($request->get('password'));
        $user->save();
        DB::table('password_resets')->where('token', $request->get('token'))->delete();
        $payload = array(
            'user' => $user,
            'redirect_url' => url('login')
        );
        $response = array(
            'payload' => $payload, 'message' => 'Password updated successfully',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles view user profile details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        if (!auth()->user()->id) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Unauthorized',
                'dev_message' => 'User not logged in',
                'code' => 0,
            );
            return response()->json($response);
        }
        $id = auth()->user()->id;
        $data = User::find($id);
        if (!$data) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No data found.',
                'dev_message' => 'No data found.', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $data, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles update profile details of organizer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            /*'unique_url' => 'required',
            'location' => 'required',*/
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $id = auth()->user()->id;
        $userData = array(
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            /*'email' => $request->email,*/
            'about_organizer' => $request->about_organizer,
            'unique_url' => $request->unique_url,
            'location' => $request->location,
            'cityLat' => $request->cityLat,
            'cityLng' => $request->cityLng,
            'website' => $request->website,
            'mobile_number' => $request->mobile_number,
        );
        $data = User::where('id', $id)->update($userData);
        $userData['id'] = $id;
        if (!$data) {
            $response = [
                'payload' => new \ stdClass(), 'dev_message' => 'Update problem in database',
                'message' => 'Somthing went wrong', "code" => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $userData, 'message' => 'Profile updated successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles update  social media profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSocialMediaAccounts(Request $request)
    {
        $id = auth()->user()->id;;
        $socialData = array(
            'fb_url' => checkUrl($request->get('fb_url')),
            'insta_url' => checkUrl($request->get('insta_url')),
            'snapchat' => checkUrl($request->get('snapchat')),
            'twitter' => checkUrl($request->get('twitter')),
        );
        $data = User::where('id', $id)->update($socialData);
        if (!$data) {
            $response = [
                'payload' => new \ stdClass(), 'dev_message' => 'Error updating in database',
                'message' => 'Something went wrong! Please try again later', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $socialData, 'message' => 'Social Media links updated',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles add bank account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addBankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required',
            'account_number' => 'required',
            'bank_currency' => 'required',
            'bank_phone_no' => 'required',
            'routing_number' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $bankAccountData = array(
            'user_id' => auth()->user()->id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_currency' => $request->bank_currency,
            'bank_phone_no' => $request->bank_phone_no,
            'routing_number' => $request->routing_number,
            'bank_name' => $request->bank_name,
            'created_at' => date('Y-m-d H:i:s'),
        );
        $data = BankAccountModel::insert($bankAccountData);
        if (!$data) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong',
                'dev_message' => 'Database Exception', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => BankAccountModel::find(DB::getPdo()->lastInsertId()), 'message' => 'Bank account added successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles add bank account
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bankAccountList()
    {
        $user_id = auth()->user()->id;
        $accounts = BankAccountModel::where('user_id', $user_id)->paginate(10);
        if ($accounts->isEmpty()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Data not found',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $accounts, 'message' => 'Accounts List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Update bank account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateBankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'bank_currency' => 'required',
            'bank_phone_no' => 'required',
            'routing_number' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $bankAccount = BankAccountModel::where('id', $request->get('id'))
            ->where('user_id', auth()->user()->id)
            ->first();
        if (!$bankAccount) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $bankAccount->account_name = $request->account_name;
        $bankAccount->account_number = $request->account_number;
        $bankAccount->bank_currency = $request->bank_currency;
        $bankAccount->bank_phone_no = $request->bank_phone_no;
        $bankAccount->routing_number = $request->routing_number;
        $bankAccount->bank_name = $request->bank_name;
        if (!$bankAccount->save()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong',
                'dev_message' => 'Database Exception', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $bankAccount, 'message' => 'Bank account updated successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);

    }

    /**
     * Handles Delete bank account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteBankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $bankAccount = BankAccountModel::where(['id' => $request->id, 'user_id' => auth()->user()->id])->first();
        if (!$bankAccount) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        if (!$bankAccount->forceDelete()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong please try after some time!',
                'dev_message' => 'Database Exception', 'code' => 0
            ];
            return response()->json($response);

        }
        $response = [
            'payload' => new \ stdClass(), 'message' => 'Bank Account deleted successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles pay pal account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addPayPalAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_paypal' => 'required',
            'paypal_email' => 'required|email|unique:user_paypal_account,paypal_email',
            'pay_pal_phone_no' => 'required',
            'pay_pal_currency' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $payPalAccountData = array(
            'user_id' => auth()->user()->id,
            'paypal_email' => $request->paypal_email,
            'name_paypal' => $request->name_paypal,
            'pay_pal_phone_no' => $request->pay_pal_phone_no,
            'pay_pal_currency' => $request->pay_pal_currency,
            'created_at' => new \DateTime()
        );
        $data = PayPalAccountModel::insert($payPalAccountData);
        if (!$data) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong',
                'dev_message' => "Database Exception", 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => PayPalAccountModel::find(DB::getPdo()->lastInsertId()), 'message' => 'PayPal account added successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles pay pal account list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function PayPalAccountList()
    {
        $user_id = auth()->user()->id;
        $data = PayPalAccountModel::where('user_id', $user_id)->paginate(10);
        if ($data->isEmpty()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $data, 'message' => 'PayPal Account List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);

    }

    /**
     * Handles update pay pal account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updatePayPalAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'paypal_email' => 'required|email|unique:user_paypal_account,paypal_email,' . $request->id,
            'name_paypal' => 'required',
            'pay_pal_phone_no' => 'required',
            'pay_pal_currency' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $paypalAccount = PayPalAccountModel::where(['id' => $request->id, 'user_id' => auth()->user()->id])
            ->first();
        if (!$paypalAccount) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $paypalAccount->paypal_email = $request->paypal_email;
        $paypalAccount->name_paypal = $request->name_paypal;
        $paypalAccount->pay_pal_phone_no = $request->pay_pal_phone_no;
        $paypalAccount->pay_pal_currency = $request->pay_pal_currency;
        if (!$paypalAccount->save()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong  please try after some time',
                'dev_message' => 'Database Exception', 'code' => 0
            ];
            return response()->json($response);

        }
        $response = [
            'payload' => $paypalAccount, 'message' => 'Account Updated successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles update pay pal account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deletePayPalAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $payPalAccount = PayPalAccountModel::where('id', $request->get('id'))
            ->where('user_id', auth()->user()->id)->first();
        if (!$payPalAccount) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        if (!$payPalAccount->forceDelete()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong  please try after some time',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => new \ stdClass(), 'message' => 'Account deleted successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles add Coupon
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventListingForCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ]);
        } else {
            $count = EventModel::where('deleted_at', null)
                ->where('end_date', '>=', time())
                ->where('event_status', 1)
                ->where('organizer_id', $request->user_id)
                ->count();
            if ($count) {
                $data = EventModel::where('deleted_at', null)
                    ->where('end_date', '>=', time())
                    ->where('event_status', 1)
                    ->where('organizer_id', $request->user_id)
                    ->pluck('event_title', 'id');

                return response()->json([
                    'payload' => $data, 'message' => 'Event List',
                    'dev_message' => '', 'code' => 1
                ]);
            } else {
                return response()->json([
                    'payload' => new \stdClass(), 'message' => 'data not available',
                    'dev_message' => 'data not available', 'code' => 0
                ]);
            }
        }
    }

    /**
     * Handles add Coupon
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|unique:coupon,coupon',
            'start_date' => 'required',
            'end_date' => 'required',
            'redeem_on' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }
        $id = auth()->user()->id;
        $couponData = array(
            'user_id' => $id,
            'coupon' => $request->coupon_code,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_available' => $request->total_available,
            'redeem_on' => $request->redeem_on,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => $request->status,
        );
        $data = Coupon_Model::insert($couponData);
        if (!$data) {
            $response = array(
                'payload' => new \stdClass, 'message' => 'Something went wrong please try again later',
                'dev_message' => 'Query exception', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => new \stdClass(), 'message' => 'Coupon added successfully',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles List Coupons
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function couponList()
    {
        $id = auth()->user()->id;
        // $couponList = Coupon_Model::with('REL_Event')->where('user_id',$request->user_id)->paginate(10);
        $coupons = Coupon_Model::with('event')->where('user_id', $id)->paginate(10);
        if ($coupons->isEmpty()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'You don\'t have any coupons',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $coupons, 'message' => 'Coupon List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles updated Coupons
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'coupon' => 'required|unique:coupon,coupon,' . $request->id,
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'redeem_on' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Validation failed',
                'dev_message' => $validator->errors(),
                'code' => 0
            );
            return response()->json($response);
        }
        $id = auth()->user()->id;
        $coupon = Coupon_Model::where('user_id', $id)->find($request->id);
        if ($coupon->count() == 0) {
            $response = array(
                'payload' => new \stdClass(),
                'message' => 'Data not available',
                'dev_message' => 'Data not available',
                'code' => 0
            );
            return response()->json($response);
        }

        $couponData = array(
            'coupon' => $request->coupon,
            'description' => $request->description,
            'start_date' => $request->input('start_date'),
            'start_time' => $request->input('start_time'),
            'end_date' => $request->input('end_date'),
            'end_time' => $request->input('end_time'),
            'total_available' => $request->total_available,
            'redeem_on' => $request->redeem_on,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => $request->status,
        );

        if (!$coupon->update($couponData)) {
            $response = array(
                'payload' => new \ stdClass(), 'message' => 'Something went wrong please try again later',
                'dev_message' => 'Query exception', 'code' => 0
            );
            return response()->json($response);

        }
        $response = array(
            'payload' => $coupon, 'message' => 'Coupon updated successfully',
            'dev_message' => 'Coupon updated successfully', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * Handles Delete Coupons
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }

        $coupon = Coupon_Model::where('id', $request->id)
            ->where('user_id', auth()->user()->id)
            ->delete();
        if (!$coupon) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something went wrong...',
                'dev_message' => 'data not available', 'code' => 0
            ];
            return response()->json($response);
        }
        $coupons = Coupon_Model::with('event')->where('user_id', auth()->user()->id)
            ->paginate(20);
        $response = [
            'payload' => $coupons, 'message' => 'Coupon deleted successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles search  Coupons
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCoupon(Request $request)
    {
        $key = $request->get('key');
        $couponList = Coupon_Model::with('event')
            ->where('user_id', auth()->user()->id)
            ->where(function ($query) use ($key) {
                $query->where('coupon', 'like', "%{$key}%")
                    ->orWhere('description', 'like', "%{$key}%");
            })
            ->paginate(10);
        if ($couponList->isEmpty()) {
            $response = [
                'payload' => $couponList, 'message' => 'No Coupons Found with ' . $key,
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $couponList, 'message' => 'Coupon List for ' . $key,
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Add Event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addEvent(Request $request)
    {
        /*$regex = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";*/
        $validator = Validator::make($request->all(), [
            'event_title' => 'required|unique:events',
            'event_status' => 'required',
            /*'event_url' => 'required|regex:' . $regex,*/
            'event_url' => 'required|unique:events,event_url',
            'event_location' => 'required',
            'address' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'event_image' => 'required|array|min:1|max:3',
            'event_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'event_description' => 'required',
            'event_type.*' => 'required',
            'quantity.*' => 'required',
            'ticket_type.*' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }

        $requestData = unsetData($request->all(), array('_token'));
        $requestData['organizer_id'] = auth()->user()->id;
        $ticketdata['ticket_type'] = $requestData['ticket_type'];
        $ticketdata['quantity'] = $requestData['quantity'];
        $ticketdata['event_type'] = $requestData['event_type'];
        $ticketdata['price'] = $requestData['price'];
        $tags = $requestData['tags'];
        if ($request->hasFile('event_image')) {
            $image = image_upload_multiple($request, 'event_image');
        }
        unset($requestData['ticket_type'], $requestData['quantity'],
            $requestData['event_type'], $requestData['price'],
            $requestData['event_image'], $requestData['user_id'],
            $requestData['tags']);
        $event_data = EventModel::insert($requestData);
        $id = DB::getPdo()->lastInsertId();
        $ticketArray = array();
        foreach ($ticketdata['ticket_type'] as $key => $value) {
            $ticketData['event_id'] = $id;
            $ticketData['ticket_type'] = $ticketdata['ticket_type'][$key];
            $ticketData['quantity'] = $ticketdata['quantity'][$key];
            $ticketData['original_quantity'] = $ticketdata['quantity'][$key];
            $ticketData['event_type'] = $ticketdata['event_type'][$key];
            $ticketData['price'] = $ticketdata['price'][$key];
            array_push($ticketArray, $ticketData);
        }
        DB::table('event_ticket')->insert($ticketArray);
        if ($request->hasFile('event_image')) {
            $imageArray = array();
            foreach ($image as $key => $value) {
                $imageData['event_id'] = $id;
                $imageData['image_name'] = $value;
                array_push($imageArray, $imageData);
            }
            DB::table('event_mages')->insert($imageArray);
        }
        $event = EventModel::find($id);
        $event->tags()->attach($tags);
        if (auth()->user()->user_type != 2) {
            $user = User::find(auth()->user()->id);
            $user->user_type = 2;
            $user->save();
        }
        $response = [
            'payload' => $event_data, 'message' => 'Event created successfully',
            'dev_message' => '', 'code' => 1,
        ];
        return response()->json($response);

    }

    /**
     * Handles Category List
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryList(Request $request)
    {
        $count = CategoryModel::count();
        if (!$count) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => 'data not available', 'code' => 0
            ];
            return response()->json($response);
        }
        $data = CategoryModel::pluck('category_name', 'id');
        $response = [
            'payload' => $data, 'message' => 'Category  List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Category List
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subcategoryList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0]);
        }
        $count = SubCategoryModel::where('category_id', $request->category_id)->count();
        if (!$count) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => 'data not available', 'code' => 0]);
        }
        $data = SubCategoryModel::where('category_id', $request->category_id)
            ->pluck('subcategory_name', 'id');
        return response()->json([
            'payload' => $data, 'message' => 'subcategory  List',
            'dev_message' => '', 'code' => 1]);
    }

    /**
     * Handles Live event list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function liveEventsList()
    {
        $id = auth()->user()->id;
        /*$mytime = Carbon::now();
        $currentTime = date('H:i', strtotime($mytime->toDateTimeString()));*/
        $events = EventModel::with('REL_Event_Category', 'REL_Event_Organizer', 'REL_Event_Image',
            'REL_event_subcategory', 'REL_event_ticket', 'tags')
            ->where('deleted_at', null)
            ->where('organizer_id', $id)->where('event_status', 1)
            ->where('start_date', '>=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('created_at', 'DESC')->paginate(4);
        if ($events->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'You don\'t have any live events.',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $events, 'message' => '', 'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Draft event list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function draftEventsList()
    {
        $org_id = auth()->user()->id;
        $data = EventModel::with('REL_Event_Category', 'REL_Event_Organizer', 'REL_Event_Image',
            'REL_event_subcategory', 'REL_event_ticket', 'tags')
            ->where('deleted_at', null)
            ->where('organizer_id', $org_id)->where('event_status', 0)
            ->orderBy('created_at', 'DESC')->paginate(4);
        if ($data->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'You don\'t have any draft events.', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $data, 'message' => 'Draft Event List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles past event list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pastEventsList(Request $request)
    {
        $mytime = Carbon::now();
        $currentTime = date('H:i', strtotime($mytime->toDateTimeString()));
        $data = EventModel::with('REL_Event_Category', 'REL_Event_Organizer', 'REL_Event_Image')
            ->where('event_status', 1)->where('deleted_at', null)
            ->where('organizer_id', auth()->user()->id)
            ->where('end_date', '<=', date('Y-m-d'))
            ->where('end_time', '<=', $currentTime)
            ->paginate(4);
        if ($data->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'You don\'t have any past events', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $data, 'message' => 'Draft Event List', 'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles update Event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEvent(Request $request)
    {
        /*$regex = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";*/
        $validator = Validator::make($request->all(), [
            'event_title' => 'required|unique:events,event_title,' . $request->event_id,
            'event_status' => 'required',
            'event_id' => 'required',
            /*'event_url' => 'required|regex:' . $regex,*/
            'event_url' => 'required|unique:events,event_url,' . $request->event_id,
            'event_location' => 'required',
            'address' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'event_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'event_description' => 'required',
            'event_type.*' => 'required',
            'quantity.*' => 'required',
            'ticket_type.*' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $tags = $request->get('tags');
        $count = EventModel::where(['organizer_id' => auth()->user()->id, 'id' => $request->event_id])->count();
        if ($count) {
            $requestData = unsetData($request->all(), array('_token'));
            $eventToSave = EventModel::find($request->input('event_id'));
            $eventToSave->organizer_id = auth()->user()->id;
            $eventToSave->event_title = $requestData['event_title'];
            $eventToSave->event_description = $requestData['event_description'];
            $eventToSave->category_id = $requestData['category_id'];
            $eventToSave->event_url = $requestData['event_url'];
            $eventToSave->subcategory_id = $requestData['subcategory_id'];
            $eventToSave->event_location = $requestData['event_location'];
            $eventToSave->address = $requestData['address'];
            $eventToSave->address_2 = $requestData['address_2'];
            $eventToSave->start_date = $requestData['start_date'];
            $eventToSave->start_time = $requestData['start_time'];
            $eventToSave->end_date = $requestData['end_date'];
            $eventToSave->end_time = $requestData['end_time'];

            if ($requestData['is_recurring']) {
                $eventToSave->is_recurring = $requestData['is_recurring'];
                $eventToSave->event_recurring = isset($requestData['event_recurring']) ? 1 : 0;
                $eventToSave->event_occurrence_type = $requestData['event_occurrence_type'];
                $eventToSave->occurrence_start_time = $requestData['occurrence_start_time'];
                $eventToSave->occurrence_end_time = $requestData['occurrence_end_time'];
                $eventToSave->occurrence_from_date = $requestData['occurrence_from_date'];
                $eventToSave->occurence_to_date = $requestData['occurence_to_date'];
                $eventToSave->occurrence_off_the_day = $requestData['occurrence_off_the_day'];
            } else {
                $eventToSave->is_recurring = $requestData['is_recurring'];
                $eventToSave->event_occurrence_type = null;
                $eventToSave->occurrence_start_time = null;
                $eventToSave->occurrence_end_time = null;
                $eventToSave->occurrence_from_date = null;
                $eventToSave->occurence_to_date = null;
                $eventToSave->occurrence_off_the_day = null;
            }
            $eventToSave->show_no_of_available_tickets = $requestData['show_no_of_available_tickets'];
            $eventToSave->refund_policy = $requestData['refund_policy'];
            $eventToSave->is_private = $requestData['is_private'];
            $eventToSave->other_information = $requestData['other_information'];
            $eventToSave->aditional_information = $requestData['aditional_information'];
            $eventToSave->cityLat = $requestData['cityLat'];
            $eventToSave->cityLng = $requestData['cityLng'];
            $eventToSave->event_status = $requestData['event_status'];
            $eventToSave->tags()->attach($tags);
            $eventToSave->save();
            $image = [];
            if ($request->hasFile('event_image')) {
                $image = image_upload_multiple($request, 'event_image');
                $delete_old_images = DB::table('event_mages')->where('event_id', $request->event_id)->get();
                if ($delete_old_images->count() > 0) {
                    foreach ($delete_old_images as $delete_old_image) {
                        unlink(public_path('upload/event_image/' . $delete_old_image->image_name));
                    }
                    DB::table('event_mages')->where('event_id', $request->event_id)->delete();
                }
            }
            $imageArray = array();
            foreach ($image as $key => $value) {
                $imageData['event_id'] = $eventToSave->id;
                $imageData['image_name'] = $value;
                array_push($imageArray, $imageData);
            }
            if (count($imageArray)) {
                DB::table('event_mages')->insert($imageArray);
            }
            DB::table('event_ticket')->where('event_id', $eventToSave->id)->delete();
            $ticketdata['ticket_type'] = $requestData['ticket_type'];
            $ticketdata['quantity'] = $requestData['quantity'];
            $ticketdata['event_type'] = $requestData['event_type'];
            $ticketdata['price'] = $requestData['price'];
            $ticketArray = array();
            foreach ($ticketdata['ticket_type'] as $key => $value) {
                $ticketData['event_id'] = $eventToSave->id;
                $ticketData['ticket_type'] = $ticketdata['ticket_type'][$key];
                $ticketData['quantity'] = $ticketdata['quantity'][$key];
                $ticketData['original_quantity'] = $ticketdata['quantity'][$key];
                $ticketData['event_type'] = $ticketdata['event_type'][$key];
                $ticketData['price'] = $ticketdata['price'][$key];
                array_push($ticketArray, $ticketData);
            }
            if (count($ticketArray)) {
                DB::table('event_ticket')->insert($ticketArray);
            }
            if ($eventToSave) {
                $eventData = EventModel::with('REL_Event_Category', 'REL_Event_Organizer',
                    'REL_Event_Image', 'REL_event_subcategory', 'REL_event_ticket')
                    ->find($request->input('event_id'));
                $response = [
                    'payload' => $eventData, 'message' => 'Event Updated successfully',
                    'dev_message' => '', 'code' => 1
                ];
                return response()->json($response);
            } else {
                $response = [
                    'payload' => new \stdClass(), 'message' => 'Something went wrong please try after some time',
                    'dev_message' => '', 'code' => 0
                ];
                return response()->json($response);
            }
        } else {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
    }

    /**
     * Handles Single event Detail
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewSingleEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(),
                'code' => 0
            ];
            return response()->json($response);
        }
        $event = EventModel::with('REL_Event_Category', 'REL_Event_Organizer', 'REL_Event_Image')
            ->where('organizer_id', auth()->user()->id)
            ->where('id', $request->event_id)->first();
        if (!$event) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Data not available',
                'dev_message' => 'Data not available', 'code' => 0
            ];
            return response()->json($response);
        }
        $event->tags = [];
        if (!empty($event->event_tags)) {
            $event->tags = TagsModel::select('tag')
                ->WhereIn('id', explode(',', $event->event_tags))
                ->get()->toArray();
        }
        $response = [
            'payload' => $event, 'message' => 'Single Event data',
            'dev_message' => 'Single Event Data', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Single event Detail
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \ stdClass(), 'dev_message' => $validator->errors(),
                'message' => 'Validation failed', 'code' => 0
            ];
            return response()->json($response);
        }
        $event = EventModel::where('id', $request->get('id'))
            ->where('organizer_id', auth()->user()->id)->first();
        if (!$event) {
            $response = [
                'payload' => '', 'message' => 'Data not found',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $event->delete();
        $response = [
            'payload' => '', 'message' => 'Event deleted successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles import Contact
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function importContact(Request $request)
    {
        $validator = Validator::make(
            [
                'file' => $request->file,
                'event_id' => $request->event_id,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xls,xlsx',
                'event_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        if (!$request->hasFile('file')) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'No file found',
                'dev_message' => 'Requested file not found', 'code' => 0
            ];
            return response()->json($response);
        }
        $path = $request->file('file')->getRealPath();
        $data = \Excel::load($path)->get();
        if ($data->count() < 1) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'data not found in excel file',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        foreach ($data as $key => $value) {
            $arr[] = [
                'first_name' => $value->first_name,
                'last_name' => $value->last_name,
                'email' => $value->email,
                'created_at' => date('Y-m-d H:i:s'),
                'event_id' => $request->event_id,
                'organizer_id' => auth()->user()->id,
            ];
        }
        if (empty($arr)) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'data not available in sheet',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $data = ContactModel::insert($arr);
        if (!$data) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Something Went wrong please try after some times',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => new \stdClass(), 'message' => 'data uploaded successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles Contact List
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactList()
    {
        $contacts = ContactModel::where('organizer_id', auth()->user()->id)->paginate(10);
        if ($contacts->isEmpty()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'You don\'t have any contact',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $contacts, 'message' => 'Contact list',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles update Contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateContact(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|numeric',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
            ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'validation failed',
                'dev_message' => $validator->errors(), "code" => 0
            ];
            return response()->json($response);
        }
        $contact = ContactModel::find($request->get('id'));
        if (!$contact) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No data Found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $data = array(
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
        );
        $contact->update($data);
        $response = [
            'payload' => $contact, 'message' => 'Contact Updated Successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles delete Contact
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $contact = ContactModel::where(['id' => $request->id, 'organizer_id' => auth()->user()->id])->delete();
        if (!$contact) {
            $response = [
                'payload' => new \ stdClass(), 'message' => 'Contact not deleted please try after some time.',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => new \ stdClass(), 'message' => 'Contact deleted successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles search Contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchContact(Request $request)
    {
        $key = $request->get('key');
        $organizer_id = auth()->user()->id;
//        $contacts = new \stdClass();
        if ($key == 'byName') {
            $contacts = ContactModel::where('organizer_id', $organizer_id)
                ->orderBy('first_name', 'ASC')->paginate(10);
        } elseif ($key == 'byDate') {
            $contacts = ContactModel::where('organizer_id', $organizer_id)
                ->orderBy('created_at', 'DESC')->paginate(10);
        } elseif ($key == 'byEmail') {
            $contacts = ContactModel::where('organizer_id', $organizer_id)
                ->orderBy('email', 'ASC')->paginate(10);
        } else {
            $contacts = ContactModel::where('organizer_id', $organizer_id)
                ->where(function ($query) use ($key) {
                    $query->where('first_name', 'LIKE', '%' . $key . "%")
                        ->orWhere('last_name', 'LIKE', '%' . $key . '%')
                        ->orWhere('email', 'LIKE', '%' . $key . '%');
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);
        }
        if ($contacts->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'No Contact Found',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $contacts, 'message' => 'Contact List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles contact list by event Contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactListByEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $contacts = ContactModel::where(['event_id' => $request->event_id, 'organizer_id' => auth()->user()->id])
            ->paginate(10);
        if ($contacts->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'No Contact found',
                'dev_message' => 'Data not available', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $contacts, 'message' => 'Contact list by event ',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles send Bulk mail to contact
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendBulkMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contacts' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $ids = $request->get('contacts');
        $count = ContactModel::WhereIn('id', $ids)
            ->select('email', DB::raw('CONCAT(first_Name, " ", last_Name) AS full_name'))
            ->count();
        if (!$count) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $message = $request->get('message');
        Event::fire(new SendMail($ids, $message));
        $response = [
            'payload' => new \ stdClass(), 'message' => 'Mail send successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * tag list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tagList(Request $request)
    {
        $tags = TagsModel::pluck('tag', 'id');
        if ($tags->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $tags, 'message' => 'Tags List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles add attendee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addAttendee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'amount' => 'required',
            'ticket_type' => 'required',
            'quantity' => 'required',
            'payment_type' => 'required',
            'email' => 'required|email',
            'event_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $attendeeData = new AttendeeModel();
        $attendeeData->first_name = $request->first_name;
        $attendeeData->last_name = $request->last_name;
        $attendeeData->amount = $request->amount;
        $attendeeData->ticket_type = $request->ticket_type;
        $attendeeData->quantity = $request->quantity;
        $attendeeData->payment_type = $request->payment_type;
        $attendeeData->email = $request->email;
        $attendeeData->event_id = $request->event_id;
        $attendeeData->user_id = auth()->user()->id;

        if (!$attendeeData->save()) {
            $response = [
                'payload' => new \ stdClass(),
                'message' => 'Something went wrong please try after sometime!',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => new \ stdClass(), 'message' => 'Attendee added successfully',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles list attendee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAttendee()
    {
        $attendees = AttendeeModel::with(['event' => function ($query) {
            $query->select('id', 'event_title');
        }])->where('user_id', auth()->user()->id)->paginate(10);
        if ($attendees->isEmpty()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'You don\'t have any attendees',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $attendees, 'message' => 'Attendees List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * Handles add attendee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportAttendeeDataToExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            ];
            return response()->json($response);
        }
        $attendeeList = AttendeeModel::selectRaw('first_name,last_name,email')
            ->where('event_id', $request->event_id)->where('user_id', auth()->user()->id)->get();
        if ($attendeeList->count() <= 0) {
            $response = [
                'payload' => $attendeeList, 'message' => 'Data not available',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $attendeeList, 'message' => 'Attendee List',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * search attendee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAttendee(Request $request)
    {
        $key = $request->get('key');
        $organizer_id = auth()->user()->id;
        if ($key == 'ticket_type') {
            $attendees = AttendeeModel::with(['event' => function ($query) {
                $query->select('id', 'event_title');
            }])
                ->where('user_id', $organizer_id)
                ->orderBy('ticket_type', 'DESC')->paginate(10);
        } elseif ($key == 'date_of_purchase') {
            $attendees = AttendeeModel::with(['event' => function ($query) {
                $query->select('id', 'event_title');
            }])
                ->where('user_id', $organizer_id)
                ->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $attendees = AttendeeModel::with(['event' => function ($query) {
                $query->select('id', 'event_title');
            }])
                ->where('user_id', $organizer_id)
                ->where(function ($query) use ($key) {
                    $query->where('first_name', 'like', "%{$key}%")
                        ->orWhere('last_name', 'like', "%{$key}%")
                        ->orWhere('email', 'like', "%{$key}%");
                })
                ->paginate(10);
        }
        if ($attendees->isEmpty()) {
            $response = [
                'payload' => $attendees, 'message' => 'No Coupons Found with ' . $key,
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $attendees, 'message' => 'Coupon List for ' . $key,
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * search attendees by date
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAttendeeByDate(Request $request)
    {
        $key = $request->get('key');
        $organizer_id = auth()->user()->id;

        $attendees = AttendeeModel::with(['event' => function ($query) {
            $query->select('id', 'event_title');
        }])
            ->where('user_id', $organizer_id)
            ->where('created_at', 'LIKE', $key . '%')
            ->paginate(10);

        if ($attendees->isEmpty()) {
            $response = [
                'payload' => $attendees, 'message' => 'No Coupons created on ' . $key,
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $attendees, 'message' => 'Coupon List for ' . $key,
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * update user's old password with new password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0]);
        }
        $id = auth()->user()->id;
        $old_password = $request->get('old_password');
        $new_password = $request->get('new_password');
        $user = User::find($id);
        if (!$user) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Data not available',
                'dev_message' => 'No user Found', 'code' => 0]);
        }
        if (!Hash::check($old_password, $user->password)) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Wrong Password',
                'dev_message' => '', 'code' => 0]);
        }

        $user->password = Hash::make($new_password);
        $user->save();
        return response()->json(['payload' => new \stdClass(), 'message' => 'Password Updated Successfully',
            'dev_message' => '', 'code' => 1]);

    }

    /**
     * list of all promotion request came from other promoters and organizers.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPromotionRequest(Request $request)
    {
        $promotionRequests = PromotionRequest::with('promoter', 'event')
            ->where('organizer_id', auth()->user()->id)
            ->paginate(10);
        if ($promotionRequests->isEmpty()) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'You don\'t have any promotion request',
                'dev_message' => '', 'code' => 0]);
        }
        return response()->json(['payload' => $promotionRequests, 'message' => 'List of Promotion Requests',
            'dev_message' => '', 'code' => 1]);
    }

    /**
     * get all my promo request
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function getAllPromo(Request $request)
    {
        $request_type = $request->get('request_type');
        if ($request_type == 'pending') {
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        } else if ($request_type == 'rejected') {
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        } else if ($request_type == 'accepted') {
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)
                ->where('request_status', $request_type)->paginate(10);
        } else {
            $promotion = PromotionRequest::with('event', 'organizer')
                ->where('promoter_id', auth()->user()->id)->paginate(10);
        }
        if ($promotion->isEmpty()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'You don\'t have any promotion request',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $promotion, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePromoStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_id' => 'required|numeric',
            'promo_status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0]);
        }

        $promotion = PromotionRequest::where('id', $request->get('promo_id'))->first();
        if (!$promotion) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'No Promotion Request Found',
                'dev_message' => '', 'code' => 0]);
        }
        if ($request->get('promo_status') == 'accept') {
            $promotion->request_status = 'accepted';
        } elseif ($request->get('promo_status') == 'reject') {
            $promotion->request_status = 'rejected';
        } else {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Request status not valid',
                'dev_message' => '', 'code' => 0]);
        }
        $promotion->save();
        return response()->json(['payload' => $promotion, 'message' => 'Promotion request accepted',
            'dev_message' => '', 'code' => 1]);

    }

    // reject promotion request
    /*public function promoReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0]);
        }
        $promotion = PromotionRequest::where('id', $request->get('promo_id'))->first();
        if (!$promotion) {
            return response()->json(['payload' => new \stdClass(), 'message' => 'No Promotion Request Found',
                'dev_message' => '', 'code' => 0]);
        }
        $promotion->request_status = 'rejected';
        $promotion->save();
        return response()->json(['payload' => $promotion, 'message' => 'Promotion request accepted',
            'dev_message' => '', 'code' => 1]);
    }*/

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllHelpTickets()
    {
        $organizer = User::where('user_type', 2)->find(auth()->user()->id);
        if (!$organizer) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Organizer not found',
                'dev_message' => 'logged in user not an organizer', 'code' => 0
            );
            return response()->json($response);
        }
        $help_tickets = Helpdesk::with('images', 'category')
            ->where('organizer_id', auth()->user()->id)->get();
        if ($help_tickets->count() == 0) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Helpdesk tickets not found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $help_tickets, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpTicket(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'helpdesk_id' => 'required|numeric',
        ));
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }
        $helpdesk_id = $request->get('helpdesk_id');
        $help_tickets = Helpdesk::with('images', 'category')
            ->where('organizer_id', auth()->user()->id)->find($helpdesk_id);
        if (!$help_tickets) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Ticket not found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $help_tickets, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    public function replyHelpTicket(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'helpdesk_id' => 'required|numeric',
            'message' => 'required',
            'status' => 'required',
        ));
        if ($validator->fails()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Validation Failed',
                'dev_message' => $validator->errors(), 'code' => 0
            );
            return response()->json($response);
        }
        $helpdesk_id = $request->get('helpdesk_id');
        $message = $request->get('message');
        $status = $request->get('status');
        $help_ticket = Helpdesk::where('organizer_id', auth()->user()->id)->find($helpdesk_id);
        if (!$help_ticket) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'Ticket not found',
                'dev_message' => 'Ticket not found or login as an organizer first', 'code' => 0
            );
            return response()->json($response);
        }
        $help_ticket->organizer_message = $message;
        $help_ticket->status = $status;

        if (!$help_ticket->save()) {
            $response = array(
                'payload' => new \stdClass(), 'message' => '',
                'dev_message' => 'Database Error', 'code' => 0
            );
            return response()->json($response);
        }

        $subject = $help_ticket->subject;
        $user = User::find($help_ticket->user_id);
        $user_email = $user->email;

        Mail::send([], [], function ($mess) use ($user_email, $subject, $message) {
            $mess->from('noreply@ibuytix.com', $subject);
            $mess->to($user_email)->subject($subject)->setBody($message);
        });

        $response = array(
            'payload' => $help_ticket, 'message' => 'Reply sent successfully',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    public function myEvents()
    {
        $data = Event_Model::with('REL_Event_Image')->where('organizer_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')->paginate(3);
        if ($data->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No data found.',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $data, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /* event list for create coupon page */
    public function eventListForCoupon()
    {
        $events = Event_Model::where('deleted_at', null)
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('event_status', 1)
            ->where('organizer_id', auth()->user()->id)
            ->pluck('event_title', 'id');
        if ($events->count() <= 0) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No Event Found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $response = array(
            'payload' => $events, 'message' => '',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /* mark event as active */
    public function activateEvent(Request $request)
    {
        if (!$request->get('id')) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'event id is required',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $event = EventModel::find($request->get('id'));
        if (!$event) {
            $response = array(
                'payload' => new \stdClass(), 'message' => 'No Data Found',
                'dev_message' => '', 'code' => 0
            );
            return response()->json($response);
        }
        $event->event_status = 1;
        $event->save();
        $response = array(
            'payload' => $event, 'message' => 'Event is now Activated',
            'dev_message' => '', 'code' => 1
        );
        return response()->json($response);
    }

    /**
     * get all the live events list for import contact select box
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventsForImportContacts()
    {
        $events = EventModel::where('deleted_at', null)
            ->where('organizer_id', auth()->user()->id)->where('event_status', 1)
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('created_at', 'DESC')
            ->pluck('event_title', 'id');
        if (!$events) {
            $response = [
                'payload' => new \stdClass(), 'message' => 'No data found',
                'dev_message' => '', 'code' => 0
            ];
            return response()->json($response);
        }
        $response = [
            'payload' => $events, 'message' => '',
            'dev_message' => '', 'code' => 1
        ];
        return response()->json($response);
    }

    /**
     * list of followers
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function followers(Request $request)
    {
        $search = $request->get('search_followers');
        $followers = Follow::with('user')
            ->where('followed_user_id', auth()->user()->id)
            ->whereHas('user', function ($q) use ($search) {
                if (!empty($search)) {
                    $q->where('first_name', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($followers->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'You don\'t have any followers',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $followers, 'message' => 'list of followers',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * list of current logged in organizers orders
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orders(Request $request)
    {
        $start_date = $request->get('order_from_date');
        $end_date = $request->get('order_to_date');
        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-5 years'));
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-d', strtotime('+5 years'));
        }
        $orders = Order::with('order_tickets', 'event', 'coupon', 'user')
            ->where('organizer_id', auth()->user()->id)
            ->where('id', 'LIKE', '%' . $request->get('search') . '%')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')->paginate(10);
        if ($orders->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'You don\'t have any order',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $orders, 'message' => 'orders details',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function myEventsAll()
    {
        $tickets = OrderTicket::select('event_id')->groupBy('event_id')->pluck('event_id');
        $events = Event_Model::where('organizer_id', auth()->user()->id)
            ->whereIn('id', $tickets)
            ->select('id', 'event_title')->get();
        if ($events->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'No events found',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $events, 'message' => 'events list',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * show the sales records.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sales(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'event_id' => 'required|numeric'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'validation failed',
                'dev_message' => $validate->errors(), 'code' => 0,
            ]);
        }
        $sales = OrderTicket::with(['ticket' => function ($q) {
            $q->select('id', 'original_quantity', 'price');
        }])
            ->selectRaw('ticket_type, SUM(quantity) AS quantity, SUM(total_price) AS total_price, ticket_id')
            ->where('event_id', $request->event_id)
            ->groupBy('ticket_type', 'ticket_id')->get();
        if ($sales->isEmpty()) {
            return response()->json([
                'payload' => new \stdClass(), 'message', 'You don\'t have any sales',
                'dev_message' => '', 'code' => 0
            ]);
        }
        return response()->json([
            'payload' => $sales, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insights(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Validation failed',
                'dev_message' => $validate->errors(), 'code' => 0
            ]);
        }
        $event = Event_Model::where('id', $request->event_id)
            ->where('organizer_id', auth()->user()->id)->first();
        if (!$event) {
            return response()->json([
                'payload' => new \stdClass(), 'message' => 'Not found',
                'dev_message' => 'event id or logged in user id not matched', 'code' => 0
            ]);
        }
        $insights = new \stdClass();
        $insights->basic = OrderTicket::selectRaw('SUM(total_price) AS net_revenue, SUM(quantity) AS tix_sold')
            ->where('event_id', $request->event_id)->first();
        $insights->basic->contacts = ContactModel::where('event_id', $request->event_id)
            ->pluck('id')->count();
        $insights->sales = OrderTicket::
        selectRaw('ticket_type, SUM(quantity) AS quantity, SUM(total_price) AS total_price, ticket_id')
            ->where('event_id', $request->event_id)
            ->groupBy('ticket_type', 'ticket_id')->get();
        $insights->orders = Order::where('event_id', $request->event_id)
            ->where('organizer_id', auth()->user()->id)->take(5)->get();
        return response()->json([
            'payload' => $insights, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ticketSales()
    {
        $orders = Order::with('order_tickets')
            ->where('organizer_id', auth()->user()->id)
            ->get();
        $salesData = new \stdClass();
        $salesData->total_sales = 0;
        $salesData->sold_tickets = 0;
        foreach ($orders as $key => $order) {
            $order->soldTickets = 0;
            foreach ($order->order_tickets as $ticket) {
                $order->soldTickets += $ticket->quantity;
            }
            $salesData->total_sales += $order->total_amount;
            $salesData->sold_tickets += $order->soldTickets;
        }
        return response()->json([
            'payload' => $salesData, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function recentSells()
    {
        $thisWeek = Order::with('order_tickets', 'user', 'event')
            ->where('organizer_id', auth()->user()->id)
            ->where('created_at', '<', date('Y-m-d'))
            ->where('created_at', '>=', date('Y-m-d', strtotime("-1 week")))
            ->orderBy('created_at', 'DESC')
            ->get();
        $lastWeek = Order::with('order_tickets', 'user', 'event')
            ->where('organizer_id', auth()->user()->id)
            ->where('created_at', '>=', date('Y-m-d', strtotime("-2 week")))
            ->where('created_at', '<', date('Y-m-d', strtotime("-1 week")))
            ->orderBy('created_at', 'DESC')
            ->get();
        $total = new \stdClass();
        $total->thisWeek = 0;
        $total->lastWeek = 0;
        foreach ($thisWeek as $week) {
            $total->thisWeek += $week->total_amount;
        }
        foreach ($lastWeek as $week) {
            $total->lastWeek += $week->total_amount;
        }
        $thisWeekRecent = Order::with('order_tickets', 'user', 'event')
            ->where('organizer_id', auth()->user()->id)
            ->where('created_at', '<', date('Y-m-d'))
            ->where('created_at', '>=', date('Y-m-d', strtotime("-1 week")))
            ->orderBy('created_at', 'DESC')
            ->take(7)
            ->get();

        $weeklySales = new \stdClass();
        $weeklySales->thisWeek = $thisWeekRecent;
        $weeklySales->lastWeek = $lastWeek;
        $weeklySales->total = $total;
        return response()->json([
            'payload' => $weeklySales, 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates(Request $request)
    {
        return response()->json([
            'payload' => DB::table('states')->where('country_id', $request->id)->get(),
            'message' => 'List of states', 'dev_message' => '', 'code' => 1
        ]);
    }

    /**
     * this will return all the tags
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTags()
    {
        return response()->json([
            'payload' => TagsModel::all(), 'message' => '',
            'dev_message' => '', 'code' => 1
        ]);
    }
}

