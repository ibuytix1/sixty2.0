<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login-step-1', 'api\v1\ApiController@login_step_1');
Route::post('login', 'api\v1\ApiController@login');
Route::post('register', 'api\v1\ApiController@register');
Route::post('complete-register', 'api\v1\ApiController@completeRegister');
Route::post('forgot-password', 'api\v1\ApiController@sendForgetPasswordToken');

/**
 * organizer's route
 */
Route::group(['prefix' => 'organizer'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('update-password', 'api\v1\ApiController@updatePassword');
//        Route::post('user-profile', 'api\v1\ApiController@userProfile');
        Route::post('update-profile', 'api\v1\ApiController@updateProfile');
        Route::post('update-social-media', 'api\v1\ApiController@updateSocialMediaAccounts');

        //Bank Detail
        Route::post('add-bank-account', 'api\v1\ApiController@addBankAccount');
        Route::get('bank-account-list', 'api\v1\ApiController@bankAccountList');
        Route::post('update-bank-account', 'api\v1\ApiController@updateBankAccount');
        Route::post('delete-bank-account', 'api\v1\ApiController@deleteBankAccount');

        //PayPal
        Route::post('add-paypal-account', 'api\v1\ApiController@addPayPalAccount');
        Route::get('paypal-account-list', 'api\v1\ApiController@PayPalAccountList');
        Route::post('update-paypal-account', 'api\v1\ApiController@updatePayPalAccount');
        Route::post('delete-paypal-account', 'api\v1\ApiController@deletePayPalAccount');

        //Coupon
        Route::post('create-coupon', 'api\v1\ApiController@createCoupon');
        /*Route::post('event-list', 'api\v1\ApiController@eventListingForCoupon');*/
        /*Route::post('coupon-list', 'api\v1\ApiController@couponList');*/
        Route::get('coupon-list', 'api\v1\ApiController@couponList');
        Route::post('update-coupon', 'api\v1\ApiController@updateCoupon');
        Route::post('delete-coupon', 'api\v1\ApiController@deleteCoupon');
        Route::get('search-coupon', 'api\v1\ApiController@searchCoupon');
        /*Route::post('update-coupon-code', 'api\v1\ApiController@updateCouponCode');*/
        Route::post('event-list-for-coupon', 'api\v1\ApiController@eventListForCoupon');

        // Event
        Route::post('add-event', 'api\v1\ApiController@addEvent');
        Route::post('category-list', 'api\v1\ApiController@categoryList');
        Route::post('tag-list', 'api\v1\ApiController@tagList');
        Route::post('subcategory-list', 'api\v1\ApiController@subcategoryList');
        Route::get('live-event-list', 'api\v1\ApiController@liveEventsList');
        Route::get('draft-event-list', 'api\v1\ApiController@draftEventsList');
        Route::get('past-event-list', 'api\v1\ApiController@pastEventsList');
        Route::post('update-event', 'api\v1\ApiController@updateEvent');
        Route::post('view-single-event', 'api\v1\ApiController@viewSingleEvent');
        Route::post('delete-event', 'api\v1\ApiController@deleteEvent');
        Route::post('activate-event', 'api\v1\ApiController@activateEvent');
        Route::post('my-events-all', 'api\v1\ApiController@myEventsAll');
        //Contact
        Route::post('import-contact', 'api\v1\ApiController@importContact');
        Route::get('contact-list', 'api\v1\ApiController@contactList');
        Route::post('update-contact', 'api\v1\ApiController@updateContact');
        Route::post('delete-contact', 'api\v1\ApiController@deleteContact');
        Route::get('search-contact', 'api\v1\ApiController@searchContact');
        Route::get('contact-list-by-event', 'api\v1\ApiController@contactListByEvent');
        Route::post('send-bulk-mail-to-contact', 'api\v1\ApiController@sendBulkMail');
        Route::post('get-events-for-import-contacts', 'api\v1\ApiController@getEventsForImportContacts');

        //Attendee
        Route::post('add-attendee', 'api\v1\ApiController@addAttendee');
        Route::get('attendee-list', 'api\v1\ApiController@listAttendee');
        Route::get('search-attendee', 'api\v1\ApiController@searchAttendee');
        Route::get('search-attendee-by-date', 'api\v1\ApiController@searchAttendeeByDate');
        Route::post('export-attendee-list', 'api\v1\ApiController@exportAttendeeDataToExcel');

        // all promotion requests
        Route::post('all-promo', 'api\v1\ApiController@getAllPromotionRequest');
        Route::post('promo/requests', 'api\v1\ApiController@getAllPromo');
        // accept/reject promo request
        Route::post('update-promo-status', 'api\v1\ApiController@updatePromoStatus');
        /*Route::post('promo-reject', 'api\v1\ApiController@promoReject');*/


        //helpdesk ticket
        Route::post('/help-ticket-all', 'api\v1\ApiController@getAllHelpTickets');
        Route::post('/help-ticket', 'api\v1\ApiController@getHelpTicket');
        Route::post('/reply-help-ticket', 'api\v1\ApiController@replyHelpTicket');
        Route::get('/my-events', 'api\v1\ApiController@myEvents');
        // Route::post('/test-image-upload', 'api\v1\ApiController@testImageUpload');

        // list of the followers
        Route::post('/followers', 'api\v1\ApiController@followers');
        // orders listing.
        Route::post('/orders', 'api\v1\ApiController@orders');
        Route::post('/sales', 'api\v1\ApiController@sales');
        Route::post('/event-insights', 'api\v1\ApiController@insights');
        Route::post('/ticket-sales', 'api\v1\ApiController@ticketSales');
        Route::post('/recent-sells', 'api\v1\ApiController@recentSells');
    });
});
/**
 * Promotor's Routes
 */
Route::group(['prefix' => 'promoter'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('update-password', 'api\v1\ApiController@updatePassword');
//        Route::post('user-profile', 'api\v1\ApiController@userProfile');
        Route::post('update-profile', 'api\v1\ApiController@updateProfile');
        Route::post('update-social-media', 'api\v1\ApiController@updateSocialMediaAccounts');

        //Bank Detail
        Route::post('add-bank-account', 'api\v1\ApiController@addBankAccount');
        Route::get('bank-account-list', 'api\v1\ApiController@bankAccountList');
        Route::post('update-bank-account', 'api\v1\ApiController@updateBankAccount');
        Route::post('delete-bank-account', 'api\v1\ApiController@deleteBankAccount');

        //PayPal
        Route::post('add-paypal-account', 'api\v1\ApiController@addPayPalAccount');
        Route::get('paypal-account-list', 'api\v1\ApiController@PayPalAccountList');
        Route::post('update-paypal-account', 'api\v1\ApiController@updatePayPalAccount');
        Route::post('delete-paypal-account', 'api\v1\ApiController@deletePayPalAccount');
        // just for testing Promoters Controller
        Route::post('test', 'api\v1\PromotersController@test');

        Route::post('category-list', 'api\v1\UserApiController@allCategoryList');
        Route::post('event-list-by-category', 'api\v1\UserApiController@eventListByCategory');
        Route::post('view-organizer-profile', 'api\v1\UserApiController@viewOrganizerProfile');
        Route::post('view-single-event', 'api\v1\ApiController@viewSingleEvent');

        Route::post('promotion-request', 'api\v1\PromotersController@promotionRequest');
        // all promotion list with the filter for rejected, accepted and pending promo
        Route::post('promo/requests', 'api\v1\PromotersController@getAllPromo');
        Route::post('following', 'api\v1\PromotersController@getFollowing');
        // promoter helpdesk ticket
        Route::post('create-help-ticket', 'api\v1\PromotersController@helpdesk');
        // get all my helpdesk tickets
        Route::post('help-tickets-all', 'api\v1\PromotersController@getHelpdeskTickets');
        Route::post('update-help-ticket-message', 'api\v1\PromotersController@updateHelpdeskMessage');
        Route::post('help-ticket', 'api\v1\PromotersController@getHelpdeskTicket');
        Route::get('following-list', 'api\v1\PromotersController@followingList');

        Route::post('become-organizer', 'api\v1\PromotersController@becomesOrganizer');

    });
});
/**
 * logged in user's route
 */
Route::group(['prefix' => 'user'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('update-password', 'api\v1\ApiController@updatePassword');
        Route::post('add-ticket-to-cart', 'api\v1\UserApiController@addTicketToCart');
        Route::post('ticket-cart-list', 'api\v1\UserApiController@cartList');
        Route::post('follow-organizer', 'api\v1\UserApiController@followOrganizer');
        Route::post('unfollow-organizer', 'api\v1\UserApiController@UnfollowOrganizer');
        Route::post('remove-cart-item', 'api\v1\UserApiController@removeFormCart');

        // apply coupon on cart item
        Route::post('apply-coupon', 'api\v1\UserApiController@applyCoupon');

        // user helpdesk ticket
        Route::post('create-help-ticket', 'api\v1\UserApiController@helpdesk');
        // get all user helpdesk tickets
        Route::post('update-help-ticket-message', 'api\v1\UserApiController@updateHelpdeskMessage');
        Route::post('help-tickets-all', 'api\v1\UserApiController@getHelpdeskTickets');
        Route::post('help-ticket', 'api\v1\UserApiController@getHelpdeskTicket');
        Route::post('following', 'api\v1\UserApiController@followingList');
        Route::get('following-list', 'api\v1\UserApiController@followingList');


        Route::post('update-profile', 'api\v1\ApiController@updateProfile');
        Route::post('update-social-media', 'api\v1\ApiController@updateSocialMediaAccounts');

        //Bank Detail
        /*Route::post('add-bank-account', 'api\v1\ApiController@addBankAccount');
        Route::get('bank-account-list', 'api\v1\ApiController@bankAccountList');
        Route::post('update-bank-account', 'api\v1\ApiController@updateBankAccount');
        Route::post('delete-bank-account', 'api\v1\ApiController@deleteBankAccount');*/

        //PayPal
        Route::post('add-paypal-account', 'api\v1\ApiController@addPayPalAccount');
        Route::get('paypal-account-list', 'api\v1\ApiController@PayPalAccountList');
        Route::post('update-paypal-account', 'api\v1\ApiController@updatePayPalAccount');
        Route::post('delete-paypal-account', 'api\v1\ApiController@deletePayPalAccount');

        // my orders list
        Route::post('past-event-orders', 'api\v1\UserApiController@pastEventOrders');
        Route::post('upcoming-event-orders', 'api\v1\UserApiController@upcomingEventOrders');


        // user card details
        Route::post('add-card', 'api\v1\UserApiController@addCard');
        Route::post('card-list', 'api\v1\UserApiController@cardList');
        Route::post('update-card', 'api\v1\UserApiController@updateCard');
        Route::post('delete-card', 'api\v1\UserApiController@deleteCard');
    });
//    Route::post('ticket-list', 'api\v1\UserApiController@ticketList');
});
/**
 * can access without login
 */
Route::get('search-event', 'api\v1\UserApiController@searchEvent');
Route::post('organizer-list', 'api\v1\UserApiController@organizerList');
/*Route::get('category-list', 'api\v1\UserApiController@categoryList');*/
Route::post('all-category-list', 'api\v1\UserApiController@allCategoryList');
Route::post('view-single-event', 'api\v1\UserApiController@viewSingleEvent');
Route::post('event-list-by-category', 'api\v1\UserApiController@eventListByCategory');
Route::post('upcoming-event-list', 'api\v1\UserApiController@weeklyUpcomingEventList');
Route::post('upcoming-event-list-by-month', 'api\v1\UserApiController@upcomingEventListByMonth');
Route::post('event-list-by-week', 'api\v1\UserApiController@eventListByWeek');
Route::post('schedules-events-list', 'api\v1\UserApiController@schedulesEventList');
Route::post('view-organizer-profile', 'api\v1\UserApiController@viewOrganizerProfile');
Route::post('event-list-by-organizer', 'api\v1\UserApiController@eventListByOrganizer');
Route::get('all-events', 'api\v1\UserApiController@allEvents');

Route::post('help-categories', 'api\v1\UserApiController@getHelpdeskCategories');
Route::post('reset-password', 'api\v1\ApiController@resetPassword');
Route::post('me', 'api\v1\ApiController@userProfile')->middleware('auth:api');
Route::post('get-states', 'api\v1\ApiController@getStates');
Route::middleware('auth:api')->group(function(){
    Route::post('create-order', 'api\v1\OrderApiController@store');
    Route::post('update-order', 'api\v1\OrderApiController@update');
});

Route::post('get-tags', 'api\v1\ApiController@getTags')->middleware('auth:api');