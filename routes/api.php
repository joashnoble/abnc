<?php

use Illuminate\Http\Request;

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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// }); 
Route::middleware('auth:api')->group(function () {
   //---------------------------------- REFERENCES -----------------------------------------------

   Route::post('formSubmit','Utilities\ImageUploaderController@formSubmit');

   //DASHBOARD
   Route::get('dashboard/index/{payment_type}', 'References\DashboardController@index');
   Route::get('dashboard/payment/{payment_type}/{is_string}', 'References\DashboardController@getPaymentLine');

   // List of Charges
   Route::get('accounts', 'References\AccountTitlesController@index');
   Route::get('charges', 'References\ChargesController@index');
   Route::get('charge/{id}', 'References\ChargesController@show');
   Route::post('charge', 'References\ChargesController@create');
   Route::put('charge/{id}', 'References\ChargesController@update');
   Route::put('charge/delete/{id}', 'References\ChargesController@delete');
   Route::get('chargecheck/{id}', 'References\ChargesController@checkIfUsed');

   //List billing period
   Route::get('periods', 'References\BillingPeriodController@index');
   Route::get('period/{id}', 'References\BillingPeriodController@show');
   Route::post('period', 'References\BillingPeriodController@create');
   Route::put('period/{id}', 'References\BillingPeriodController@update');
   Route::put('period/delete/{id}', 'References\BillingPeriodController@delete');
   Route::get('periodcheck/{id}', 'References\BillingPeriodController@checkIfUsed');

   //List check types
   Route::get('checktypes', 'References\CheckTypeController@index');
   Route::get('checktype/{id}', 'References\CheckTypeController@show');
   Route::post('checktype', 'References\CheckTypeController@create');
   Route::put('checktype/{id}', 'References\CheckTypeController@update');
   Route::put('checktype/delete/{id}', 'References\CheckTypeController@delete');
   Route::get('checktypecheck/{id}', 'References\CheckTypeController@checkIfUsed');

   //List categories
   Route::get('categories', 'References\CategoriesController@index');
   Route::get('category/{id}', 'References\CategoriesController@show');
   Route::post('category', 'References\CategoriesController@create');
   Route::put('category/{id}', 'References\CategoriesController@update');
   Route::put('category/delete/{id}', 'References\CategoriesController@delete');
   Route::get('categorycheck/{id}', 'References\CategoriesController@checkIfUsed');

    //List Service Select Type
   Route::get('servicesselecttype', 'References\ServiceTypeController@selecttypelist');

    // List Service Type
   Route::get('servicestype', 'References\ServiceTypeController@index');
   Route::get('servicetype/{id}', 'References\ServiceTypeController@show');
   Route::post('servicetype', 'References\ServiceTypeController@create');
   Route::put('servicetype/{id}', 'References\ServiceTypeController@update');
   Route::put('servicetype/delete/{id}', 'References\ServiceTypeController@delete');
   Route::get('servicetypecheck/{id}', 'References\ServiceTypeController@checkIfUsed');

   //List Service Group Type
   Route::get('servicesgrouptype', 'References\ServiceGroupTypeController@index');
   Route::get('servicegrouptype/{id}', 'References\ServiceGroupTypeController@show');
   Route::post('servicegrouptype', 'References\ServiceGroupTypeController@create');
   Route::put('servicegrouptype/{id}', 'References\ServiceGroupTypeController@update');
   Route::put('servicegrouptype/delete/{id}', 'References\ServiceGroupTypeController@delete');
   Route::get('servicegrouptypecheck/{id}', 'References\ServiceGroupTypeController@checkIfUsed');

    // List News Publication
    Route::get('newspublications/{status_id}', 'ContentManagement\NewsPublicationsController@index');
    Route::get('newspublication/{id}', 'ContentManagement\NewsPublicationsController@show');
    Route::post('newspublication', 'ContentManagement\NewsPublicationsController@create');
    Route::put('newspublication/{id}', 'ContentManagement\NewsPublicationsController@update');
    Route::put('newspublication/delete/{id}', 'ContentManagement\NewsPublicationsController@delete');   
    Route::put('activate/newspublication/{type}/{id}', 'ContentManagement\NewsPublicationsController@activate');
    Route::get('newspublications/archive/{type}', 'ContentManagement\NewsPublicationsController@archives'); 

    // List Seminars
    Route::get('seminars/{status_id}', 'ContentManagement\SeminarsController@index');
    Route::get('seminar/{id}', 'ContentManagement\SeminarsController@show');
    Route::post('seminar', 'ContentManagement\SeminarsController@create');
    Route::put('seminar/{id}', 'ContentManagement\SeminarsController@update');
    Route::put('seminar/delete/{id}', 'ContentManagement\SeminarsController@delete');   
    Route::put('activate/seminar/{type}/{id}', 'ContentManagement\SeminarsController@activate'); 
    
    // List CSR
    Route::get('csrs', 'ContentManagement\CSRController@index');
    Route::get('csr/{id}', 'ContentManagement\CSRController@show');
    Route::post('csr', 'ContentManagement\CSRController@create');
    Route::put('csr/{id}', 'ContentManagement\CSRController@update');
    Route::put('csr/delete/{id}', 'ContentManagement\CSRController@delete');  
    
    // List Careers
    Route::get('careers', 'ContentManagement\CareersController@index');
    Route::get('career/{id}', 'ContentManagement\CareersController@show');
    Route::post('career', 'ContentManagement\CareersController@create');
    Route::put('career/{id}', 'ContentManagement\CareersController@update');
    Route::put('career/delete/{id}', 'ContentManagement\CareersController@delete');     
    
    // List Teams
    Route::get('teams', 'ContentManagement\TeamsController@index');
    Route::get('team/{id}', 'ContentManagement\TeamsController@show');
    Route::post('team', 'ContentManagement\TeamsController@create');
    Route::put('team/{id}', 'ContentManagement\TeamsController@update');
    Route::put('team/delete/{id}', 'ContentManagement\TeamsController@delete');       
    
    // List Carousel
    Route::get('carousels', 'ContentManagement\CarouselsController@index');
    Route::get('carousel/{id}', 'ContentManagement\CarouselsController@show');
    Route::post('carousel', 'ContentManagement\CarouselsController@create');
    Route::put('carousel/{id}', 'ContentManagement\CarouselsController@update');
    Route::put('carousel/delete/{id}', 'ContentManagement\CarouselsController@delete');       

    // List Services
    Route::get('services', 'Management\ServicesController@index');
    Route::get('services/archive/{type}', 'Management\ServicesController@index');
    Route::get('service/{id}', 'Management\ServicesController@show');
    Route::post('service', 'Management\ServicesController@create');
    Route::put('service/{id}', 'Management\ServicesController@update');
    Route::put('service/delete/{id}', 'Management\ServicesController@delete'); 
    Route::get('service/items/{id}', 'Management\ServicesController@serviceitems');
    Route::get('servicecheck/{id}', 'Management\ServicesController@checkIfUsed');

    //Archive Management
    Route::put('archive/{entity}/{type}/{id}', 'Management\ArchivesController@archive'); 

    // List Client Management
    Route::get('clients', 'Management\ClientsController@index');

   //List Industries
   Route::get('industries', 'References\IndustriesController@index');
   Route::get('industry/{id}', 'References\IndustriesController@show');
   Route::post('industry', 'References\IndustriesController@create');
   Route::put('industry/{id}', 'References\IndustriesController@update');
   Route::put('industry/delete/{id}', 'References\IndustriesController@delete');
   Route::get('industrycheck/{id}', 'References\IndustriesController@checkIfUsed');

   //List departments
   Route::get('departments', 'References\DepartmentsController@index');
   Route::get('department/{id}', 'References\DepartmentsController@show');
   Route::post('department', 'References\DepartmentsController@create');
   Route::put('department/{id}', 'References\DepartmentsController@update');
   Route::put('department/delete/{id}', 'References\DepartmentsController@delete');
   Route::get('departmentcheck/{id}', 'References\DepartmentsController@checkIfUsed');

   //List locations
   Route::get('locations', 'References\LocationsController@index');
   Route::get('location/{id}', 'References\LocationsController@show');
   Route::post('location', 'References\LocationsController@create');
   Route::put('location/{id}', 'References\LocationsController@update');
   Route::put('location/delete/{id}', 'References\LocationsController@delete');
   Route::get('locationcheck/{id}', 'References\LocationsController@checkIfUsed');

   //List natures
   Route::get('natureofbusinesses', 'References\NatureOfBusinessController@index');
   Route::get('natureofbusiness/{id}', 'References\NatureOfBusinessController@show');
   Route::post('natureofbusiness', 'References\NatureOfBusinessController@create');
   Route::put('natureofbusiness/{id}', 'References\NatureOfBusinessController@update');
   Route::put('natureofbusiness/delete/{id}', 'References\NatureOfBusinessController@delete');
   Route::get('natureofbusinesscheck/{id}', 'References\NatureOfBusinessController@checkIfUsed');

   //List contract types
   Route::get('contracttypes', 'References\ContractTypesController@index');
   Route::get('contracttype/{id}', 'References\ContractTypesController@show');
   Route::post('contracttype', 'References\ContractTypesController@create');
   Route::put('contracttype/{id}', 'References\ContractTypesController@update');
   Route::put('contracttype/delete/{id}', 'References\ContractTypesController@delete');
   Route::get('contracttypecheck/{id}', 'References\ContractTypesController@checkIfUsed');

   //MONTHS
   Route::get('months', 'References\MonthsController@index');
   //END MONTHS

   //TENANT
    //List tenants
    Route::get('tenants', 'References\TenantsController@index');
    Route::get('tenant/{id}', 'References\TenantsController@show');
    Route::get('tenant_files/{id}', 'References\TenantsController@showFiles');
    Route::get('tenanthistory/{id}', 'References\TenantsController@tenantHistory');

    //Create new tenant
    Route::post('tenant', 'References\TenantsController@create');
    Route::put('tenant/{id}', 'References\TenantsController@update');
    Route::put('tenant/delete/{id}', 'References\TenantsController@delete');
    Route::get('tenantcheck/{id}', 'References\TenantsController@checkIfUsed');
     //---------------------------------- REFERENCES -----------------------------------------------

     //---------------------------------- UTILITIES ------------------------------------------------
    //USER
    //List users
    Route::get('users', 'Utilities\UsersController@index');
    //Profile
    Route::get('user/profile', 'Utilities\UsersController@Profile');
    Route::post('user/profile/update', 'Utilities\UsersController@SaveProfile');
    //List single user
    Route::get('user/{id}', 'Utilities\UsersController@show');
    //Create new user
    Route::post('user', 'Utilities\UsersController@create');
    //Update user
    Route::put('user/{id}', 'Utilities\UsersController@update');
    //Delete user
    Route::put('user/delete/{id}', 'Utilities\UsersController@delete');
    // END USER

    //List user groups
    Route::get('usergroups', 'Utilities\UserGroupsController@index');
    Route::get('group_rights/{user_group_id}', 'Utilities\UserGroupsController@getGroupRights');
    //List single user group
    Route::get('usergroup/{id}', 'Utilities\UserGroupsController@show');
    //Create new user group
    Route::post('usergroup', 'Utilities\UserGroupsController@create');
    Route::post('usergroup/rights/{id}', 'Utilities\UserGroupsController@createGroupRights');
    //Update user group
    Route::put('usergroup/{id}', 'Utilities\UserGroupsController@update');
    //Delete user group
    Route::put('usergroup/delete/{id}', 'Utilities\UserGroupsController@delete');
    //Check if user group was used
    Route::get('usergroupcheck/{id}', 'Utilities\UserGroupsController@checkIfUsed');
    Route::get('modules', 'Utilities\UserGroupsController@getModuleList');
    // END user groups

    //COMPANY
    //List company
    Route::get('companysettings', 'Utilities\CompanySettingsController@index');
    Route::post('companysetting/notes', 'Utilities\CompanySettingsController@insertNotes');
    Route::get('csdepartments', 'Utilities\CompanySettingsController@departments');
    //List single company
    Route::get('companysetting/{id}', 'Utilities\CompanySettingsController@show');
    Route::get('companysettingnotes', 'Utilities\CompanySettingsController@showNotes');
    //Create new company
    Route::post('companysetting', 'Utilities\CompanySettingsController@create');
    //Update company
    Route::put('companysetting/{id}', 'Utilities\CompanySettingsController@update');
    //Delete company
    Route::put('companysetting/delete/{id}', 'Utilities\CompanySettingsController@delete');
    // END COMPANY
     //---------------------------------- UTILITIES ------------------------------------------------

     //---------------------------------- TRANSACTIONS ---------------------------------------------
    //CONTRACT INFO
    //List contracts
    Route::get('contracts', 'Transactions\ContractsController@index');
    Route::get('feetypes/{contract_id}', 'Transactions\ContractsController@getFeeType');
    Route::post('contract_other_fees', 'Transactions\ContractsController@saveFees');
    Route::get('contractfeeshistory/{contract_id}/{fee_type_id}', 'Transactions\ContractsController@contractFeesHistory');

    Route::get('contracts/{tenant_id}', 'Transactions\ContractsController@index');
    //List Schedules and Charges
    Route::get('contracts/sc/{id}', 'Transactions\ContractsController@scheduleAndCharges');
    //List Schedules and Charges for Billing
    Route::get('contracts/{id}/{app_year}/{month_id}/{tenant_id}', 'Transactions\ContractsController@scheduleAndChargesBilling');
    //List single contract
    Route::get('contract/{id}', 'Transactions\ContractsController@show');
    //Create new contract
    Route::post('contract', 'Transactions\ContractsController@create');
    Route::post('contract_renewal/{id}', 'Transactions\ContractsController@renew');
    //Create new start billing form
    Route::post('contract/start_billing', 'Transactions\ContractsController@StartBillingForm');
    Route::get('contract/cancel_start_billing/{start_billing_id}', 'Transactions\ContractsController@CancelStartBilling');
    Route::post('contract/stop_billing', 'Transactions\ContractsController@StopBillingForm');
    Route::get('contract/cancel_stop_billing/{stop_billing_id}', 'Transactions\ContractsController@CancelStopBilling');
    Route::get('contract/billingforms/{contract_id}', 'Transactions\ContractsController@BillingForms');
    //Update contract
    Route::put('contract/{id}', 'Transactions\ContractsController@update');
    //Delete contract
    Route::put('contract/delete/{id}', 'Transactions\ContractsController@delete');
    //Preterminate contract
    Route::put('contract/preterminate/{id}', 'Transactions\ContractsController@preterminate');
    //Terminate contract
    Route::put('contract/terminate/{id}', 'Transactions\ContractsController@terminate');
    //Activate contract
    Route::put('contract/activate/{id}', 'Transactions\ContractsController@activate');
    //Check if contract was used
    Route::get('contractcheck/{id}', 'Transactions\ContractsController@checkIfUsed');
    // END CONTRACT

    //List Billings
    Route::get('billings', 'Transactions\BillingsController@index');
    Route::get('billings/{period_id}/{department_id}', 'Transactions\BillingsController@index');
    //schedule and charges of billing
    Route::get('billingSC/sc/{id}', 'Transactions\BillingsController@scheduleAndCharges');
    
    Route::get('billing/balance/{tenant_id}', 'Transactions\BillingsController@getBillingBalance');
    //List single billing
    Route::get('billing/{id}', 'Transactions\BillingsController@show');
    Route::get('billing/{id}/{soa}', 'Transactions\BillingsController@show');
    Route::get('billing/{month_id}/{app_year}/{tenant_id}/{department_id}', 'Transactions\BillingsController@prevBalance');
    Route::get('billing/sub_total/{month_id}/{app_year}/{tenant_id}', 'Transactions\BillingsController@prevSubTotal');
    Route::get('billing/as_of/{month_id}/{app_year}/{tenant_id}', 'Transactions\BillingsController@asOfBalance');
    //Create new contract
    Route::post('billing', 'Transactions\BillingsController@create');
    Route::get('batchbilling/{period_id}', 'Transactions\BillingsController@BatchCreate');
    //Update billing
    Route::put('billing/{id}', 'Transactions\BillingsController@update');
    //Delete billing
    Route::put('billing/delete/{id}', 'Transactions\BillingsController@delete');
    //Check if billing was used
    Route::get('billingcheck/{id}', 'Transactions\BillingsController@checkIfUsed');
    // END billing

    //PAYMENTS
    //List payments
    Route::get('payments', 'Transactions\PaymentsController@index');
    Route::get('payments/{date_from}/{date_to}', 'Transactions\PaymentsController@index');

    Route::get('payments/{tenant_id}/{month_id}/{app_year}', 'Transactions\PaymentsController@getPayments');
    Route::get('payment/interest/{tenant_id}/{month_id}/{app_year}', 'Transactions\PaymentsController@getPaymentsForInterest');
    //List single payment
    Route::get('payment/{id}', 'Transactions\PaymentsController@show');
    Route::get('payment/words/{amount}', 'Transactions\PaymentsController@convertDecimalToWords');
    Route::get('payment/{month_id}/{app_year}/{tenant_id}/{department_id}', 'Transactions\PaymentsController@latePayment');
    Route::get('payment/advance/{tenant_id}', 'Transactions\PaymentsController@getAdvance');
    Route::get('payment/words/{amount}', 'Transactions\PaymentsController@convertDecimalToWords');
    //Create new payment
    Route::post('payment', 'Transactions\PaymentsController@create');
    //Update payment
    Route::put('payment/{id}', 'Transactions\PaymentsController@update');
    //Delete payment
    Route::put('payment/delete/{id}', 'Transactions\PaymentsController@delete');
    //Check if payment was used
    Route::get('paymentcheck/{id}', 'Transactions\PaymentsController@checkIfUsed');
    // END PAYMENTS

    //ADJUSTMENTS
    //List adjustments
    Route::get('adjustments', 'Transactions\AdjustmentsController@index');
    Route::get('adjustments/{period_id}', 'Transactions\AdjustmentsController@index');
    Route::get('adjustments/{tenant_id}/{period_id}', 'Transactions\AdjustmentsController@ApprovedAdjustments');
    Route::get('adjustments/{tenant_id}/{month_id}/{app_year}', 'Transactions\AdjustmentsController@getAdjustments');

    //List single adjustment
    Route::get('adjustment/{id}', 'Transactions\AdjustmentsController@show');
    Route::get('adjustment/{tenant_id}/{month_id}/{app_year}', 'Transactions\AdjustmentsController@getTotalAdjustment');

    //Create new adjustment
    Route::post('adjustment', 'Transactions\AdjustmentsController@create');
    //Update adjustment
    Route::put('adjustment/{id}', 'Transactions\AdjustmentsController@update');
    //Delete adjustment
    Route::put('adjustment/delete/{id}', 'Transactions\AdjustmentsController@delete');
    //Check if adjustment was used
    Route::get('adjustmentcheck/{id}', 'Transactions\AdjustmentsController@checkIfUsed');
    // END ADJUSTMENTS

    //CHARGE SLIPS
    //List charge slips
    Route::get('chargeslips', 'Transactions\ChargeSlipsController@index');
    Route::get('chargeslips/{app_year}/{month_id}', 'Transactions\ChargeSlipsController@index');
    //List single charge slip
    Route::get('chargeslip/{id}', 'Transactions\ChargeSlipsController@show');
    //Create new charge slip
    Route::post('chargeslip', 'Transactions\ChargeSlipsController@create');
    //Update charge slip
    Route::put('chargeslip/{id}', 'Transactions\ChargeSlipsController@update');
    //Approve charge slip
    Route::get('chargeslip/approval/{id}', 'Transactions\ChargeSlipsController@approval');
    //Disapprove charge slip
    Route::get('chargeslip/disapproval/{id}', 'Transactions\ChargeSlipsController@disapproval');
    //Delete charge slip
    Route::put('chargeslip/delete/{id}', 'Transactions\ChargeSlipsController@delete');
    //Check if charge slip was used
    Route::get('chargeslipcheck/{id}', 'Transactions\ChargeSlipsController@checkIfUsed');
    // END CHARGE SLIPS
    

    //---------------------------------- TRANSACTIONS ---------------------------------------------

    

    //---------------------------------- REPORTS --------------------------------------------------

    //---------------------------------- Accounting --------------------------------------------------
    Route::get('arbilling/getsentbilling/{id}', 'Accounting\ArBillingController@getSentBilling');
    Route::get('arbilling/getjournalinfo/{id}', 'Accounting\ArBillingController@getJournalInfo');
    Route::post('arbilling/insertjournalinfo', 'Accounting\ArBillingController@insertJournalInfo');

    Route::get('arpayment/getsentpayment/{start_date}/{end_date}', 'Accounting\ArPaymentController@getSentPayment');
    Route::get('arpayment/getjournalinfo/{start_date}/{end_date}', 'Accounting\ArPaymentController@getJournalInfo');
    Route::post('arpayment/insertjournalinfo', 'Accounting\ArPaymentController@insertJournalInfo');
    //---------------------------------- Accounting --------------------------------------------------

    //---------------------------------- SESSIONS -------------------------------------------------
    Route::get('session/rights', 'SessionController@getRights');
    //---------------------------------- FILE UPLOAD ----------------------------------------------
    Route::post('upload', function(Request $request){
        if ($request->file->isValid()) {
            $uploadedFile = $request->file;
            $uploadedPath = $request->path;

            $uploadedFile->move($uploadedPath, 'logo');
            $path = $uploadedPath.'/logo';
            return response(['status'=>'success', 'path'=>$path], 200);
        }
    });

    Route::post('user/upload', function(Request $request){
        if ($request->file->isValid()) {
            $uploadedFile = $request->file;
            $uploadedPath = $request->path;

            $uploadedFile->move($uploadedPath, $request->id);
            $path = $uploadedPath.'/logo';
            return response(['status'=>'success', 'path'=>$path], 200);
        }
    });
    
    Route::post('gallery/upload', function(Request $request){
        if ($request->file->isValid()) {
            $uploadedFile = $request->file;
            $uploadedPath = $request->path;

            $imageName = time().'.'.$request->file->getClientOriginalExtension();

            $uploadedFile->move($uploadedPath, $imageName);
            $path = $uploadedPath.'/'.$imageName;

            return response(['status'=>'success', 'path'=>$path], 200);
        }
    });

    Route::post('fileupload', 'References\TenantsController@fileupload');
    Route::post('filedelete', 'References\TenantsController@filedelete');
});

//---------------------------------- REPORTS --------------------------------------------------
Route::get('reports/soa/{id}', 'Reports\ReportsController@PreviewSoa');
Route::get('reports/allsoa/{id}', 'Reports\ReportsController@PreviewAllSoa');
Route::get('reports/ackreceipt/{id}/{user_id}', 'Reports\ReportsController@PreviewAckReceipt');
Route::get('reports/tenantspersqmrate/{id}', 'Reports\ReportsController@tenantsPerSquareMeter');
Route::get('reports/tenantsmasterlist', 'Reports\ReportsController@tenantsMasterList');
Route::get('reports/contractsmasterlist/{id}/{type}', 'Reports\ReportsController@contractsMasterList');
Route::get('reports/billingforecast/{period_id}/{department_id}', 'Reports\ReportsController@BillingForecast');
Route::get('reports/rentalandcharges/{location_id}/{app_year}/{app_month}/{charge_type}',[
    'as' => 'reports.rentalAndCharges', 
    'uses' => 'Reports\ReportsController@rentalAndCharges'
 ]);
Route::get('reports/expiringcontracts', 'Reports\ReportsController@expiringContractsList');
Route::get('reports/newcontracts', 'Reports\ReportsController@newContractsList');
Route::get('reports/chargeslip/{charge_slip_id}', 'Reports\ReportsController@ChargeSlip');
Route::get('reports/contractproposal/{contract_id}', 'Reports\ReportsController@ContractProposal');
Route::get('reports/collectionreport/{date_from}/{date_to}/{department_id}/{type}', 'Reports\ReportsController@CollectionReport');
Route::get('reports/startbillingform/{start_billing_id}', 'Reports\ReportsController@StartBillingForm');
Route::get('reports/stopbillingform/{stop_billing_id}', 'Reports\ReportsController@StopBillingForm');
Route::get('reports/email', 'Reports\ReportsController@sendEmail');