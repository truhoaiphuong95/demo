<?php

use Illuminate\Support\Facades\Route;

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

Route::get('test', function(){
    return view('statistic-finance-year.blade');
});


Route::get('/download', 'TaiveController@getDanhsachCongkhai');
Route::get('/tracking', 'TrackingController@getSearch')->name('guest.tracking.index.get');
Route::post('/search', 'TrackingController@postSearch');
Route::get('/tracking/{ticket_id}/{sixdigit}', 'TrackingController@getByTicket')->name('guest.tracking.ticket.get');
Route::get('/customer/{client_id}', 'TrackingController@getByClient')->name('guest.tracking.client.get');

Route::get('/login','LoginController@getLogin')->name('guest.login.get');
Route::post('/login','LoginController@postLogin')->name('guest.login.post');

Route::group(['prefix' => '','middleware' => 'staff'], function() 
{
    Route::get('/','DashboardController@getView')->name('staff.dashboard.view.get');
    Route::get('/checkauth', function ()
    {
        return 'Loged in successed!';
    });
    Route::get('/afterlogin','LoginController@getAfterLogin')->name('staff.afterlogin.get');
    Route::get('/logout','LoginController@getLogout')->name('staff.logout.get');
    
    Route::get('/search', 'SearchController@getSearch')->name('staff.search.get');

    Route::group(['prefix' => 'techking'], function() 
    {
        Route::get('/dashboard', 'TechKing\DashboardController@getIndex')->name('staff.techking.dashboard.get');
    });
    
    Route::group(['prefix' => 'clients'], function() 
    {
        Route::get('/', 'ClientController@getList')->name('staff.client.list.get');
        Route::get('/search', 'ClientController@getSearch')->name('staff.client.search.get');
        Route::post('/search', 'ClientController@postSearch')->name('staff.client.search.post');
        Route::get('/{client_id}', 'ClientController@getView')->name('staff.client.view.get');
        Route::get('/add/{phone?}', 'ClientController@getAdd')->name('staff.client.add.get');
        Route::post('/add', 'ClientController@postAdd')->name('staff.client.add.post');
        Route::get('/edit/{client_id}', 'ClientController@getEdit')->name('staff.client.edit.get');
        Route::post('/edit/{client_id}', 'ClientController@postEdit')->name('staff.client.edit.post');
        Route::get('/export', 'ClientController@getExport')->name('staff.client.export.get');
        Route::get('/export/edu', 'ClientController@getExportEdu')->name('staff.client.exportedu.get');
        Route::get('/export/tech', 'ClientController@getExportTech')->name('staff.client.exporttech.get');
    });

    Route::group(['prefix' => 'financial'], function() 
    {
        Route::get('/', 'FinancialController@getTongquan');
        Route::get('/{field_id}', 'FinancialController@getField');
    });

    Route::prefix('receipts')->middleware('official')->group(function ()
    {
        Route::get('/', 'ReceiptController@getList')->name('staff.receipt.list.get');
        Route::get('/field/{field_id}', 'ReceiptController@getListbyField')->name('staff.receipt.listbyfield.get');
        Route::get('/{receipt_id}', 'ReceiptController@getView')->name('staff.receipt.view.get');
        Route::get('/print/{receipt_id}', 'ReceiptController@getPrint')->name('staff.receipt.print.get');
        Route::get('/add/{client_id}', 'ReceiptController@getAdd')->name('staff.receipt.add.get')->middleware('manager');
        Route::post('/add', 'ReceiptController@postAdd')->name('staff.receipt.add.post')->middleware('manager');
        Route::get('/edit/{receipt_id}', 'ReceiptController@getEdit')->name('staff.receipt.edit.get')->middleware('manager');
        Route::post('/edit/{receipt_id}', 'ReceiptController@postEdit')->name('staff.receipt.edit.post')->middleware('manager');
        Route::get('/destroy/{receipt_id}', 'ReceiptController@getDestroy')->name('staff.receipt.destroy.get')->middleware('manager');
    });

    Route::prefix('payments')->middleware('official')->group(function ()
    {
        Route::get('/', 'PaymentController@getList')->name('staff.payment.list.get');
        Route::get('/{payment_id}', 'PaymentController@getView')->name('staff.payment.view.get');
        Route::get('/print/{payment_id}', 'PaymentController@getPrint')->name('staff.payment.print.get');
        Route::get('/add/{client_id}', 'PaymentController@getAdd')->name('staff.payment.add.get')->middleware('manager');
        Route::get('/addmore', 'PaymentController@getAddmore')->name('staff.payment.addmore.get')->middleware('manager');
        Route::post('/add', 'PaymentController@postAdd')->name('staff.payment.add.post')->middleware('manager');
        Route::get('/edit/{payment_id}', 'PaymentController@getEdit')->name('staff.payment.edit.get')->middleware('manager');
        Route::post('/edit/{payment_id}', 'PaymentController@postEdit')->name('staff.payment.edit.post')->middleware('manager');
        Route::get('/destroy/{payment_id}', 'PaymentController@getDestroy')->name('staff.payment.destroy.get')->middleware('manager');
    });
    
    Route::group(['prefix' => 'tickets'], function() 
    {
        Route::get('/', 'TicketController@getList')->name('staff.ticket.list.get');
        Route::get('/searchByPhone', 'TicketController@getSearchByPhone')->name('staff.ticket.seachbyphone.get');
        Route::post('/searchByPhone', 'TicketController@postSearchByPhone')->name('staff.ticket.seachbyphone.post');
        Route::get('/{ticket_id}', 'TicketController@getView')->where('ticket_id', '[0-9]+')->name('staff.ticket.view.get');
        Route::get('/print/{ticket_id}', 'TicketController@getPrint')->name('staff.ticket.print.get');
        Route::get('/printpos/{ticket_id}', 'TicketController@getPrintPos')->name('staff.ticket.printpos.get');
        Route::get('/printinternal/{ticket_id}', 'TicketController@getPrintInternal')->name('staff.ticket.printinternal.get');
        Route::get('/edit/{ticket_id}', 'TicketController@getEdit')->name('staff.ticket.edit.get')->middleware('leader');
        Route::post('/edit', 'TicketController@postEdit')->name('staff.ticket.edit.post')->middleware('leader');
        Route::get('/add/{client_id}', 'TicketController@getAdd')->name('staff.ticket.add.get');
        Route::post('/add', 'TicketController@postAdd')->name('staff.ticket.add.post');
        Route::get('/add/useold/{ticket_id}', 'TicketController@getUseOld')->name('staff.ticket.useold.get');
        Route::get('/view/{ticket_id}/status/{status_id}/{price?}', 'TicketController@getChangeStatus')->name('staff.ticket.changestatus.get');
        Route::get('/rate/{ticket_id}', 'TicketRateController@getRate')->name('staff.ticket.rate.get');
        Route::post('/rate/{ticket_id}', 'TicketRateController@postRate')->name('staff.ticket.rate.post');
    });

    Route::group(['prefix' => 'services'], function() 
    {
        Route::get('/', 'ServiceController@getList')->name('staff.service.list.get');
        Route::get('/add', 'ServiceController@getAdd')->name('staff.service.add.get');
        Route::post('/add', 'ServiceController@postAdd')->name('staff.service.add.post');
        Route::get('/edit/{service_id}', 'ServiceController@getEdit')->name('staff.service.edit.get')->middleware('leader');
        Route::post('/edit/{service_id}', 'ServiceController@postEdit')->name('staff.service.edit.post')->middleware('leader');
        Route::get('/delete/{service_id}', 'ServiceController@getDelete')->name('staff.service.delete.get')->middleware('leader');
    });

    Route::group(['prefix' => 'statistic'], function() 
    {
        Route::get('/finance', 'StatisticController@getFinance')->name('staff.statistic.finance.get')->middleware('official');
    });
    Route::group(['prefix' => 'feedbacks'], function() 
    {
        Route::get('/', 'FeedbackController@getList')->name('staff.feedback.list.get');
    });
    
    Route::group(['prefix' => 'ticketlogs'], function() 
    {
        Route::get('/', 'TicketLogController@getList')->name('staff.ticketlog.list.get');
        Route::post('/add', 'TicketLogController@postAdd')->name('staff.ticketlog.add.post');
        Route::get('/{ticketlog_id}/setpublic', 'TicketLogController@getSetpublic')->name('staff.ticketlog.setpublic.get');
    });
    
    Route::group(['prefix' => 'courses'], function ()
    {
        Route::get('/', 'CourseController@getList')->name('staff.course.list.get');
        Route::get('/view/{course_id}', 'CourseController@getView')->name('staff.course.view.get');
        Route::get('/export/phone/{course_id}', 'CourseController@getPhoneList')->name('staff.course.exportphone.get');
        Route::get('/export/excel/{course_id}', 'CourseController@getExportExcel')->name('staff.course.exportexcel.get');
        Route::get('/add', 'CourseController@getAdd')->name('staff.course.add.get');
        Route::post('/add', 'CourseController@postAdd')->name('staff.course.add.post');
        Route::get('/edit/{course_id}', 'CourseController@getEdit')->name('staff.course.edit.get')->middleware('leader');
        Route::post('/edit/{course_id}', 'CourseController@postEdit')->name('staff.course.edit.post')->middleware('leader');
        Route::get('/stat', 'CourseStat@getIndex');
        Route::get('/delete/{course_id}', 'CourseController@getDelete')->name('staff.course.delete.get');
        Route::post('/delete/{course_id}', 'CourseController@postDelete')->name('staff.course.delete.post');
    });

    Route::group(['prefix' => 'coursestudents'], function ()
    {
        Route::get('/add/{client_id}', 'CourseStudentController@getAdd')->name('staff.coursestudent.add.get');
        Route::post('/add', 'CourseStudentController@postAdd')->name('staff.coursestudent.add.post');
        Route::get('/add/{client_id}/toclass/{class_id}', 'CourseStudentController@getAddnow')->name('staff.coursestudent.addnow.get');
        Route::get('/edit/{coursestudent_id}', 'CourseStudentController@getEdit')->name('staff.coursestudent.edit.get');
        Route::post('/edit', 'CourseStudentController@postEdit')->name('staff.coursestudent.edit.post');
        Route::get('/delete/{coursestudent_id}', 'CourseStudentController@getDelete')->name('staff.coursestudent.delete.get');  
    });

    Route::group(['prefix' => 'profile'], function ()
    {
        Route::get('/edit', 'ProfileController@getEdit')->name('staff.profile.edit.get');
        Route::post('/edit', 'ProfileController@postEdit')->name('staff.profile.edit.post');
    });
    
    Route::group(['prefix' => 'download'], function ()
    {
        Route::get('/', 'DownloadController@getList')->name('staff.download.list.get');
        Route::get('/add', 'DownloadController@getAdd')->name('staff.download.add.get');
        Route::post('/add', 'DownloadController@postAdd')->name('staff.download.add.post');
        Route::get('/delete/{download_id}', 'DownloadController@getDelete')->name('staff.download.delete.get')->middleware('leader');
        Route::get('/edit/{download_id}', 'DownloadController@getEdit')->name('staff.download.edit.get')->middleware('leader');
        Route::post('/edit/{download_id}', 'DownloadController@postEdit')->name('staff.download.edit.post')->middleware('leader');
    });

    Route::group(['prefix' => 'worklog'], function ()
    {
        Route::get('/', 'WorklogController@getList')->name('staff.worklog.list.get');
        Route::get('/add', 'WorklogController@getAdd')->name('staff.worklog.add.get');
        Route::post('/add', 'WorklogController@postAdd')->name('staff.worklog.add.post');
        Route::get('/edit/{worklog_id}', 'WorklogController@getEdit')->name('staff.worklog.edit.get');
        Route::post('/edit/{worklog_id}', 'WorklogController@postEdit')->name('staff.worklog.edit.post');
    });

    Route::group(['prefix' => 'shift'], function ()
    {
        Route::get('/', 'ShiftController@getView')->name('staff.shift.view.get');
        Route::get('/register', 'ShiftController@getRegister')->name('staff.shift.register.get');
        Route::post('/register', 'ShiftController@postRegister')->name('staff.shift.register.post');
        Route::post('/edit/{shift_id}', 'ShiftController@getEdit')->name('staff.shift.edit.get');
        Route::post('/edit/{shift_id}', 'ShiftController@getEdit')->name('staff.shift.edit.get');
        Route::get('/manager', 'ShiftController@getManager')->name('staff.shift.manager.get')->middleware('manager');
        Route::post('/manager', 'ShiftController@postManager')->name('staff.shift.manager.post')->middleware('manager');
    });
});