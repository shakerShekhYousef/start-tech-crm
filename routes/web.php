<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('progressbar', [HomeController::class, 'getProgressB'])->name('get-progressbar');
route::get('clearprogressbar', [HomeController::class , 'clearProgressBar'])->name('clear-progressbar');
route::get('getImportStatus', [HomeController::class , 'getImportStatus'])->name('get-importstatus');
route::get('finishImportStatus', [HomeController::class , 'finishImportStatus'])->name('finish-importstatus');
route::get('startImportStatus', [HomeController::class , 'startImportStatus'])->name('start-importstatus');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/agentdata', [App\Http\Controllers\HomeController::class, 'agentdata'])->name('agent_data');
Route::post('/filter', [App\Http\Controllers\HomeController::class, 'filter'])->name('filter');
Route::get('/uploadedFile', [App\Http\Controllers\HomeController::class, 'uploadedFiles'])->name('uploadedFiles');
Route::get('/downloadFile/{fileName}', [App\Http\Controllers\HomeController::class, 'downloadFile']);
Route::get('emirates', [App\Http\Controllers\HomeController::class, 'sample'])->name('sample');
Route::get('nationality', [App\Http\Controllers\HomeController::class, 'nationality'])->name('nationality');
Route::get('usage', [App\Http\Controllers\HomeController::class, 'usage'])->name('usage');
Route::post('deleteFile/{id}', [App\Http\Controllers\ImportExcelController::class, 'deleteFile'])->name('deleteFile');
Route::get('geochart', [App\Http\Controllers\HomeController::class, 'getLavaChart'])->name('geochart');

Route::get('filterIng/{emirates}&{area}&{residence}', [App\Http\Controllers\HomeController::class, 'filterIng']);


Route::get('/register', function () {
    return view('auth.login');
});

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::post('allposts', [App\Http\Controllers\HomeController::class, 'search'])->name('allposts');
Route::post('allposts1', [App\Http\Controllers\HomeController::class, 'search1'])->name('allposts1');
Route::post('allposts2', [App\Http\Controllers\HomeController::class, 'search2'])->name('allposts2');
Route::post('serachforagentdata', [App\Http\Controllers\HomeController::class, 'serachforagentdata'])->name('serach_for_agent_data');
Route::post('addcomment', [App\Http\Controllers\HomeController::class, 'addcomment'])->name('add_comment');
Route::post('deletecomment', [App\Http\Controllers\HomeController::class, 'deletecomment'])->name('delete_comment');
Route::get('index1', [App\Http\Controllers\HomeController::class, 'index1'])->name('index1');
Route::get('showcommenteddata', [App\Http\Controllers\HomeController::class, 'showcommenteddata'])->name('show_commented_data');
Route::post('getcommenteduserdata', [App\Http\Controllers\HomeController::class, 'getcommenteduserdata'])->name('get_commented_user_data');
Route::post('addleadcomment', [App\Http\Controllers\HomeController::class, 'addleadcomment'])->name('add_lead_comment');


// Excel Routes
Route::get('/export_excel', [App\Http\Controllers\ExportExcelController::class, 'index']);
Route::post('/export_excel/excel', [App\Http\Controllers\ExportExcelController::class, 'excel'])->name('export_excel.excel');

Route::get('map', [App\Http\Controllers\HomeController::class, 'map'])->name('map');

Route::get('import', [App\Http\Controllers\ImportExcelController::class, 'index'])->name('import_index');

route::get('createuserindex',[App\Http\Controllers\HomeController::class, 'createuserindex'])->name('create_user_index');
route::post('createnewuser',[App\Http\Controllers\HomeController::class, 'createnewuser'])->name('create_new_user');
route::get('updateuserindex/{id?}',[App\Http\Controllers\HomeController::class, 'updateuserindex'])->name('update_user_index');
route::post('updateuser',[App\Http\Controllers\HomeController::class, 'updateuser'])->name('update_user');

route::post('createnewproperty',[App\Http\Controllers\HomeController::class, 'createnewproperty'])->name('create_new_property');

route::get('createcustomerindex',[App\Http\Controllers\HomeController::class, 'createcustomerindex'])->name('create_customer_index');
route::post('createnewcustomer',[App\Http\Controllers\HomeController::class, 'createnewcustomer'])->name('create_new_customer');
route::get('updatecustomerindex/{id?}',[App\Http\Controllers\HomeController::class, 'updatecustomerindex'])->name('update_customer_index');
route::post('updatecustomer',[App\Http\Controllers\HomeController::class, 'updatecustomer'])->name('update_customer');
route::post('deletecustomer',[App\Http\Controllers\HomeController::class, 'deletecustomer'])->name('delete_customer');

route::get('createpaymentindex',[App\Http\Controllers\HomeController::class, 'createpaymentindex'])->name('create_payment_index');
route::post('createnewpayment',[App\Http\Controllers\HomeController::class, 'createnewpayment'])->name('create_new_payment');

route::post('assignagenttolandpage',[App\Http\Controllers\HomeController::class, 'assignagenttolandpage'])->name('assign_agent_to_landpage');
route::post('listassignedlandingagent',[App\Http\Controllers\HomeController::class, 'listassignedlandingagent'])->name('list_assigned_landing_agent');

route::get('assignagentforlanding',[App\Http\Controllers\HomeController::class, 'assignagentforlanding'])->name('assign_agent_for_landing');
route::post('deletelanding',[App\Http\Controllers\HomeController::class, 'deletelanding'])->name('delete_landing');

route::get('listpaymentsindex',[App\Http\Controllers\HomeController::class, 'listpaymentsindex'])->name('list_payments_index');
route::post('listpayments',[App\Http\Controllers\HomeController::class, 'listpayments'])->name('list_payments');
route::post('deletepayment',[App\Http\Controllers\HomeController::class, 'deletepayment'])->name('delete_payment');

route::get('listusersindex',[App\Http\Controllers\HomeController::class, 'listusersindex'])->name('list_users_index');
route::post('listusers',[App\Http\Controllers\HomeController::class, 'listusers'])->name('list_users');
route::post('deleteuser',[App\Http\Controllers\HomeController::class, 'deleteuser'])->name('delete_user');

route::get('listpropertiesindex',[App\Http\Controllers\HomeController::class, 'listpropertiesindex'])->name('list_properties_index');
route::post('listproperties',[App\Http\Controllers\HomeController::class, 'listproperties'])->name('list_properties');
route::post('deleteproperty',[App\Http\Controllers\HomeController::class, 'deleteproperty'])->name('delete_property');

route::get('createpropertyindex',[App\Http\Controllers\HomeController::class, 'createpropertyindex'])->name('create_property_index');
route::post('getassigneduserdatainfo',[App\Http\Controllers\HomeController::class, 'getassigneduserdatainfo'])->name('get_assigned_user_data_info');
route::post('getusercommentedinfo',[App\Http\Controllers\HomeController::class, 'getusercommentedinfo'])->name('get_user_commented_info');

route::post('getcustomerpaymentsinfo',[App\Http\Controllers\HomeController::class, 'getcustomerpaymentsinfo'])->name('get_customer_payments_info');
route::post('getcustomerpropertiesinfo',[App\Http\Controllers\HomeController::class, 'getcustomerpropertiesinfo'])->name('get_customer_properties_info');

route::get('getassigneddataindex',[App\Http\Controllers\HomeController::class, 'getassigneddataindex'])->name('get_assigned_data_index');
route::post('getassignedagentdata',[App\Http\Controllers\HomeController::class, 'getassignedagentdata'])->name('get_assigned_agent_data');
route::post('assignagentdata',[App\Http\Controllers\HomeController::class, 'assignagentdata'])->name('assign_agent_data');
route::get('assignagentdataindex',[App\Http\Controllers\HomeController::class, 'assignagentdataindex'])->name('assign_agent_data_index');
route::get('showbooksindex',[App\Http\Controllers\HomeController::class, 'showbooksindex'])->name('showbooksindex');
route::post('showbooks',[App\Http\Controllers\HomeController::class, 'showbooks'])->name('showbooks');
route::get('showbookviews',[App\Http\Controllers\HomeController::class, 'showbookviews'])->name('show_book_views');
route::get('showbookviewsindex',[App\Http\Controllers\HomeController::class, 'showbookviewsindex'])->name('show_book_views_index');

route::post('importenquirycustomer',[App\Http\Controllers\HomeController::class, 'importenquirycustomer'])->name('import_enquiry_customer');

route::get('charts',[ChartController::class, 'index'])->name('getcharts');

route::get('leaderboardindex',[HomeController::class, 'leaderboardindex'])->name('leader_board_index');
route::post('getleaderboard',[HomeController::class, 'getleaderboard'])->name('get_leader_board');

Route::post('import', [App\Http\Controllers\ImportExcelController::class, 'import'])->name('importprocessajax');


// qualified data
route::get('qualifiedleadsindex',[App\Http\Controllers\QualifiedLeadsController::class, 'qualifiedleadsindex'])->name('qualified_leads_index');
route::post('qualifiedleads',[App\Http\Controllers\QualifiedLeadsController::class, 'qualifiedleads'])->name('qualified_leads');
route::get('assignagentqualifieddataindex',[App\Http\Controllers\QualifiedLeadsController::class, 'assignagentqualifieddataindex'])->name('assign_agent_qualified_data_index');
route::post('assignagentqualifieddata',[App\Http\Controllers\QualifiedLeadsController::class, 'assignagentqualifieddata'])->name('assign_agent_qualified_data');
route::post('searchforagentqualifieddata',[App\Http\Controllers\QualifiedLeadsController::class, 'searchforagentqualifieddata'])->name('search_for_agent_qualified_data');
route::get('qualifieduserhomeindex',[App\Http\Controllers\QualifiedLeadsController::class, 'qualifieduserhomeindex'])->name('qualified_user_home_index');
Route::post('qualifieduserhomedata', [App\Http\Controllers\QualifiedLeadsController::class, 'qualifieduserhomedata'])->name('qualified_user_home_data');
Route::post('addqualifiedcomment', [App\Http\Controllers\QualifiedLeadsController::class, 'addqualifiedcomment'])->name('add_qualified_comment');
Route::get('showqualifieddatacommentsindex', [App\Http\Controllers\QualifiedLeadsController::class, 'showqualifieddatacommentsindex'])->name('show_qualified_data_comments_index');
Route::post('showqualifieddatacomments', [App\Http\Controllers\QualifiedLeadsController::class, 'showqualifieddatacomments'])->name('show_qualified_data_comments');
route::post('getqualifieddatacommentsinfo',[App\Http\Controllers\QualifiedLeadsController::class, 'getqualifieddatacommentsinfo'])->name('get_qualified_data_comments_info');
route::get('showuserqualifieddatacommentsindex',[App\Http\Controllers\QualifiedLeadsController::class, 'showuserqualifieddatacommentsindex'])->name('show_user_qualified_data_comments_index');
route::get('showassignedagentqualifiedindex',[App\Http\Controllers\QualifiedLeadsController::class, 'showassignedagentqualifiedindex'])->name('show_assigned_agent_qualified_index');
route::post('showassignedagentqualifieddata',[App\Http\Controllers\QualifiedLeadsController::class, 'showassignedagentqualifieddata'])->name('show_assigned_agent_qualified_data');

// leads pool
route::get('leadspoolindex',[App\Http\Controllers\LeadsPoolController::class, 'leadspoolindex'])->name('leads_pool_index');
route::post('leadspool',[App\Http\Controllers\LeadsPoolController::class, 'leadspool'])->name('leads_pool');
route::get('assignagentleadspoolindex',[App\Http\Controllers\LeadsPoolController::class, 'assignagentleadspoolindex'])->name('assign_agent_leads_pool_index');
route::post('assignagentleadspooldata',[App\Http\Controllers\LeadsPoolController::class, 'assignagentleadspooldata'])->name('assign_agent_leads_pool_data');
route::post('searchforagentleadspooldata',[App\Http\Controllers\LeadsPoolController::class, 'searchforagentleadspooldata'])->name('search_for_agent_leads_pool_data');
route::get('leadspooluserhomeindex',[App\Http\Controllers\LeadsPoolController::class, 'leadspooluserhomeindex'])->name('leads_pool_user_home_index');
Route::post('leadspooluserhomedata', [App\Http\Controllers\LeadsPoolController::class, 'leadspooluserhomedata'])->name('leads_pool_user_home_data');
Route::post('addleadspoolcomment', [App\Http\Controllers\LeadsPoolController::class, 'addleadspoolcomment'])->name('add_leads_pool_comment');
Route::get('showleadspooldatacommentsindex', [App\Http\Controllers\LeadsPoolController::class, 'showleadspooldatacommentsindex'])->name('show_leads_pool_data_comments_index');
Route::post('showleadspooldatacomments', [App\Http\Controllers\LeadsPoolController::class, 'showleadspooldatacomments'])->name('show_leads_pool_data_comments');
route::post('getleadspooldatacommentsinfo',[App\Http\Controllers\LeadsPoolController::class, 'getleadspooldatacommentsinfo'])->name('get_leads_pool_data_comments_info');
route::get('showuserleadspooldatacommentsindex',[App\Http\Controllers\LeadsPoolController::class, 'showuserleadspooldatacommentsindex'])->name('show_user_leads_pool_data_comments_index');
route::get('showassignedagentleadspoolindex',[App\Http\Controllers\LeadsPoolController::class, 'showassignedagentleadspoolindex'])->name('show_assigned_agent_leads_pool_index');
route::post('showassignedagentleadspooldata',[App\Http\Controllers\LeadsPoolController::class, 'showassignedagentleadspooldata'])->name('show_assigned_agent_leads_pool_data');

// follow up leads
route::get('followupindex',[App\Http\Controllers\FollowUpController::class, 'followupindex'])->name('follow_up_index');
route::post('followup',[App\Http\Controllers\FollowUpController::class, 'followup'])->name('follow_up');
route::get('assignagentfollowupindex',[App\Http\Controllers\FollowUpController::class, 'assignagentfollowupindex'])->name('assign_agent_follow_up_index');
route::post('assignagentfollowupdata',[App\Http\Controllers\FollowUpController::class, 'assignagentfollowupdata'])->name('assign_agent_follow_up_data');
route::post('searchforagentfollowupdata',[App\Http\Controllers\FollowUpController::class, 'searchforagentfollowupdata'])->name('search_for_agent_follow_up_data');
route::get('followupuserhomeindex',[App\Http\Controllers\FollowUpController::class, 'followupuserhomeindex'])->name('follow_up_user_home_index');
Route::post('followupuserhomedata', [App\Http\Controllers\FollowUpController::class, 'followupuserhomedata'])->name('follow_up_user_home_data');
Route::post('addfollowupcomment', [App\Http\Controllers\FollowUpController::class, 'addfollowupcomment'])->name('add_follow_up_comment');
Route::get('showfollowupdatacommentsindex', [App\Http\Controllers\FollowUpController::class, 'showfollowupdatacommentsindex'])->name('show_follow_up_data_comments_index');
Route::post('showfollowupdatacomments', [App\Http\Controllers\FollowUpController::class, 'showfollowupdatacomments'])->name('show_follow_up_data_comments');
route::post('getfollowupdatacommentsinfo',[App\Http\Controllers\FollowUpController::class, 'getfollowupdatacommentsinfo'])->name('get_follow_up_data_comments_info');
route::get('showuserfollowupdatacommentsindex',[App\Http\Controllers\FollowUpController::class, 'showuserfollowupdatacommentsindex'])->name('show_user_follow_up_data_comments_index');
route::get('showassignedagentfollowupindex',[App\Http\Controllers\FollowUpController::class, 'showassignedagentfollowupindex'])->name('show_assigned_agent_follow_up_index');
route::post('showassignedagentfollowupdata',[App\Http\Controllers\FollowUpController::class, 'showassignedagentfollowupdata'])->name('show_assigned_agent_follow_up_data');


route::get('wonleadsindex',[App\Http\Controllers\HomeController::class, 'wonleadsindex'])->name('won_leads_index');
route::post('wonleadsdata',[App\Http\Controllers\HomeController::class, 'wonleadsdata'])->name('won_leads_data');

route::get('deadleadsindex',[App\Http\Controllers\HomeController::class, 'deadleadsindex'])->name('dead_leads_index');
route::post('deadleadsdata',[App\Http\Controllers\HomeController::class, 'deadleadsdata'])->name('dead_leads_data');

route::get('createinventoryindex',[App\Http\Controllers\HomeController::class, 'createinventoryindex'])->name('create_inventory_index');
route::post('createnewinventory',[App\Http\Controllers\HomeController::class, 'createnewinventory'])->name('create_new_inventory');
route::post('importinventory',[App\Http\Controllers\HomeController::class, 'importinventory'])->name('import_inventory');
route::get('getinventoriesindex',[App\Http\Controllers\HomeController::class, 'getinventoriesindex'])->name('get_inventories_index');
Route::post('getinventories', [App\Http\Controllers\HomeController::class, 'getinventories'])->name('get_inventories');
Route::post('deleteinventory', [App\Http\Controllers\HomeController::class, 'deleteinventory'])->name('delete_inventory');
