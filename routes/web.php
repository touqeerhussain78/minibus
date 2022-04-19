<?php
use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

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
// Route::get('/update-uuid', 'HomeController@updateUuid');
Route::post('/user/register', 'Auth\RegisterController@registerUser')->name('user.register');
Route::post('/user/set-password', 'Auth\RegisterController@setpassword')->name('user.set-password');
Route::get('/user-resend', 'Auth\RegisterController@resend')->name('user.user-resend');
Route::post('subscribe', 'HomeController@submitNewsletter');

//Operator Routes

Route::group(['middleware' => 'prevent-back-history'],function(){

Route::prefix('operators')->name('operators.')->namespace('Operator')->group(function(){

    Route::post('/register/operator', 'Auth\RegisterController@registerOperator')->name('register.operator');
    Route::post('/register/operator-minibus', 'Auth\RegisterController@minibus')->name('register.minibus');
    Route::post('/register/verify', 'Auth\RegisterController@verify')->name('register.verify');
    Route::post('/register/setpassword', 'Auth\RegisterController@setpassword')->name('register.setpassword');
    Route::post('/password-reset/send-verification-code', 'Auth\ForgotPasswordController@sendVerificationCode')->name('send-verification-code');
    Route::post('/password-reset/verify-verification-code', 'Auth\ForgotPasswordController@verifyVerificationCode')->name('verify-verification-code');
    Route::post('/password-reset/update-password', 'Auth\ForgotPasswordController@updatePassword')->name('update-password');
    Route::get('/operator-resend', 'Auth\RegisterController@resend')->name('operator-resend');

    Auth::routes();
    
    Route::middleware('auth:operators')->group(function(){

        // Profile
        Route::get('/', 'OperatorController@index');
        
        Route::get('/edit', 'OperatorController@edit');
        Route::post('/update', 'OperatorController@update');
        Route::post('/update_password', 'OperatorController@updatePassword')->name('update_password');
        Route::get('/delete_minibus_image/{id}', 'OperatorController@deleteMinibusImage');
        
        Route::post('/change-status', 'OperatorController@changeTripStatus'); // Change Trip Status

         // Quotations
         Route::get('/quotations', 'QuotationsController@index')->name('quotations'); // quotation requests
         Route::get('/quotations/sent', 'QuotationsController@sent')->name('quotations.sent'); // quotation sent

         //Quotation Sent
         Route::get('/quotations/sent', 'QuotationSentController@index')->name('quotations.sent'); // quotation sent
         Route::get('/quotations/sent/recently-sent/{id}', 'QuotationSentController@sent')->name('quotations.sent.recently-sent'); // sent trip
         Route::get('/quotations/sent/confirmed/{id}', 'QuotationSentController@confirmed')->name('quotations.sent.confirmed'); // confirmed trip
         Route::get('/quotations/sent/declined/{id}', 'QuotationSentController@rejected')->name('quotations.sent.declined'); // declined trip

         //Quotation Accepted
         Route::get('/quotations/accepted', 'QuotationAcceptedController@index')->name('quotations.accepted'); // quotation accepted
         Route::get('/quotations/accepted/pending/{id}', 'QuotationAcceptedController@pending')->name('quotations.accepted.pending'); // pending trip
         Route::get('/quotations/accepted/ongoing/{id}', 'QuotationAcceptedController@ongoing')->name('quotations.accepted.ongoing'); // ongoing trip
         Route::get('/quotations/accepted/completed/{id}', 'QuotationAcceptedController@completed')->name('quotations.accepted.completed'); // completed trip
         Route::get('/quotations/accepted/cancelled/{id}', 'QuotationAcceptedController@cancelled')->name('quotations.accepted.cancelled'); // cancelled trip
        // Wallet
         Route::get('/wallet', 'WalletController@index')->name('wallet'); // quotation wallet
         Route::post('/wallet/payment', 'WalletController@payment')->name('wallet.payment'); // quotation wallet

         Route::get('/quotations/{id}', 'QuotationsController@show')->name('quotations.show'); // booking request details
         Route::post('/quotations/send', 'QuotationsController@sendQuotation')->name('quotations.send'); // booking request details


        //Special Invites
        Route::get('/special-invites', 'SpecialInvitesController@index')->name('special-invites');

        //payment-logs
        Route::get('/payment-logs', 'OperatorController@paymentLogs')->name('payment-logs');
        Route::get('/payment-logs/{id}', 'OperatorController@paymentLogDetails')->name('payment-logs.show');
        Route::post('/mark-received', 'OperatorController@markReceived');

        //quotation-logs
        Route::get('/quotation-logs', 'OperatorController@quotationLogs')->name('quotation-logs');

         //Chat
        Route::get('/chat', 'OperatorController@chat')->name('chat');
        Route::get('/customer/{id}', 'OperatorController@customerChat')->name('customer-chat');

         //contact us
        Route::get('/contact-us', 'OperatorController@contact')->name('contact-us');
        Route::post('/contact-store', 'OperatorController@contactStore')->name('contact.store');
        
        Route::post('/review-reply', 'OperatorController@reviewReply')->name('review-reply');
        Route::post('update-notification-count', 'OperatorController@updateNotificationCount');
        Route::get('get-message-count', 'OperatorController@getMessageCount');

    });
});


//Route::get('/login', '\App\Http\Controllers\Auth\LoginController@login')->name('login');
Auth::routes();
Route::post('/password-reset/send-verification-code', 'Auth\ForgotPasswordController@sendVerificationCode')->name('user.send-verification-code');
Route::post('/password-reset/verify-verification-code', 'Auth\ForgotPasswordController@verifyVerificationCode')->name('user.verify-verification-code');
Route::post('/password-reset/update-password', 'Auth\ForgotPasswordController@updatePassword')->name('user.update-password');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');
Route::post('/verify_account', '\App\Http\Controllers\Auth\RegisterController@verifyAccount')->name('verify_account');
Route::post('/change-password', '\App\Http\Controllers\Auth\RegisterController@changePassword')->name('change-password');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/operator/{id}', 'HomeController@getOperator')->name('home.operator');

Route::post('/quote', 'UserController@getQuote')->name('quote');
Route::get('/bookings/trip', 'BookingsController@bookTrip')->name('bookings.trip');

 // Notifications
   
 Route::get('/markasread/{id?}', function($id=Null){
    if($id){
    DatabaseNotification::find($id)->markAsRead();
    $notification =  DatabaseNotification::where('id',$id)->first();
    return ['message' => 'Notifications marked as read', 'url' => $notification->data['url'] ?? ""];
    }
    else{
        if(Auth::guard('operators')->check() == true){
            Auth::guard('operators')->user()->notifications->markAsRead();
        }
        else{
            auth()->user()->notifications->markAsRead();
        }
        return ['message' => 'Notifications marked as read'];
    }    

    

})->name('markasread');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/clear', function(){
        session()->forget('trip_details');
        return redirect()->route('home');
    });

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/mail_check', 'HomeController@mail_check');

    //Booking
    Route::post('/bookings/store', 'BookingsController@store')->name('bookings.store');
    Route::get('/bookings', 'BookingsController@index')->name('bookings');
    Route::get('/booking/{id}', 'BookingsController@show')->name('booking.show');
    Route::post('/bookings/cancel', 'BookingsController@cancel')->name('bookings.cancel');
    Route::get('/bookings/accepted/{id}', 'BookingsController@accepted')->name('bookings.accepted');
    Route::get('/bookings/confirmed/{id}', 'BookingsController@confirmed')->name('bookings.confirmed');
    Route::get('/bookings/ongoing/{id}', 'BookingsController@ongoing')->name('bookings.ongoing');
    Route::get('/bookings/completed/{id}', 'BookingsController@completed')->name('bookings.completed');
    Route::get('/bookings/cancelled/{id}', 'BookingsController@cancelled')->name('bookings.cancelled');
   
    Route::post('/bookings/payment', 'BookingsController@addPayment')->name('bookings.payment');
    Route::post('/bookings/change-quote-status', 'BookingsController@changeQuoteStatus')->name('bookings.change-quote-status'); // change quotation status (accept/reject)
    //Booking Special Invites
    Route::get('/bookings/special-invites/{id}', 'BookingsController@specialInvite')->name('bookings.special-invites');
    Route::post('/bookings/send-special-invites', 'BookingsController@sendSpecialInvite')->name('bookings.send-special-invites');
    //Report operator
    Route::post('/bookings/report', 'BookingsController@report')->name('bookings.report');

    Route::post('/bookings/rating', 'BookingsController@rateOperator')->name('bookings.rate');

    //User profile
    Route::get('/profile', 'UserController@view')->name('profile');
    Route::get('/profile/edit', 'UserController@edit')->name('profile.edit');
    Route::post('/profile/update', 'UserController@update')->name('profile.update');
    Route::post('/profile/update_password', 'UserController@updatePassword')->name('profile.update_password');

   

    //payment-logs
    Route::get('/payment-logs', 'UserController@paymentLogs')->name('payment-logs');

    //add reviews
    Route::post('/add-review', 'UserController@addReview')->name('add-review');

   //Chat
   Route::get('/chat/{id}', 'UserController@chat')->name('chat');
   Route::get('/messages', 'HomeController@messages')->name('messages');
   Route::post('update-notification-count', 'UserController@updateNotificationCount');
   Route::get('get-message-count', 'UserController@getMessageCount');
   

});


});

 //contact us
 Route::get('/contact-us', 'HomeController@contact')->name('contact-us');
 Route::post('/contact-store', 'HomeController@contactStore')->name('contact.store');

 Route::get('/about', 'HomeController@about')->name('about');
 Route::get('/clients', 'HomeController@clients')->name('clients');
 Route::get('/services', 'HomeController@services')->name('services');
 Route::get('/advertise', 'HomeController@advertise')->name('advertise');
 Route::get('/view-all-operator', 'HomeController@allOperators')->name('view-all-operator');
 Route::get('/search', 'HomeController@search')->name('search');

 Route::get('/test', function(){
        $operators = App\Operator::get();
        foreach($operators as $row){
            $bus = \App\Models\Operator\Minibus::create([
                'operator_id'   => $row->id,
            ]);
        }
       
        
    return 'done';
 });


