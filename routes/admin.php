<?php

use Illuminate\Notifications\DatabaseNotification;


Auth::routes();
Route::get('logout', function (){
    auth()->guard('admin')->logout();
    return redirect()->route('admin.login');
});

Route::group(['middleware' => 'auth:admin'], function (){
    Route::group(['prefix' => 'api'], function(){

        Route::post('change-password', 'AdminController@changePassword');
        Route::post('update-profile', 'AdminController@updateProfile');
        Route::get('dashboard-stats', 'AdminController@dashboardStats');

        Route::get('/unreadNotifications', function(){
            return ['data' => auth()->user()->unreadNotifications];
        });

        Route::get('/markasread/{id?}', function($id=Null){
            if($id){
                DatabaseNotification::find($id)->markAsRead();
                $notification =  DatabaseNotification::where('id',$id)->first();
                return ['message' => 'Notifications marked as read', 'url' => $notification->data['url'] ?? ""];
            } 
            else{

                if(Auth::guard('admin')->check() == true){
                    Auth::guard('admin')->user()->notifications->markAsRead();
                }
                else{
                    auth()->user()->notifications->markAsRead();
                }
                return ['message' => 'Notifications marked as read'];
            }
        
        })->name('markasread');

        Route::group(['prefix' => 'users'], function(){
            Route::get('/', 'UserController@index');
            Route::get('/{id}', 'UserController@edit');
            Route::get('/change-status/{id}', 'UserController@changeStatus');
            Route::post('/store', 'UserController@store');
            Route::post('/update', 'UserController@update');
        });
        Route::group(['prefix' => 'operator'], function(){
            Route::get('/', 'OperatorController@index');
            Route::get('/{id}', 'OperatorController@edit');
            Route::get('/change-status/{id}', 'OperatorController@changeStatus');
            Route::post('/store', 'OperatorController@store');
            Route::post('/update', 'OperatorController@update');
        });

        Route::group(['prefix' => 'quotations'], function(){
            Route::get('/', 'QuotationsController@index');
            Route::get('/pending/{id}', 'QuotationsController@pending');
            Route::get('/accepted/{id}', 'QuotationsController@accepted');
            Route::get('/confirmed/{id}', 'QuotationsController@confirmed');
            Route::get('/completed/{id}', 'QuotationsController@completed');
            Route::get('/cancelled/{id}', 'QuotationsController@cancelled');
            Route::post('/refund', 'QuotationsController@refund');
            Route::post('/payOperator', 'QuotationsController@payOperator');
            // stats
            Route::get('/stats', 'QuotationsController@statistics');
            Route::get('/stats/user/{id}', 'QuotationsController@userStats');
            Route::get('/stats/operator/{id}', 'QuotationsController@operatorStats');
            Route::post('/stats/operator/send', 'QuotationsController@sendQuotes');
        });

        Route::group(['prefix' => 'payments'], function(){
            Route::get('/', 'PaymentController@index');
          //  Route::get('/{id}', 'PaymentController@show');
            Route::get('/packages', 'PaymentController@packages');
            Route::get('/operator-payment-logs', 'PaymentController@operatorPaymentLogs');
            Route::get('/my-payments', 'PaymentController@myPayments');
            Route::get('/my-payment-chart-data', 'PaymentController@myPaymentsChartData');
            
        });
        Route::group(['prefix' => 'feedbacks'], function(){
            Route::get('/', 'FeedbackController@index');
            Route::get('/view/{id}', 'FeedbackController@show');
            Route::get('/reports', 'FeedbackController@reports');
            Route::get('/report-view/{id}', 'FeedbackController@reportView');
        });
    });

    Route::view('/{path?}', 'admin.pages.index')->where('path', ".*");

});

