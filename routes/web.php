<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Auth;

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// admin
Route::group(['prefix' => config('constants.admin')], function () {
    Route::get('/', function () {
        return view('admin.login');
    });
    Route::post('/get_login', array('uses' => 'admin\LoginController@get_login'));

    Route::get('logout', array('uses' => 'admin\LoginController@logout'));
    Route::get('changePassword', array('uses' => 'admin\LoginController@changePassword'));
    Route::post('saveChangePassword', array('uses' => 'admin\LoginController@saveChangePassword'));
    Route::get('/dashboard', array('uses' => 'admin\DashboardControler@home'));

    // Category
    Route::get('listCategory', array('uses' => 'admin\CategoryController@categoryList'));
    Route::get('ajaxListCategory', array('uses' => 'admin\CategoryController@ajaxListCategory'));
    Route::get('addCategory', array('uses' => 'admin\CategoryController@addCategory'));
    Route::post('saveCategory', array('uses' => 'admin\CategoryController@saveCategory'));
    Route::get('editCategory/{id}/', array('uses' => 'admin\CategoryController@editCategory'));
    Route::post('deleteCategory', array('uses' => 'admin\CategoryController@deleteCategory'));
    Route::get('listCategoryJson', array('uses' => 'admin\CategoryController@listCategoryJson'));

    //Sub category
    Route::get('addSubcategory', array('uses' => 'admin\SubCategoryController@addSubcategory'));
    Route::get('listSubCategory', array('uses' => 'admin\SubCategoryController@subCategoryList'));
    Route::get('addSubCategory', array('uses' => 'admin\SubCategoryController@addSubCategory'));
    Route::post('saveSubCategory', array('uses' => 'admin\SubCategoryController@saveSubCategory'));
    Route::get('editSubCategory/{id}/', array('uses' => 'admin\SubCategoryController@editSubCategory'));
    Route::post('deleteSubCategory', array('uses' => 'admin\SubCategoryController@deleteSubCategory'));
    Route::get('listSubCategoryJson', array('uses' => 'admin\SubCategoryController@listSubCategoryJson'));


    //Organizer
    Route::get('addOrganizer', array('uses' => 'admin\OrganizerController@addOrganizer'));
    Route::get('listOrganizer', array('uses' => 'admin\OrganizerController@OrganizerList'));
    Route::post('saveOrganizer', array('uses' => 'admin\OrganizerController@saveOrganizer'));
    Route::get('editOrganizer/{id}/', array('uses' => 'admin\OrganizerController@editOrganizer'));
    Route::post('deleteOrganizer', array('uses' => 'admin\OrganizerController@deleteOrganizer'));
    Route::post('activeOrgnizer', array('uses' => 'admin\OrganizerController@activeOrgnizer'));
    Route::get('viewOrgnizerProfile/{id}', array('uses' => 'admin\OrganizerController@viewOrgnizerProfile'));
    Route::get('excel-organizer', array('uses' => 'admin\OrganizerController@excelOrginer'));
    Route::get('listOrganizerJson', array('uses' => 'admin\OrganizerController@OrganizerListDatatable'));

    //Events
    Route::get('eventList', array('uses' => 'admin\EventController@eventList'));
    Route::get('viewEvent/{id}', array('uses' => 'admin\EventController@viewEvent'));
    Route::post('hideUnhideEvent', array('uses' => 'admin\EventController@hideUnhideEvent'));
    Route::post('activeEvent', array('uses' => 'admin\EventController@activeEvent'));
    Route::get('listEventJson', array('uses' => 'admin\EventController@EventListDatatable'));


    //Users
    Route::get('usersList', array('uses' => 'admin\UserController@usersList'));
    Route::get('usersRole', array('uses' => 'admin\UserController@usersRole'));
    Route::get('AddUser', array('uses' => 'admin\UserController@AddUser'));
    Route::get('checkUserEmailExist', array('uses' => 'admin\UserController@checkUserEmailExist'));
    Route::post('saveUsers', array('uses' => 'admin\UserController@saveUsers'));
    Route::get('manage-role/{id}', array('uses' => 'admin\UserController@manageRole'));
    Route::get('userDetail/{id}', array('uses' => 'admin\UserController@userDetail'));
    Route::post('activeUser', array('uses' => 'admin\UserController@activeUser'));
    Route::post('saveUserRole', array('uses' => 'admin\UserController@saveUserRole'));
    Route::post('deleteUser', array('uses' => 'admin\UserController@deleteUser'));
    Route::get('excel-users', array('uses' => 'admin\UserController@excelUsers'));
    Route::get('listUserJson', array('uses' => 'admin\UserController@listUserJson'));


    //Promoter
    Route::get('promoterList', array('uses' => 'admin\PromoterController@promoterList'));
    Route::get('add-promoter', array('uses' => 'admin\PromoterController@addPromoter'));
    Route::get('update-promoter/{id}', array('uses' => 'admin\PromoterController@updatePromoter'));
    Route::post('savePromoter', array('uses' => 'admin\PromoterController@savePromoter'));
    Route::get('promoterDetail/{id}', array('uses' => 'admin\PromoterController@promoterDetail'));
    Route::post('activePromoter', array('uses' => 'admin\PromoterController@activePromoter'));
    Route::post('deletePromoter', array('uses' => 'admin\PromoterController@deletePromoter'));
    Route::get('checkmail', array('uses' => 'admin\PromoterController@checkmail'));
    Route::get('excel-promoter', array('uses' => 'admin\PromoterController@excelPromoter'));
    Route::get('listPromoterJson', array('uses' => 'admin\PromoterController@PromoterListDatatable'));


    //CMS Pages
    Route::get('add-cms-pages', array('uses' => 'admin\ManageStaticPageController@addcmspages'));
    Route::get('cms-pages-list', array('uses' => 'admin\ManageStaticPageController@cmspagelist'));
    Route::get('edit-cms-page/{id}', array('uses' => 'admin\ManageStaticPageController@editCmsPage'));
    Route::post('delete-cms-pages', array('uses' => 'admin\ManageStaticPageController@deleteCmsPages'));
    Route::post('save-cms-pages', array('uses' => 'admin\ManageStaticPageController@saveCmsPages'));

    //Plans
    Route::get('add-plans', array('uses' => 'admin\PlanController@addPlan'));
    Route::get('list-plans', array('uses' => 'admin\PlanController@planList'));
    Route::get('view-plan/{id}', array('uses' => 'admin\PlanController@viewPlan'));
    Route::get('update-plan/{id}', array('uses' => 'admin\PlanController@editPlan'));
    Route::post('delete-plan', array('uses' => 'admin\PlanController@deletePlan'));
    Route::post('save-plans', array('uses' => 'admin\PlanController@savePlan'));

    //Peyment Report
    Route::get('list-payment', array('uses' => 'admin\PaymentController@listPayment'));

    //Contact
    Route::get('contactList', array('uses' => 'admin\ContactController@contactList'));
    Route::get('addContact', array('uses' => 'admin\ContactController@addContact'));
    Route::get('listContactJson', array('uses' => 'admin\ContactController@listContactJson'));
    Route::get('editContact/{id}', array('uses' => 'admin\ContactController@editContact'));
    Route::post('saveContact', array('uses' => 'admin\ContactController@saveContact'));
    Route::post('deleteContact', array('uses' => 'admin\ContactController@deleteContact'));

    //Tags
    Route::get('listTags', array('uses' => 'admin\TagsController@tagList'));
    Route::get('ajaxListTags', array('uses' => 'admin\TagsController@ajaxListTag'));
    Route::get('addTag', array('uses' => 'admin\TagsController@addTag'));
    Route::post('saveTag', array('uses' => 'admin\TagsController@saveTag'));
    Route::get('editTag/{id}/', array('uses' => 'admin\TagsController@editTag'));
    Route::post('deleteTag', array('uses' => 'admin\TagsController@deleteTag'));
    Route::get('listTagJson', array('uses' => 'admin\TagsController@listTagJson'));

});
//organizer
Route::get('/Organizer', function () {
    return redirect('organizer/dashboard');
});
Route::get('/Organizer/checkemail', array('uses' => 'admin\OrganizerController@checkmail'));
Route::group(['prefix' => 'organizer'], function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('/dashboard', 'OrganizerController@dashboard')->name('org-home');
    //events
    Route::get('/event-create', 'OrganizerController@eventCreate')->name('org-event-create');
    Route::get('/live-events', 'OrganizerController@liveEvents')->name('org-live-events');
    Route::get('/draft-events', 'OrganizerController@draftEvents')->name('org-draft-events');
    Route::get('/past-events', 'OrganizerController@pastEvents')->name('org-past-events');
    //profile
    Route::get('/my-profile', 'OrganizerController@myProfile')->name('org-my-profile');
    //coupon
    Route::get('/coupon/list', 'OrganizerController@couponList')->name('org-coupon-list');
    Route::get('/coupon/create', 'OrganizerController@createCoupon')->name('org-create-coupon');
    //contact
    Route::get('/contact/list', 'OrganizerController@contactList')->name('org-contact-list');
    //export contacts
    Route::get('export-contacts/{type}', 'OrganizerController@exportContacts')->name('export-contacts');
    //payment details
    Route::get('add-account-detail', 'OrganizerController@addAccountDetails')->name('add-account');
    Route::get('manage-accounts', 'OrganizerController@manageAccounts')->name('manage-accounts');
    //attendees
    Route::get('attendees', 'OrganizerController@attendees')->name('attendees-list');
    Route::get('export-attendees/{type}', 'OrganizerController@exportAttendees')->name('export-attendees');
    Route::get('promo-requests', 'OrganizerController@promoRequests')->name('promo-requests');
    Route::get('sent-promo', 'OrganizerController@sentPromo')->name('sent-promo');
    Route::get('followers', 'OrganizerController@followers')->name('organizer-followers');
    Route::get('orders', 'OrganizerController@orders')->name('orders');
    Route::get('sales', 'OrganizerController@sales')->name('sales');

});
// logout user
Route::get('/logout', 'UserController@logout')->name('logout');
//user
Route::group(['prefix' => 'user'], function () {
    Route::get('/dashboard', 'UserController@dashboard')->name('user-home');

    Route::get('/my-profile', 'UserController@myProfile')->name('user-my-profile');
    Route::get('/user-manage-accounts', 'UserController@manageAccounts')
        ->name('user-manage-accounts');
    Route::get('/event-create', 'UserController@eventCreate')->name('user-event-create');
    Route::get('/following', 'UserController@following')->name('user-following');
    Route::get('/support', 'UserController@support')->name('user-support');
});
//promoter
Route::get('/promoter', function(){
    return redirect('promoter/dashboard');
});
Route::group(['prefix' => 'promoter'], function () {
    Route::get('/dashboard', 'PromoterController@dashboard');
    //profile
    Route::get('/my-profile', 'PromoterController@myProfile')->name('promoter-my-profile');
    Route::get('/dashboard', 'PromoterController@dashboard')->name('promoter-home');
    Route::get('/promoter-manage-accounts', 'PromoterController@manageAccounts')
        ->name('promoter-manage-accounts');
    Route::get('/following', 'PromoterController@following')->name('promoter-following');
    Route::get('/support', 'PromoterController@support')->name('promoter-support');
    Route::get('/event-create', 'PromoterController@eventCreate')->name('promoter-event-create');
});
Route::get('/register', function () {
    return redirect()->route('login');
});
Route::get('/complete-register/{token}/{email}', 'CustomAuthController@completeRegisterForm');
//Route::get('/forgot-password', 'CustomAuthController@forgotPassword');
Route::get('/reset-password/{token}', 'CustomAuthController@resetPassword');
Route::get('/event/{id}', 'PagesController@singleEvent');
Route::get('/search', 'PagesController@search');
Route::get('/checkout', 'UserController@checkout');
Route::get('/create-event', 'RedirectToCreateEvent@eventCreate')->name('event-create');