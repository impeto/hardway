<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
//Login and Logout Starts
Route::get('/', 'HomeController@signIn');
Route::get('login', 'HomeController@signIn');
Route::post('login/login-process', 'HomeController@signIn');
Route::get('logout', 'HomeController@signOut');
Route::get('forms', 'HomeController@forms');
Route::get('forgot_password', 'HomeController@forgotPassword');
Route::post('forgot_password', 'HomeController@forgotPassword');
Route::post('check_username', 'HomeController@checkUsername');
//Login and Logout Ends
//Proxy Settings Starts
Route::get('developer/proxy-settings', 'HomeController@proxySettings');
Route::post('developer/proxy-settings', 'HomeController@proxySettings');
Route::post('developer/proxy-settings/get-users/{id}', 'HomeController@getUsers');
//Proxy Settings Ends
//Account start
Route::get('developer/add-account-register', 'DeveloperController@addCompanyProfile');
Route::post('developer/add-account-register', 'DeveloperController@addCompanyProfile');
Route::get('developer/edit-account-register/{id}', 'DeveloperController@editCompanyProfile');
Route::post('developer/edit-account-register/{id}', 'DeveloperController@editCompanyProfile');
//Route::post('company/edit-account-register/{id}','DeveloperController@editCompanyProfile');
Route::get('developer/delete-account-register/{id}', 'DeveloperController@deleteCompanyProfile');
Route::post('developer/check_company_name', 'DeveloperController@checkCompanyname');
Route::post('developer/check_username', 'DeveloperController@checkUsername');
Route::post('developer/edit_check_username/{id}', 'DeveloperController@checkEditUsername');
Route::post('developer/edit_check_emp_username/{id}', 'DeveloperController@checkEditEmpUname');
Route::get('developer/edit-account-company/{id}', 'DeveloperController@editCompany');
Route::post('developer/edit-account-company/{id}', 'DeveloperController@editCompany');
Route::post('developer/edit_check_company_name/{id}', 'DeveloperController@checkEditCompanyname');

//Account close
//Company DB conf Starts
//Route::get('company/company-listing','DeveloperController@companyListing');
Route::get('developer/company-listing', 'DeveloperController@developerListing');
Route::get('developer/add-company-db-config', 'DeveloperController@addCompanyDB');
Route::post('developer/add-company-db-config', 'DeveloperController@addCompanyDB');
Route::get('developer/company-db-config-listing', 'DeveloperController@companyDbListing');
Route::get('developer/edit-company-db-config/{id}', 'DeveloperController@editCompanyDb');
Route::post('developer/edit-company-db-config/{id}', 'DeveloperController@editCompanyDb');
Route::get('developer/view-company-db-config/{id}', 'DeveloperController@viewCompanyDbUsers');
Route::get('developer/delete-com-db-config/{id}', 'DeveloperController@deleteCompanyDB');
Route::get('developer/add-remote-company-db-config/{id}', 'DeveloperController@addReomteCompanyDB');
Route::post('developer/add-remote-company-db-config/{id}', 'DeveloperController@addReomteCompanyDB');
Route::get('developer/edit-remote-company-db-config/{id}', 'DeveloperController@editRemoteCompanyDb');
Route::post('developer/edit-remote-company-db-config/{id}', 'DeveloperController@editRemoteCompanyDb');

Route::get('developer/cpf-option', 'CpfConfigController@cpfoption');
Route::get('cpf-option/add','CpfConfigController@cpfoptionadd');
Route::post('cpf-option/add','CpfConfigController@cpfoptionstore');
Route::get('cpf-option/edit/{id}', 'CpfConfigController@cpfoptionedit');
Route::post('cpf-option/edit/{id}', 'CpfConfigController@cpfoptionupdate');
Route::get('cpf-option/delete/{id}', 'CpfConfigController@cpfoptiondelete');

Route::get('developer/cpf-rate', 'CpfConfigController@cpfrate');
Route::get('cpf-rate/add', 'CpfConfigController@cpfrateadd');
Route::post('cpf-rate/store-rate', 'CpfConfigController@cpfratestore');
Route::post('cpf-rate/update-rate/{id}', 'CpfConfigController@cpfrateupdate');

//User Activity List
Route::get('config/active', 'ConfigSettingsController@active');
Route::get('config/chart', 'ConfigSettingsController@chart');

// Test url

Route::get('chart', 'ChartController@fixChart');



Route::get('config/cpf-configuration', 'CpfConfigController@cpfConfig');
Route::post('config/cpf-configuration', 'CpfConfigController@cpfConfig');
//Company DB conf Ends
//Employee Starts
Route::get('employee/add-employee/', 'EmployeeController@addEmployee');
Route::post('employee/add-employee/', 'EmployeeController@addEmployee');
Route::get('employee/edit-employee/{id}', 'EmployeeController@editEmployee');
Route::post('employee/edit-employee/{id}', 'EmployeeController@editEmployee');
Route::get('employee/view-employee/{id}', 'EmployeeController@viewEmployee');
Route::get('employee/delete-employee/{id}', 'EmployeeController@deleteEmployee');
Route::get('employee/employee-listing/', 'EmployeeController@employeeListing');
Route::post('employee/adjust_balance', 'EmployeeController@calculateAdjustBalance');
Route::get('approve-process', 'ApproveProcessController@index');
Route::post('approve-process', 'ApproveProcessController@index');
Route::get('employee/add-job-info/{id}', 'EmployeeController@addJobInfo');
Route::post('employee/add-job-info/{id}', 'EmployeeController@addJobInfo');
Route::get('employee/edit-job-info/{id}/{jid}', 'EmployeeController@editJobInfo');
Route::post('employee/edit-job-info/{id}/{jid}', 'EmployeeController@editJobInfo');
Route::get('employee/delete-job-info/{id}/{jid}', 'EmployeeController@deleteJobInfo');



Route::get('employee/view-employee-notes/', 'EmployeeController@employeeNotes');
Route::post('employee/view-employee-notes/', 'EmployeeController@employeeNotes');
Route::get('employee/add-emergency-contact/','EmployeeController@emergencyContact');
Route::post('employee/add-emergency-contact/','EmployeeController@emergencyContact');
Route::get('employee/edit-emergency-contact/{id}', 'EmployeeController@editEmergencyContact');
Route::post('employee/edit-emergency-contact/{id}', 'EmployeeController@editEmergencyContact');
Route::get('employee/delete-text/{id}/{jid}', 'EmployeeController@deleteText');
Route::get('employee/delete-contact/{id}/{jid}','EmployeeController@deleteContact');
Route::post('employee/edit-employee-notes/{id}', 'EmployeeController@employeeEditNotes');
Route::get('employee/edit-employee-notes/{id}', 'EmployeeController@employeeEditNotes');
Route::get('employee/training-details/{id}','EmployeeController@employeeTrainingDetails');


Route::get('employee/view-employee/category', 'EmployeeController@addNewCategory');
Route::post('employee/view-employee/category', 'EmployeeController@addNewCategory');

Route::get('employee/view-employee/task/{id}', 'EmployeeController@addNewTask');
Route::post('employee/view-employee/task/{id}', 'EmployeeController@addNewTask');

Route::get('employee/view-employee/category-deletion/{id}', 'EmployeeController@deleteCategory');
Route::get('employee/view-employee/edit-category/{id}','EmployeeController@editCategory');             

Route::get('employee/add-new-task/{id}','EmployeeController@addNewTask');
Route::post('employee/add-new-task/{id}','EmployeeController@addNewTask');
Route::get('employee/edit-task/{id}/{jid}','EmployeeController@editTask');
Route::post('employee/edit-task/{id}/{jid}','EmployeeController@editTask');
Route::get('employee/delete-task/{id}/{jid}','EmployeeController@deleteTask');

Route::get('employee/off-add-new-task/{id}','EmployeeController@offAddNewTask');
Route::post('employee/off-add-new-task/{id}','EmployeeController@offAddNewTask');
Route::get('employee/off-list-category/{id}','EmployeeController@offListCategory');
Route::get('employee/off-edit-category/{id}/{jid}','EmployeeController@offEditCategory');
Route::post('employee/off-edit-category/{id}/{jid}','EmployeeController@offEditCategory');
Route::get('employee/off-delete-category/{id}/{jid}','EmployeeController@offDeleteCategory');
Route::get('employee/off-add-new-category/{id}','EmployeeController@offAddNewCategory');
Route::post('employee/off-add-new-category/{id}','EmployeeController@offAddNewCategory');
Route::get('employee/off-edit-task/{id}/{jid}','EmployeeController@offEditTask');
Route::post('employee/off-edit-task/{id}/{jid}','EmployeeController@offEditTask');
Route::get('employee/off-delete-task/{id}/{jid}','EmployeeController@offDeleteTask');

Route::get('employee/add-new-category/{id}','EmployeeController@addNewCategory');
Route::post('employee/add-new-category/{id}','EmployeeController@addNewCategory');
Route::get('employee/list-category/{id}','EmployeeController@listCategory');
Route::get('employee/edit-category/{id}/{jid}','EmployeeController@editCategory');
Route::post('employee/edit-category/{id}/{jid}','EmployeeController@editCategory');
Route::get('employee/delete-category/{id}/{jid}','EmployeeController@deleteCategory');





Route::get('employee/benefit-assign/{id}','EmployeeController@assignBenefits');

Route::get('employee/add-job-status/{id}', 'EmployeeController@addJobStatus');
Route::post('employee/add-job-status/{id}', 'EmployeeController@addJobStatus');
Route::get('employee/edit-job-status/{id}/{jid}', 'EmployeeController@editJobStatus');
Route::post('employee/edit-job-status/{id}/{jid}', 'EmployeeController@editJobStatus');
Route::get('employee/delete-job-status/{id}/{jid}', 'EmployeeController@deleteJobStatus');

Route::get('employee/add-compensation/{id}', 'EmployeeController@addCompensation');
Route::post('employee/add-compensation/{id}', 'EmployeeController@addCompensation');
Route::get('employee/edit-compensation/{id}/{jid}', 'EmployeeController@editCompensation');
Route::post('employee/edit-compensation/{id}/{jid}', 'EmployeeController@editCompensation');
Route::get('employee/delete-compensation/{id}/{jid}', 'EmployeeController@deleteCompensation');

Route::get('employee/editCompenpayitem/{id}/{jid}/{pay_id}', 'EmployeeController@editCompenpayitem');
Route::post('employee/editCompenpayitem/{id}/{jid}/{pay_id}', 'EmployeeController@editCompenpayitem');


Route::get('employee/importemployee/', 'EmployeeController@import');
Route::post('employee/importemployee', 'EmployeeController@importfile');
Route::get('employee/download/', 'EmployeeController@download');

Route::get('employee/editCompenpolicy/{emp_id}/{compen_id}/{id}', 'EmployeeController@editCompenpolicy');
Route::post('employee/editCompenpolicy/{emp_id}/{compen_id}/{id}', 'EmployeeController@editCompenpolicy');

Route::get('employee/viewCompenpolicy/{id}', 'EmployeeController@viewCompenpolicy');
Route::post('employee/viewCompenpolicy/{id}', 'EmployeeController@viewCompenpolicy');

Route::get('employee/job/check/{string}/{date}/{empid}', 'EmployeeController@checkDate');
Route::get('employee/job/edit-check/{string}/{date}/{empid}/{id}', 'EmployeeController@editCheckDate');

Route::post('employee/add-check-emp-number', 'EmployeeController@addCheckEmpNumber');
Route::post('employee/check-emp-number/{id}', 'EmployeeController@checkEmpNumber');

Route::get('employee/payitem', 'EmployeeController@payItem');
Route::get('employee/editPayItem/{id}', 'EmployeeController@editPayItem');
Route::get('employee/editPayItem/{id}', 'EmployeeController@editPayItem');
Route::get('employee/edit/{id}', 'EmployeeController@edit');
Route::post('employee/edit/{id}', 'EmployeeController@update');
Route::get('employee/addPayItem', 'EmployeeController@addPayItem');

Route::post('payitem/check_addname','EmployeeController@checkpayitemaddname');
Route::post('payitem/check_editname/{id}','EmployeeController@checkotpayitemeditname');
//Route::post('employee/addPayItem', 'EmployeeController@storePayItem');
//new
Route::post('employee/addPayItem', 'EmployeeController@storePayItem');
Route::post('employee/deleteall', 'EmployeeController@deleteall');
Route::get('employee/view/{id}', 'EmployeeController@view');
Route::get('employee/delete/{id}', 'EmployeeController@delete');
//import employee status
Route::get('employee/importemployeestatus/{id}', 'EmployeeController@importemployeestatus');
Route::post('employee/importemployeestatus/{id}', 'EmployeeController@importemployeestatusfile');
Route::get('employee/importemployedownload', 'EmployeeController@downloadempstatus');
Route::get('employee/importemployeejob/{id}', 'EmployeeController@importemployeejob');
Route::post('employee/importemployeejob/{id}', 'EmployeeController@importemployeejobfile');
Route::get('employee/importemployejobdownload', 'EmployeeController@downloadempjob');
Route::get('employee/importemployeecompensation/{id}', 'EmployeeController@importempcompensation');
Route::post('employee/importemployeecompensation/{id}', 'EmployeeController@importempcompensationfile');
Route::get('employee/importemployecompendownload', 'EmployeeController@downloadempcompen');
Route::get('employee/importemployeebonus/{id}', 'EmployeeController@importemployeebonus');
Route::post('employee/importemployeebonus/{id}', 'EmployeeController@importempbonuscommfile');
Route::get('employee/importemployebonusdownload', 'EmployeeController@downloadempbonus');

Route::post('employee/assign-benefits','BenefitTypeController@Assignbenefits');
Route::get('employee/editempbenefit/{id}','BenefitTypeController@Editempbenefits');
Route::post('employee/editempbenefit/{id}','BenefitTypeController@Editempbenefits');


//Employee Ends
//User Starts
Route::get('developer/user-listing', 'DeveloperController@userListing');
Route::get('developer/add-user', 'DeveloperController@addUser');
Route::post('developer/add-user', 'DeveloperController@addUser');
Route::get('developer/edit-user/{id}', 'DeveloperController@editUser');
Route::post('developer/edit-user/{id}', 'DeveloperController@editUser');
Route::get('developer/delete-user/{id}', 'DeveloperController@deleteUser');
Route::post('developer/delete-user/{id}', 'DeveloperController@deleteUser');
//multiple Approve
Route::get('config/company/multi-approve', 'ConfigSettingsController@multiApprove');
Route::post('config/company/multi-approve', 'ConfigSettingsController@multiApprove');

//User Ends
//configuration-settings Starts
Route::get('config/configuration-settings', 'ConfigSettingsController@index');
Route::get('config/leave-settings', 'ConfigSettingsController@leaveSettings');

Route::get('config/edit-account-register', 'ConfigSettingsController@editCompanyProfile');
Route::post('config/edit-account-register', 'ConfigSettingsController@editCompanyProfile');
Route::post('employee/edit_check_uen/{id}', 'ConfigSettingsController@checkEditUen');

Route::get('config/category', 'ConfigSettingsController@categoryListing');
Route::get('config/add-category', 'ConfigSettingsController@addCategory');
Route::post('config/add-category', 'ConfigSettingsController@addCategory');
Route::get('config/edit-category/{string}', 'ConfigSettingsController@editCategory');
Route::post('config/edit-category/{string}', 'ConfigSettingsController@editCategory');
Route::get('config/delete-category/{string}', 'ConfigSettingsController@deleteCategory');
//configuration-settings for category Ends
//Nationality Start
Route::get('config/nationality', 'ConfigSettingsController@nationalityListing');
Route::get('config/add-nationality', 'ConfigSettingsController@addNationality');
Route::post('config/add-nationality', 'ConfigSettingsController@addNationality');
Route::get('config/edit-nationality/{string}', 'ConfigSettingsController@editNationality');
Route::post('config/edit-nationality/{string}', 'ConfigSettingsController@editNationality');
Route::get('config/delete-nationality/{string}', 'ConfigSettingsController@deleteNationality');
//Nationality Ends
//Desination Starts
Route::get('config/designation', 'ConfigSettingsController@addJobTitle');
Route::post('config/create-designation', 'ConfigSettingsController@insertJobTitle');
Route::get('config/edit-designation/{string}', 'ConfigSettingsController@editJobTitle');
Route::post('config/edit-designation/{string}', 'ConfigSettingsController@editJobTitle');
Route::get('config/delete-designation/{string}', 'ConfigSettingsController@deleteJobTitle');
//Desination Starts

Route::get('config/residential-status', 'ConfigSettingsController@residentialStatus');
Route::get('config/add-residential-status', 'ConfigSettingsController@addresidentialStatus');
Route::post('config/add-residential-status', 'ConfigSettingsController@addresidentialStatus');
Route::get('config/edit-residential-status/{string}', 'ConfigSettingsController@editresidentialStatus');
Route::post('config/edit-residential-status/{string}', 'ConfigSettingsController@editresidentialStatus');
Route::get('config/delete-residential-status/{string}', 'ConfigSettingsController@deleteresidentialStatus');

Route::get('config/pob', 'ConfigSettingsController@pobListing');
Route::get('config/add-pob', 'ConfigSettingsController@addPob');
Route::post('config/add-pob', 'ConfigSettingsController@addPob');
Route::get('config/edit-pob/{string}', 'ConfigSettingsController@editPob');
Route::post('config/edit-pob/{string}', 'ConfigSettingsController@editPob');
Route::get('config/delete-pob/{string}', 'ConfigSettingsController@deletePob');

Route::get('config/race', 'ConfigSettingsController@race');
Route::get('config/add-race', 'ConfigSettingsController@addRace');
Route::post('config/add-race', 'ConfigSettingsController@addRace');
Route::get('config/edit-race/{string}', 'ConfigSettingsController@editRace');
Route::post('config/edit-race/{string}', 'ConfigSettingsController@editRace');
Route::get('config/delete-race/{string}', 'ConfigSettingsController@deleteRace');

Route::get('config/notification/{id}', 'ConfigSettingsController@notification');
Route::post('config/notification/{id}', 'ConfigSettingsController@notification');

Route::get('branch/branch-list', 'ConfigSettingsController@branchListing');
Route::post('branch/branch-list', 'ConfigSettingsController@branchListing');
//Route::get('branch/add-branch','ConfigSettingsController@addBranch');
//Route::post('branch/add-branch','ConfigSettingsController@addBranch');
Route::get('branch/edit-branch/{string}', 'ConfigSettingsController@editBranch');
Route::post('branch/edit-branch/{string}', 'ConfigSettingsController@editBranch');
Route::get('branch/delete-branch/{string}', 'ConfigSettingsController@deleteBranch');

Route::get('config/martial-status', 'ConfigSettingsController@martialStatusListing');
Route::get('config/add-martial-status', 'ConfigSettingsController@addMartialStatus');
Route::post('config/add-martial-status', 'ConfigSettingsController@addMartialStatus');
Route::get('config/edit-martial-status/{string}', 'ConfigSettingsController@editMartialStatus');
Route::post('config/edit-martial-status/{string}', 'ConfigSettingsController@editMartialStatus');
Route::get('config/delete-martial-status/{string}', 'ConfigSettingsController@deleteMartialStatus');

//Division Starts
Route::get('config/division', 'ConfigSettingsController@addDivision');
Route::post('config/create-division', 'ConfigSettingsController@insertDivision');
Route::get('config/edit-division/{string}', 'ConfigSettingsController@editDivision');
Route::post('config/edit-division/{string}', 'ConfigSettingsController@editDivision');
Route::get('config/delete-division/{string}', 'ConfigSettingsController@deleteDivision');
//Division Starts
//Department Starts
Route::get('config/department', 'ConfigSettingsController@addDepartment');
Route::post('config/create-department', 'ConfigSettingsController@insertDepartment');
Route::get('config/edit-department/{string}', 'ConfigSettingsController@editDepartment');
Route::post('config/edit-department/{string}', 'ConfigSettingsController@editDepartment');
Route::get('config/delete-department/{string}', 'ConfigSettingsController@deleteDepartment');
//Department Starts


Route::get('config/allowance', 'ConfigSettingsController@allowance');
Route::get('config/add-allowance', 'ConfigSettingsController@addAllowance');
Route::post('config/add-allowance', 'ConfigSettingsController@addAllowance');
Route::get('config/edit-allowance/{string}', 'ConfigSettingsController@editAllowance');
Route::post('config/edit-allowance/{string}', 'ConfigSettingsController@editAllowance');
Route::get('config/delete-allowance/{string}', 'ConfigSettingsController@deleteAllowance');

Route::get('config/leave-type', 'ConfigSettingsController@leaveTypeListing');
Route::get('config/add-leave-type', 'ConfigSettingsController@addLeaveType');
Route::post('config/add-leave-type', 'ConfigSettingsController@addLeaveType');
Route::get('config/edit-leave-type/{string}', 'ConfigSettingsController@editLeaveType');
Route::post('config/edit-leave-type/{string}', 'ConfigSettingsController@editLeaveType');
Route::get('config/delete-leave-type/{string}', 'ConfigSettingsController@deleteLeaveType');

Route::get('config/leave-policy', 'ConfigSettingsController@leavePolicies');
Route::get('config/add-leave-policy', 'ConfigSettingsController@addLeavePolicy');
Route::post('config/add-leave-policy', 'ConfigSettingsController@addLeavePolicy');
Route::get('config/edit-leave-policy/{string}', 'ConfigSettingsController@editLeavePolicy');
Route::post('config/edit-leave-policy/{string}', 'ConfigSettingsController@editLeavePolicy');
Route::get('config/delete-leave-policy/{string}', 'ConfigSettingsController@deleteLeavePolicy');

Route::get('config/calendar/add-calendar', 'ConfigSettingsController@addCalendarConfig');
Route::post('config/calendar/add-calendar', 'ConfigSettingsController@addCalendarConfig');
Route::get('config/calendar/edit-calendar/{string}', 'ConfigSettingsController@editCalendarConfig');
Route::post('config/calendar/edit-calendar/{string}', 'ConfigSettingsController@editCalendarConfig');
Route::get('config/calendar/calendar-list', 'ConfigSettingsController@calendarList');
Route::get('config/calendar/delete-calendar/{string}', 'ConfigSettingsController@deleteCalendar');
Route::get('config/calendar/view-calendar/{string}', 'ConfigSettingsController@viewcalendar');
Route::get('config/calendar/assign-alt-holiday', 'ConfigSettingsController@assignAltHolidaycalendar');
Route::post('config/calendar/assign-alt-holiday', 'ConfigSettingsController@assignAltHolidaycalendar');
Route::get('config/calendar/assign-alt-holiday-list', 'ConfigSettingsController@assignedCalendarList');
Route::get('config/calendar/edit-assign-alt-holiday/{string}', 'ConfigSettingsController@editAssignAltHoliday');
Route::post('config/calendar/edit-assign-alt-holiday/{string}', 'ConfigSettingsController@editAssignAltHoliday');
Route::get('config/calendar/delete-assigned-holiday/{string}', 'ConfigSettingsController@deleteAssignHoliday');

Route::get('config/leave/holiday-list', 'ConfigSettingsController@holidayList');
Route::post('config/leave/holiday-list', 'ConfigSettingsController@holidayList');
Route::get('config/leave/add-holiday', 'ConfigSettingsController@addHoliday');
Route::post('config/leave/add-holiday', 'ConfigSettingsController@addHoliday');
Route::get('config/leave/edit-holiday/{id}', 'ConfigSettingsController@editHoliday');
Route::post('config/leave/edit-holiday/{id}', 'ConfigSettingsController@editHoliday');
Route::get('config/leave/delete-holiday/{id}', 'ConfigSettingsController@deleteHoliday');
Route::get('config/leave/add-alt-holiday/{id}', 'ConfigSettingsController@addAltHoliday');
Route::post('config/leave/add-alt-holiday/{id}', 'ConfigSettingsController@addAltHoliday');
Route::get('config/leave/edit-alt-holiday/{id}/{aid}', 'ConfigSettingsController@editAltHoliday');
Route::post('config/leave/edit-alt-holiday/{id}/{aid}', 'ConfigSettingsController@editAltHoliday');
Route::get('config/leave/delete-alt-holiday/{id}/{aid}', 'ConfigSettingsController@deleteAltHoliday');
Route::get('config/leave/alt-holiday-list', 'ConfigSettingsController@altHolidayList');
Route::post('config/leave/get_day_name/{id}', 'ConfigSettingsController@getDayname');
Route::post('config/leave/get_holiday/{id}/{string}', 'ConfigSettingsController@getCalHoliday');
Route::post('calendar/check-holiday-name/', 'ConfigSettingsController@checkHolidayName');
Route::post('calendar/check-holiday-name/edit/{id}', 'ConfigSettingsController@editCheckHolidayName');
//holiday upload
Route::get('config/leave/upload-holiday', 'ConfigSettingsController@holidayUpload');
Route::post('config/leave/upload-holiday', 'ConfigSettingsController@holidayUpload');
//
// Company User Settings
Route::get('config/company-user-settings', 'ConfigSettingsController@companyUserSettings');
//Route::get('config/company/add-user/{id?}','DeveloperController@addUser');
//Route::get('company/edit-user/{id}','DeveloperController@editUser');
Route::get('company/delete-user/{id}', 'DeveloperController@deleteUser');
Route::get('config/company/add-user', 'ConfigSettingsController@addUser');
Route::post('config/company/add-user', 'ConfigSettingsController@addUser');
Route::get('config/company/edit-user/{id}', 'ConfigSettingsController@editUser');
Route::post('config/company/edit-user/{id}', 'ConfigSettingsController@editUser');
//multiple approve Edit
Route::get('config/company/edit-approve/{id}', 'ConfigSettingsController@editApprove');
Route::post('config/company/edit-approve/{id}', 'ConfigSettingsController@editApprove');

//

Route::get('developer/announcements', 'DeveloperController@announcements');
Route::get('developer/delete-announcements/{string}', 'DeveloperController@deleteAnnouncements');
Route::get('developer/send-announcement/', 'DeveloperController@sendAnnouncement');
Route::post('developer/send-announcement/', 'DeveloperController@sendAnnouncement');
Route::get('developer/view-announcement/{string1}/{string2}', 'DeveloperController@viewAnnouncement');
Route::post('developer/announcement/get_users/{id}', 'DeveloperController@getUsers');

Route::get('developer/edit_profile/{string}', 'HomeController@editProfile');
Route::post('developer/edit_profile/{string}', 'HomeController@editProfile');

Route::get('employee/assign-policy/{id}', 'EmployeeController@assignPolicy');
Route::post('employee/assign-policy/{id}', 'EmployeeController@assignPolicy');
Route::get('employee/view-assign-policy/{id}/{string}', 'EmployeeController@viewAssignPolicy');
Route::get('employee/delete-assign-policy/{id}/{aid}', 'EmployeeController@deleteAssignPolicy');
Route::get('employee/leave-apply', 'EmployeeController@leaveApply');
Route::post('employee/leave-apply', 'EmployeeController@leaveApply');
Route::post('employee/get_emp_id/{id}', 'EmployeeController@getEmpId');
Route::post('employee/get_emp_calender/{id}', 'EmployeeController@getEmpCalender');
//Route::post('employee/get-holidays/{id}','EmployeeController@getHolidays');
Route::get('employee/leave/get-days/{startdate}/{enddate}/{id}', 'EmployeeController@getDays');
Route::get('employee/leave-applied', 'EmployeeController@leaveAppllied');
//Route::get('employee/leave-applied/{string}','EmployeeController@leaveAppllied');
Route::post('employee/leave-applied', 'EmployeeController@leaveAppllied');
Route::get('employeee/approval-type/{string1}/{string2}', 'EmployeeController@leaveApprovalRow');
Route::get('employee/leave-apply/{id}', 'EmployeeController@leaveApplyEmp');
Route::post('employee/leave-apply/{id}', 'EmployeeController@leaveApplyEmp');
Route::get('employee/cancel-leave/{id}/{lid}', 'EmployeeController@cancelLeaveEmp');
Route::get('employee/check-leave/{string1}/{string2}/{id}', 'EmployeeController@checkLeave');
Route::get('employee/current_balance/{string}', 'EmployeeController@getCurrentBalance');
Route::get('employee/covering-person/{id}', 'EmployeeController@coveringPerson');
Route::post('employee/covering-person/{id}', 'EmployeeController@coveringPerson');


Route::get('config/blackout/calendar-list', 'ConfigSettingsController@blackoutListing');
Route::get('config/blackout/add-blackout', 'ConfigSettingsController@addBlackout');
Route::post('config/blackout/add-blackout', 'ConfigSettingsController@addBlackout');
Route::get('config/blackout/edit-blackout/{string}', 'ConfigSettingsController@editBlackout');
Route::post('config/blackout/edit-blackout/{string}', 'ConfigSettingsController@editBlackout');
Route::get('config/blackout/delete-blackout/{string}', 'ConfigSettingsController@deleteBlackout');

Route::get('config/employement_category', 'ConfigSettingsController@employementCategoryListing');
Route::get('config/add-employement_category', 'ConfigSettingsController@addEmployementCategory');
Route::post('config/add-employement_category', 'ConfigSettingsController@addEmployementCategory');
Route::get('config/edit-employement_category/{string}', 'ConfigSettingsController@editEmployementCategory');
Route::post('config/edit-employement_category/{string}', 'ConfigSettingsController@editEmployementCategory');
Route::get('config/delete-employement_category/{string}', 'ConfigSettingsController@deleteEmployementCategory');
Route::get('employee/payroll-settings', 'EmployeeController@payrollSettings');
Route::post('employee/payroll-settings', 'EmployeeController@payrollSettings');


/* Payroll routing */
Route::get('payroll/payroll-listing', 'PayrollController@payrollListing');
Route::get('payroll/send-notification', 'PayrollController@sendNotification');
Route::post('payroll/payroll-process', 'PayrollController@payrollProcess');
Route::get('payroll/payroll-edit/{id}', 'PayrollController@payrollEditProcess');
Route::post('payroll/recalculate-process', 'PayrollController@recalculateProcess');
Route::get('payroll/reprocess-salary', 'PayrollController@payrollReprocess');
Route::get('payroll/approval-salary', 'PayrollController@payrollApprovalListing');
Route::get('payroll/approve-salary', 'PayrollController@payrollApprove');
Route::get('payroll/send-for-approval', 'PayrollController@payrollSendforApproval');
Route::post('payroll/ajax-call', 'PayrollController@ajaxCall');
Route::get('payroll/delete-salary/{id}', 'PayrollController@deleteProcessedSalary');
Route::get('payroll/view-payslip', 'PayrollController@viewPayslip');
Route::post('payroll/view-payslip', 'PayrollController@viewPayslip');

Route::get('payroll/testcpf','PayrollController@testCpfRate');

 /*Added for Payrol settings*/
Route::get('payroll/config/ad-hoc', 'PayrollController@ad_hoc');
Route::get('payroll/config/bonus', 'PayrollController@bonus');
Route::post('payroll/config/bonus', 'PayrollController@bonus');
Route::get('payroll/config/commission', 'PayrollController@commission');
Route::post('payroll/config/commission', 'PayrollController@commission');
Route::get('payroll/config/overtime', 'PayrollController@overtime');
Route::post('payroll/config/overtime', 'PayrollController@overtime');
Route::get('payroll/config/reimbursement', 'PayrollController@reimbursement');
Route::post('payroll/config/reimbursement', 'PayrollController@reimbursement');

Route::get('payroll/mass-assign', 'PayrollController@massAssign');
Route::post('payroll/mass-assign', 'PayrollController@massAssign');
Route::get('payroll/mass-assign-payinstructions', 'PayrollController@massAssignPayroll_Instructions');
Route::post('payroll/mass-assign-payinstructions', 'PayrollController@massAssignPayroll_Instructions');

Route::get('payroll/mass-assign-employees', 'PayrollController@massAssignEmployees');
Route::post('payroll/mass-assign-employees', 'PayrollController@massAssignEmployees');
Route::get('payroll/bonus-edit/{id}', 'PayrollController@bonusedit');
Route::post('payroll/bonus-edit/{id}', 'PayrollController@bonusedit');

Route::get('payroll/commission-edit/{id}', 'PayrollController@commissionedit');
Route::post('payroll/commission-edit/{id}', 'PayrollController@commissionedit');

Route::post('payroll/bulkupload/overtime', 'PayrollController@bulkovertime');
Route::post('payroll/bulkupload/bonus', 'PayrollController@bulkbonus');
Route::post('payroll/bulkupload/commission', 'PayrollController@bulkcommission');
Route::post('payroll/bulkupload/reimbursement', 'PayrollController@bulkreimbursement');

Route::get('payroll/adhoc/add', 'PayrollController@adhocadd');
Route::get('payroll/adhoc/edit/{id}', 'PayrollController@adhocedit');
Route::post('payroll/adhoc/store', 'PayrollController@adhocadd');
Route::get('payroll/adhoc/mass-assign/{id}', 'PayrollController@adhocmassassign');
Route::post('payroll/adhoc/mass-assign/{id}', 'PayrollController@adhocmassassign');
Route::post('payroll/adhoc/adddetail/{id}', 'PayrollController@adhocadddetail');
Route::get('payroll/ad-hoc/approve/{id}', 'PayrollController@adhocapprove');
Route::get('payroll/adhoc-approval-summary', 'PayrollController@adhocapprovallist');
Route::post('payroll/adhoc-approval-summary', 'PayrollController@adhocpayrollapproved');
Route::get('payroll/adhoc/approved/{id}', 'PayrollController@adhocpayrollapproved');

Route::post('payroll/recalculate/bonus', 'PayrollController@RecalculateBonus');
Route::post('payroll/recalculate/commission', 'PayrollController@RecalculateCommission');
Route::post('payroll/recalculate/reimbursement', 'PayrollController@RecalculateReimbursement');
Route::post('payroll/recalculate/overtime', 'PayrollController@RecalculateOvertime');

/* Payroll routing end */
Route::get('temp/payroll', 'TempController@payrollView');

/* Dashboard */
Route::get('dashboard', 'DashboardController@index');

/* Reports routing */
Route::get('reports/leave-summary', 'ReportsController@leaveSummaryReport');
Route::post('reports/leave-summary', 'ReportsController@leaveSummaryReport');
Route::get('reports/scheduled-leave', 'ReportsController@scheduledLeaveReport');
Route::post('reports/scheduled-leave', 'ReportsController@scheduledLeaveReport');
Route::resource('reports/birthday-summary', 'ReportsController@birthdaySummaryReport');
Route::resource('reports/employee-turnover', 'ReportsController@employeeTurnOverReport');
Route::resource('reports/pass-expiry-date', 'ReportsController@passExpiryDateReport');
Route::resource('reports/new-hires-termination', 'ReportsController@hiresTerminationReport');
Route::get('reports/monthly-salary', 'ReportsController@monthlySalary');
Route::post('reports/monthly-salary', 'ReportsController@monthlySalary');
Route::get('reports/yearly-salary', 'ReportsController@yearlySalary');
Route::post('reports/yearly-salary', 'ReportsController@yearlySalary');
Route::get('reports/age-profile-report', 'ReportsController@ageProfileReport');
Route::post('reports/age-profile-report', 'ReportsController@ageProfileReport');
Route::get('reports/payslip', 'ReportsController@payslip');
Route::post('reports/payslip', 'ReportsController@payslip');
Route::get('reports/bank', 'ReportsController@bank');
Route::post('reports/bank', 'ReportsController@bank');
Route::get('reports/cpf', 'ReportsController@cpf');
Route::post('reports/cpf', 'ReportsController@cpf');
Route::get('reports/ecpf-ftp', 'ReportsController@eSubmisionCpfFtp');
Route::get('reports/income', 'ReportsController@incomeTax');
Route::post('reports/income', 'ReportsController@incomeTax');
Route::post('reports/save-chart', 'ReportsController@saveChart');
//Route::get('reports/generate', 'ReportsController@generate');
//Route::get('reports/generate/{id}', 'ReportsController@generate1');	
Route::get('reports/generate', 'ReportsController@generate');
Route::post('reports/GenerateIr8aOne', 'ReportsController@GenerateIr8aOne');
Route::post('reports/GenerateIr8aAll', 'ReportsController@GenerateIr8aAll');
Route::get('reports/generate-temp', 'ReportsController@generatetemp');//for teting pdf design
Route::get('reports/generate-temp-all', 'ReportsController@generatetempAll');//for teting pdf design

Route::post('reports/generate1', 'ReportsController@generate2');
/* Reports routing end */

//Payroll PDF Starts
Route::get('payrollPdf/{id?}', 'PayrollController@payrollPdf');
Route::get('payrollPdf/generateAll/{id?}', 'PayrollController@payrollPdf');
Route::get('payroll/prcess/pdf', 'PayrollController@processPdf');
Route::get('payroll/approval/pdf', 'PayrollController@approvalPdf');
Route::get('adhocPdf/{id?}', 'PayrollController@adhocpayrollPdf');
//Payroll PDF Ends

/* Print Pdf in reports Start */
Route::get('reports/monthly-salary/pdf', 'ReportPdfController@MonthlySalaryPdf');
Route::get('reports/yearly-salary/pdf', 'ReportPdfController@YearlySalaryPdf');
Route::get('reports/payslip-salary/pdf', 'ReportPdfController@PayslipSalaryPdf');
Route::get('reports/bank/pdf', 'ReportPdfController@BankPdf');
Route::get('reports/income/pdf', 'ReportPdfController@IncomePdf');
Route::get('reports/turnover/pdf', 'ReportPdfController@TurnoverPdf');
Route::get('reports/birthday/pdf', 'ReportPdfController@BirthdayPdf');
Route::get('reports/hiretermination/pdf', 'ReportPdfController@hireTerminationPdf');
Route::get('reports/age_profile/pdf', 'ReportPdfController@ageProfilePdf');
Route::get('reports/pass_expiry/pdf', 'ReportPdfController@passExpiryPdf');
Route::get('reports/leave_summary/pdf', 'ReportPdfController@leaveSummaryPdf');
Route::get('reports/schedule/pdf', 'ReportPdfController@schedulePdf');
Route::get('reports/cpf/pdf', 'ReportPdfController@cpfPdf');
Route::get('reports/attendance_summary/pdf', 'ReportPdfController@AttendanceSummaryPdf');
Route::get('reports/overtime_summary/pdf', 'ReportPdfController@OvertimeSummaryPdf');
Route::get('reports/overtime_summary_hr/pdf', 'ReportPdfController@OvertimeSummaryHRPdf');
Route::get('reports/schedule_summary/pdf', 'ReportPdfController@ScheduleSummaryPdf');
Route::get('reports/schedule_processed_summary/pdf', 'ReportPdfController@ScheduleProcessedSummaryPdf');
Route::get('reports/expense-report/pdf', 'ReportPdfController@ExpenseReportPdf');

/* Print Pdf in reports end */

/* Report on Excel on Start */
Route::get('reports/excel/birthday', 'ExcelController@BirthdayExcel');
Route::get('reports/excel/monthly', 'ExcelController@MonthlyExcel');
Route::get('reports/excel/yearly', 'ExcelController@YearlyExcel');
Route::get('reports/excel/bank', 'ExcelController@BankExcel');
Route::get('reports/excel/cpf', 'ExcelController@CPFExcel');
Route::get('reports/excel/income', 'ExcelController@IncomeExcel');
Route::get('reports/excel/income', 'ExcelController@IncomeExcel');
Route::get('reports/excel/turnover', 'ExcelController@TurnoverExcel');
Route::get('reports/excel/hiretermination', 'ExcelController@HireterminationExcel');
Route::get('reports/excel/age_profile', 'ExcelController@ageProfileExcel');
Route::get('reports/excel/pass_expiry', 'ExcelController@passExpiryExcel');
Route::get('reports/excel/leave_summary', 'ExcelController@leaveSummaryExcel');
Route::get('reports/excel/schedule', 'ExcelController@scheduleExcel');

Route::get('reports/excel/attendance_summary', 'ExcelController@AttendanceSummaryExcel');
Route::get('reports/excel/overtime_summary', 'ExcelController@OvertimeSummaryExcel');
Route::get('reports/excel/overtime_summary_hr', 'ExcelController@OvertimeSummaryHRExcel');
Route::get('reports/excel/schedule_summary', 'ExcelController@ScheduleSummaryExcel');
Route::get('reports/excel/schedule_processed_summary', 'ExcelController@ScheduleProcessedSummaryExcel');
Route::get('reports/excel/expense-report', 'ExcelController@ExpenseReportExcel');
/* Report on Excel End */


/* Configuration */


Route::get('fundconfiguration', 'FundConfigController@main');
Route::get('developer/fundconfigadd', 'FundConfigController@fundadd');
Route::post('fundconfig/storefund', 'FundConfigController@storefund');
Route::get('developer/fundedit/{id}', 'FundConfigController@fundedit');
Route::post('fundconfig/updatefund/{id}', 'FundConfigController@updatefund');
Route::get('fundconfig/remove/{id}', 'FundConfigController@remove');


Route::get('fundconfig', 'FundConfigController@index');
Route::get('fundconfig/add-cdac', 'FundConfigController@addCdac');
Route::post('fundconfig/add-cdac', 'FundConfigController@storeCdac');
Route::get('fundconfig/edit-cdac/{id}', 'FundConfigController@editCdac');
Route::post('fundconfig/edit-cdac/{id}', 'FundConfigController@updateCdac');

Route::get('fundconfig/add-mbmf', 'FundConfigController@addMbmf');
Route::post('fundconfig/add-mbmf', 'FundConfigController@storeMbmf');
Route::get('fundconfig/edit-mbmf/{id}', 'FundConfigController@editMbmf');
Route::post('fundconfig/edit-mbmf/{id}', 'FundConfigController@updateMbmf');

Route::get('fundconfig/add-sinda', 'FundConfigController@addSinda');
Route::post('fundconfig/add-sinda', 'FundConfigController@storeSinda');
Route::get('fundconfig/edit-sinda/{id}', 'FundConfigController@editSinda');
Route::post('fundconfig/edit-sinda/{id}', 'FundConfigController@updateSinda');

Route::get('fundconfig/add-ecf', 'FundConfigController@addEcf');
Route::post('fundconfig/add-ecf', 'FundConfigController@storeEcf');
Route::get('fundconfig/edit-ecf/{id}', 'FundConfigController@editEcf');
Route::post('fundconfig/edit-ecf/{id}', 'FundConfigController@updateEcf');

Route::post('fundconfig/check_config_name', 'FundConfigController@checkaddname');
Route::post('fundconfig/check_config_editname/{id}', 'FundConfigController@checkeditname');
Route::get('fundconfig/copybatch/{id}', 'FundConfigController@copybatch');
Route::post('fundconfig/copy-rate/{id}', 'FundConfigController@copyrate');


Route::get('cpfconfig/remove-age/{id}', 'CpfConfigController@removeage');
Route::get('cpfconfig/remove-wage/{id}', 'CpfConfigController@removewages');

Route::get('developer/cpfconfig', 'CpfConfigController@cpfrate');
Route::get('developer/cpfrateadd', 'CpfConfigController@cpfrateadd');
Route::get('developer/cpfrateedit/{id}', 'CpfConfigController@cpfrateedit');
Route::post('cpf-rate/store-rate', 'CpfConfigController@cpfratestore');
Route::post('cpf-rate/update-rate/{id}', 'CpfConfigController@cpfrateupdate');
Route::post('cpf-rate/storecpffull/{id}', 'CpfConfigController@storecpffull');
Route::post('cpf-rate/storecpfpr1/{id}', 'CpfConfigController@storecpfpr1');
Route::post('cpf-rate/storecpfpr1fg/{id}', 'CpfConfigController@storecpfpr1fg');
Route::post('cpf-rate/storecpfpr2/{id}', 'CpfConfigController@storecpfpr2');
Route::post('cpf-rate/storecpfpr2fg/{id}', 'CpfConfigController@storecpfpr2fg');

Route::post('cpfconfig/check_config_name', 'CpfConfigController@checkaddname');
Route::post('cpfconfig/check_config_editname/{id}', 'CpfConfigController@checkeditname');
Route::get('cpfconfig/copybatch/{id}', 'CpfConfigController@copybatch');
Route::post('cpf-rate/copy-rate/{id}', 'CpfConfigController@copyrate');



//Route::get('cpfconfig', 'CpfConfigController@index');
//Route::get('cpfconfig/edit-cpffull', 'CpfConfigController@editcpfFull');
//Route::post('cpfconfig/edit-cpffull', 'CpfConfigController@updatecpfFull');
//Route::get('cpfconfig/edit-cpfpr1', 'CpfConfigController@editcpfPr1');
//Route::post('cpfconfig/edit-cpfpr1', 'CpfConfigController@updatecpfPr1');
//Route::get('cpfconfig/edit-cpfpr1-fg', 'CpfConfigController@editcpfPr1fg');
//Route::post('cpfconfig/edit-cpfpr1-fg', 'CpfConfigController@updatecpfPr1fg');
//Route::get('cpfconfig/edit-cpfpr2', 'CpfConfigController@editcpfPr2');
//Route::post('cpfconfig/edit-cpfpr2', 'CpfConfigController@updatecpfPr2');
//Route::get('cpfconfig/edit-cpfpr2-fg', 'CpfConfigController@editcpfPr2fg');
//Route::post('cpfconfig/edit-cpfpr2-fg', 'CpfConfigController@updatecpfPr2fg');

Route::get('sdlconfig', 'SdlConfigController@index');
Route::get('sdlconfig/add-sdl', 'SdlConfigController@add');
Route::post('sdlconfig/add-sdl', 'SdlConfigController@store');
Route::get('sdlconfig/edit-sdl/{id}', 'SdlConfigController@edit');
Route::post('sdlconfig/edit-sdl/{id}', 'SdlConfigController@update');
Route::post('sdlconfig/editsdl/{id}', 'SdlConfigController@updatesdl');
Route::get('sdlconfig/remove/{id}', 'SdlConfigController@remove');

Route::post('sdlconfig/check_config_name', 'SdlConfigController@checkaddname');
Route::post('sdlconfig/check_config_editname/{id}', 'SdlConfigController@checkeditname');
Route::get('sdlconfig/copybatch/{id}', 'SdlConfigController@copybatch');
Route::post('sdlconfig/copy-rate/{id}', 'SdlConfigController@copyrate');

Route::get('ir8a', 'Ir8aConfigController@index');
Route::post('ir8a/add-items', 'Ir8aConfigController@additems');
Route::post('ir8a/edit-items', 'Ir8aConfigController@edititems');
Route::get('ir8a/delete/{id}', 'Ir8aConfigController@delete');
Route::post('ir8a/add-details', 'Ir8aConfigController@adddetails');
Route::get('ir8a/add-details', 'Ir8aConfigController@adddetails');
Route::get('income/details','TrainingController@addDetails');
Route::post('income/details','TrainingController@addDetails');


/* Overtime policy */

Route::get('companysettings', 'CompanySettingsController@index');
Route::get('companysettings/add', 'CompanySettingsController@add');
Route::post('companysettings/add', 'CompanySettingsController@store');
Route::get('companysettings/edit/{id}', 'CompanySettingsController@edit');
Route::post('companysettings/edit/{id}', 'CompanySettingsController@update');
Route::get('companysettings/edit_company/{id}', 'CompanySettingsController@edit_company');
Route::post('companysettings/edit_company/{id}', 'CompanySettingsController@update_company');

Route::get('overtimepolicy', 'OvertimePolicyController@index');
Route::get('overtimepolicy/add', 'OvertimePolicyController@add');
Route::post('overtimepolicy/add', 'OvertimePolicyController@store');
Route::get('overtimepolicy/edit/{id}', 'OvertimePolicyController@edit');
Route::post('overtimepolicy/edit/{id}', 'OvertimePolicyController@update');

Route::get('otrates', 'OtRatesController@index');
Route::get('otrates/add', 'OtRatesController@add');
Route::post('otrates/add', 'OtRatesController@store');
Route::get('otrates/edit/{id}', 'OtRatesController@edit');
Route::post('otrates/edit/{id}', 'OtRatesController@update');

//otratescaluculation
Route::get('otratescalculation', 'OtratesCalculationController@index');
Route::post('otratescalculation', 'OtratesCalculationController@index');
Route::get('otratescalculation/add', 'OtratesCalculationController@add');
Route::post('otratescalculation/add', 'OtratesCalculationController@store');
Route::get('otratescalculation/edit/{id}', 'OtratesCalculationController@edit');
Route::post('otratescalculation/edit/{id}', 'OtratesCalculationController@update');
Route::get('otratescalculation/delete/{id}', 'OtratesCalculationController@delete');
//otratescaluculation finished
// Expense and benefit
Route::get('expense-type', 'ExpenseTypeController@index');
Route::get('expense-type/add', 'ExpenseTypeController@add');
Route::post('expense-type/add', 'ExpenseTypeController@store');
Route::get('expense-type/edit/{id}', 'ExpenseTypeController@edit');
Route::post('expense-type/edit/{id}', 'ExpenseTypeController@update');
Route::get('expense-type/view/{id}', 'ExpenseTypeController@view');
Route::post('expense-type/view/{id}', 'ExpenseTypeController@view');
Route::get('expense-type/delete/{id}', 'ExpenseTypeController@delete');

Route::get('benefit-type', 'BenefitTypeController@index');
Route::get('benefit-type/add', 'BenefitTypeController@add');
Route::post('benefit-type/add', 'BenefitTypeController@store');
Route::get('benefit-type/edit/{id}', 'BenefitTypeController@edit');
Route::post('benefit-type/edit/{id}', 'BenefitTypeController@update');
Route::get('benefit-type/view/{id}', 'BenefitTypeController@view');
Route::post('benefit-type/view/{id}', 'BenefitTypeController@view');
Route::get('benefit-type/delete/{id}', 'BenefitTypeController@delete');
//Expense and benefit finished
//Submit Expense start
Route::get('expense', 'ExpenseController@index');
Route::post('expense', 'ExpenseController@index');
Route::get('expense/add', 'ExpenseController@add');
Route::post('expense/add', 'ExpenseController@store');
Route::get('expense/getsubcategory/{id}', 'ExpenseController@getsubcategory');
Route::get('expense/getdescription/{id}', 'ExpenseController@getdescription');
Route::get('expense/edit/{id}', 'ExpenseController@edit');
Route::post('expense/edit/{id}', 'ExpenseController@update');
Route::get('expense/delete/{id}', 'ExpenseController@delete');
Route::get('expense/copy-expense/{id}', 'ExpenseController@copyexpense');
Route::post('expense/copy', 'ExpenseController@copy');
Route::get('expense/view/{id}', 'ExpenseController@view');
Route::post('expense/view/{id}', 'ExpenseController@views');
Route::get('expense/split-expense/{id}', 'ExpenseController@splitexpense');
Route::post('expense/split', 'ExpenseController@split');
Route::get('expense/clientsplit-expense/{id}', 'ExpenseController@clientsplitexpense');
Route::post('expense/clientsplit', 'ExpenseController@clientsplit');
Route::get('expense/download/{id}', 'ExpenseController@download');
Route::get('expense/approve/{id}', 'ExpenseController@approve');
Route::post('expense/approve', 'ExpenseController@approve');
Route::get('expense/download1/{id}', 'ExpenseController@download1');
//Route::get('expense/split', 'ExpenseController@add');

//Route::get('expense/split', 'ExpenseController@add');
//Route::post('expense/split', 'ExpenseController@split');

//Submit Expense finished
//Benefit Start
Route::get('benefit', 'BenefitController@index');
Route::post('benefit', 'BenefitController@index');
Route::get('benefit/add', 'BenefitController@add');
Route::post('benefit/add', 'BenefitController@store');
Route::get('benefit/getdetails/{id}', 'BenefitController@getdetails');
Route::get('benefit/getlimit/{id}', 'BenefitController@getlimit');
Route::get('benefit/getdescription/{id}', 'BenefitController@getdescription');
Route::get('benefit/edit/{id}', 'BenefitController@edit');
Route::post('benefit/edit/{id}', 'BenefitController@update');
Route::get('benefit/delete/{id}', 'BenefitController@delete');
Route::get('benefit/copy-benefit/{id}', 'BenefitController@copybenefit');
Route::post('benefit/copy', 'BenefitController@copy');
Route::get('benefit/download/{id}', 'BenefitController@download');
Route::get('benefit/approve/{id}', 'BenefitController@approve');
Route::post('benefit/approve', 'BenefitController@approve');
Route::get('benefit/view/{id}', 'BenefitController@view');
Route::post('benefit/view/{id}', 'BenefitController@views');
//Benefit Finished
//Benefit Report
Route::get('reports/excel/benefit-report', 'ExcelController@BenefitReportExcel');
Route::get('reports/benefit-report/pdf', 'ReportPdfController@BenefitReportPdf');
//Approve Expense
Route::get('approve-expense', 'ApproveExpenseController@index');
Route::post('approve-expense', 'ApproveExpenseController@index');
Route::get('approve-expense/edit/{id}', 'ApproveExpenseController@edit');
Route::post('approve-expense/edit/{id}', 'ApproveExpenseController@update');

Route::get('approve-expense/delete/{id}', 'ApproveExpenseController@delete');
Route::get('approve-expense/approve/{id}', 'ApproveExpenseController@approve');
Route::get('approve-expense/reject/{id}', 'ApproveExpenseController@reject');
Route::get('approve-expense/details/{id}', 'ApproveExpenseController@details');


Route::get('approve-expense/back/{id}', 'ApproveExpenseController@back');
//Route::get('approve-expense/details/{id}', 'ApproveExpenseController@back');
Route::get('approve-expense/all/{id}', 'ApproveExpenseController@all');
Route::get('approve-expense/view/{id}', 'ApproveExpenseController@view');
Route::post('approve-expense/view/{id}', 'ApproveExpenseController@views');
Route::post('approve-expense/details/{id}', 'ExpenseController@sent');

//Approve Expense Finished

//approve benefit
Route::get('approve-benefit', 'ApproveBenefitController@index');
Route::post('approve-benefit', 'ApproveBenefitController@index');
Route::get('approve-benefit/edit/{id}', 'ApproveBenefitController@edit');
Route::post('approve-benefit/edit/{id}', 'ApproveBenefitController@update');
Route::get('approve-benefit/details/{id}', 'ApproveBenefitController@details');
Route::post('approve-benefit/details/{id}', 'ApproveBenefitController@sent');
Route::get('approve-benefit/approve/{id}', 'ApproveBenefitController@approve');
Route::get('approve-benefit/delete/{id}', 'ApproveBenefitController@delete');
Route::get('approve-benefit/back/{id}', 'ApproveBenefitController@back');
Route::get('approve-benefit/reject/{id}', 'ApproveBenefitController@reject');
//approve benefit finished
Route::get('expense-report', 'ExpenseReportController@index');
Route::post('expense-report', 'ExpenseReportController@index');
//benefit reportRoute::get('benefit-report', 'BenefitReportController@index');
//Route::post('benefit-report', 'BenefitReportController@index');

Route::get('benefit-report', 'BenefitReportController@index');
Route::post('benefit-report', 'BenefitReportController@index');

Route::get('timeattendance-report', 'TimeAttendanceReportController@index');
Route::post('timeattendance-report', 'TimeAttendanceReportController@index');
Route::get('timeattendance-report/process', 'TimeAttendanceReportController@processreport');
Route::post('timeattendance-report/process', 'TimeAttendanceReportController@processreport');
Route::get('timeattendance-report/attendance', 'TimeAttendanceReportController@attendancereport');
Route::post('timeattendance-report/attendance', 'TimeAttendanceReportController@attendancereport');
Route::get('timeattendance-report/summaryreport', 'TimeAttendanceReportController@summaryreport');
Route::post('timeattendance-report/summaryreport', 'TimeAttendanceReportController@summaryreport');
Route::get('timeattendance-report/summaryhrm-and-hre', 'TimeAttendanceReportController@summaryhrm');
Route::post('timeattendance-report/summaryhrm-and-hre', 'TimeAttendanceReportController@summaryhrm');
Route::get('timeattendance-report/print-view/{string}', 'TimeAttendanceReportController@schedulePrint');
Route::get('timeattendance-report/process-view/{string}', 'TimeAttendanceReportController@processPrint');


Route::get('splitshift', 'SplitshiftController@index');
Route::get('splitshift/add', 'SplitshiftController@add');
Route::post('splitshift/add', 'SplitshiftController@store');
Route::get('splitshift/edit/{id}', 'SplitshiftController@edit');
Route::post('splitshift/edit/{id}', 'SplitshiftController@update');


Route::get('schedules', 'SchedulesController@index');
Route::get('schedules/add', 'SchedulesController@add');
Route::post('schedules/add', 'SchedulesController@store');
Route::get('schedules/edit/{id}', 'SchedulesController@edit');
Route::post('schedules/edit/{id}', 'SchedulesController@update');
Route::get('schedules/copy/{id}', 'SchedulesController@copy');

Route::get('employee-settings', 'EmployeeSettingsController@index');
Route::get('employee-settings/add', 'EmployeeSettingsController@add');
Route::post('employee-settings/add', 'EmployeeSettingsController@store');
Route::get('employee-settings/edit/{id}', 'EmployeeSettingsController@edit');
Route::post('employee-settings/edit/{id}', 'EmployeeSettingsController@update');


Route::get('roster', 'RosterController@index');
Route::post('roster', 'RosterController@index');
Route::get('roster/add', 'RosterController@add');
Route::post('roster/add', 'RosterController@add');
Route::post('roster/add-atten', 'RosterController@addatten');
Route::post('roster/edit-atten', 'RosterController@editatten');
Route::get('roster/empindex', 'RosterController@empindex');
Route::post('roster/empindex', 'RosterController@empindex');

Route::post('roster/add-atten-actual', 'RosterController@addattenactual');
Route::post('roster/edit-atten-actual', 'RosterController@editattenactual');
Route::post('roster/initalize','RosterController@initalize');

Route::get('roster/sample','RosterController@sample');
Route::get('roster/viewemployee', 'RosterController@viewemployee');
//Route::post('roster/sample','RosterController@sample');
Route::get('roster/attendance','RosterController@process_atten');
Route::get('roster/attendance/view/{id}','RosterController@process_atten_view');
Route::get('roster/attendance/printview/{id}','RosterController@printview');
Route::get('roster/approve/{id}', 'RosterController@approve');

Route::get('base/get_currency_convertor/{id}', 'BaseController@get_currency_convert');

Route::post('roster/attendance','RosterController@process_atten');

//Route::get('roster/attendance', 'RosterController@process_atten');
Route::post('monthlyroster/initalize', 'MonthlyrosterController@initalize');
Route::get('monthlyroster/view/{id}', 'MonthlyrosterController@view');
Route::post('monthlyroster/add-atten', 'MonthlyrosterController@addatten');
Route::post('monthlyroster/edit-atten', 'MonthlyrosterController@editatten');
Route::post('monthlyroster/add-atten-actual', 'MonthlyrosterController@addattenactual');
Route::post('monthlyroster/edit-atten-actual', 'MonthlyrosterController@editattenactual');
Route::post('monthlyroster/scheduleall', 'MonthlyrosterController@scheduleall');
Route::post('monthlyroster/clockedall', 'MonthlyrosterController@clockedall');
Route::post('monthlyroster/view/{id}', 'MonthlyrosterController@view');
Route::post('monthlyroster/reschedule', 'MonthlyrosterController@reschedule');
Route::post('monthlyroster/schedule', 'MonthlyrosterController@schedule');
Route::post('monthlyroster/rescheduleemp', 'MonthlyrosterController@rescheduleemp');

Route::get('monthlyroster/print-view/{id}', 'MonthlyrosterController@printview');
Route::post('monthlyroster/print-view/{id}', 'MonthlyrosterController@printview');

Route::get('monthlyroster/saveasdraft/{id}', 'MonthlyrosterController@saveasdraft');

Route::post('weeklyroster/initalize', 'WeeklyrosterController@initalize');
Route::get('weeklyroster/view/{id}', 'WeeklyrosterController@view');
Route::post('weeklyroster/add-atten', 'WeeklyrosterController@addatten');
Route::post('weeklyroster/edit-atten', 'WeeklyrosterController@editatten');
Route::post('weeklyroster/add-atten-actual', 'WeeklyrosterController@addattenactual');
Route::post('weeklyroster/edit-atten-actual', 'WeeklyrosterController@editattenactual');
Route::post('weeklyroster/scheduleall', 'WeeklyrosterController@scheduleall');
Route::post('weeklyroster/clockedall', 'WeeklyrosterController@clockedall');
Route::post('weeklyroster/view/{id}', 'WeeklyrosterController@view');
Route::post('weeklyroster/reschedule', 'WeeklyrosterController@reschedule');
Route::get('weeklyroster/print-view/{id}', 'WeeklyrosterController@printview');
Route::post('weeklyroster/print-view/{id}', 'WeeklyrosterController@printview');
Route::post('weeklyroster/schedule', 'WeeklyrosterController@schedule');
Route::post('weeklyroster/rescheduleemp', 'WeeklyrosterController@rescheduleemp');
Route::get('weeklyroster/saveasdraft/{id}', 'WeeklyrosterController@saveasdraft');


Route::post('specificroster/initalize', 'SpecificrosterController@initalize');
Route::get('specificroster/view/{id}', 'SpecificrosterController@view');
Route::get('specificroster/print-view/{id}', 'SpecificrosterController@printview');
Route::post('specificroster/print-view/{id}', 'SpecificrosterController@printview');
Route::post('specificroster/add-atten', 'SpecificrosterController@addatten');
Route::post('specificroster/edit-atten', 'SpecificrosterController@editatten');

Route::post('specificroster/scheduleall', 'SpecificrosterController@scheduleall');
Route::post('specificroster/clockedall', 'SpecificrosterController@clockedall');
Route::post('specificroster/initalize', 'SpecificrosterController@initalize');
Route::get('specificroster/view/{id}', 'SpecificrosterController@view');
Route::get('specificroster/saveasdraft/{id}', 'SpecificrosterController@saveasdraft');

Route::post('specificroster/add-atten-actual', 'SpecificrosterController@addattenactual');
Route::post('specificroster/edit-atten-actual', 'SpecificrosterController@editattenactual');
Route::post('specificroster/reschedule', 'SpecificrosterController@reschedule');


Route::post('fortnight/initalize', 'FortnightrosterController@initalize');

Route::get('fortnight/view/{id}', 'FortnightrosterController@view');
Route::post('fortnight/view/{id}', 'FortnightrosterController@view');
Route::post('fortnight/add-atten', 'FortnightrosterController@addatten');
Route::post('fortnight/edit-atten', 'FortnightrosterController@editatten');
Route::post('fortnight/add-atten-actual', 'FortnightrosterController@addattenactual');
Route::post('fortnight/edit-atten-actual', 'FortnightrosterController@editattenactual');


Route::get('fortnight/print-view/{id}', 'FortnightrosterController@printview');
Route::post('fortnight/print-view/{id}', 'FortnightrosterController@printview');

Route::get('fortnight/scheduleall', 'FortnightrosterController@scheduleall');
Route::post('fortnight/scheduleall', 'FortnightrosterController@scheduleall');
Route::post('fortnight/clockedall', 'FortnightrosterController@clockedall');
Route::post('fortnight/reschedule', 'FortnightrosterController@reschedule');

Route::get('fortnight/saveasdraft/{id}', 'FortnightrosterController@saveasdraft');

Route::get('roster/scheduleall/{id}', 'RosterController@scheduleall');
Route::get('roster/clockedall/{id}', 'RosterController@clockedall');
Route::get('roster/approveall/{id}', 'RosterController@approveall');
Route::get('roster/copy/{id}', 'RosterController@copy');
Route::post('schedules/check_schedule_name','SchedulesController@checkschedulename');
Route::post('schedules/edit_check_schedules_name/{id}','SchedulesController@editcheckschedulename');
Route::get('roster/refresh/{id}', 'RosterController@refresh');
Route::get('roster/saveasdraft/{id}', 'RosterController@saveasdraft');
Route::get('roster/announcement/{id}','RosterController@announcement');
Route::get('roster/actualsaveasdraft/{id}', 'RosterController@actualsaveasdraft');
Route::get('roster/empindex/{id}', 'RosterController@empindex');
Route::post('fortnight/edit-atten-actual-clocking', 'FortnightrosterController@editattenactualclocking');
Route::post('specificroster/edit-atten-actual-clocking', 'SpecificrosterController@editattenactualclocking');
Route::post('monthlyroster/edit-atten-actual-clocking', 'MonthlyrosterController@editattenactualclocking');
Route::post('weeklyroster/edit-atten-actual-clocking', 'WeeklyrosterController@editattenactualclocking');
Route::post('otrates/check_otrates_addname','OtRatesController@checkotratesaddname');
Route::post('otrates/check_otrates_editname/{id}','OtRatesController@checkotrateseditname');
Route::post('otpolicy/check_addname','OvertimePolicyController@checkotpolicyaddname');
Route::post('otpolicy/check_editname/{id}','OvertimePolicyController@checkotpolicyeditname');
Route::post('splitshift/check_addname','SplitshiftController@checkaddname');
Route::post('splitshift/check_editname/{id}','SplitshiftController@checkeditname');
Route::post('roster/viewemployee', 'RosterController@viewemployee');
Route::get('roster/pendingapprove/{id}', 'RosterController@pendingapprove');
Route::post('roster/edit-atten-actual-pending', 'RosterController@editattenactualpending');

Route::get('bonus', 'BonusController@index');
Route::get('bonus/add', 'BonusController@add');
Route::post('bonus/add', 'BonusController@store');
Route::get('bonus/edit/{id}', 'BonusController@edit');
Route::post('bonus/edit/{id}', 'BonusController@update');
Route::get('bonus/view/{id}', 'BonusController@view');
Route::get('bonus/delete/{id}', 'BonusController@delete');
Route::get('bonus/rating-remove/{id}', 'BonusController@removedelete');

//commission
Route::get('commission', 'CommissionController@index');
Route::get('commission/add', 'CommissionController@add');
Route::post('commission/add', 'CommissionController@store');
Route::get('commission/edit/{id}', 'CommissionController@edit');
Route::post('commission/edit/{id}', 'CommissionController@update');
Route::get('commission/view/{id}', 'CommissionController@view');
Route::get('commission/delete/{id}', 'CommissionController@delete');

/* Library */
Route::get('library/lib/', 'LibraryController@lib');
Route::get('library/libdelete/{id}','LibraryController@libdelete');
Route::get('library/download/{id}/{string}', 'LibraryController@download');
Route::get('library/lib/{id}', 'LibraryController@lib');
Route::get('library/add', 'LibraryController@index');
Route::get('library/add/{id}', 'LibraryController@adddoc');
Route::post('library/add/{id}', 'LibraryController@storedoc');
Route::post('library/add', 'LibraryController@storefolder');
Route::get('library/addfile', 'LibraryController@addfile');
Route::post('library/addfile', 'LibraryController@storefile');
Route::get('library/editfile/{id}', 'LibraryController@editfile');
Route::post('library/editfile/{id}', 'LibraryController@updatefile');
Route::get('library/latest-doc', 'LibraryController@folderlist');
Route::get('library/myfiles', 'LibraryController@myfiles');
Route::get('library/internal-ref', 'LibraryController@folderlevel');

Route::post('library/latest-doc', 'LibraryController@folderlist');
//Route::get('library/lib-fol-edit/{id}', 'LibraryController@editfile');
Route::get('library/lib-fol-delete/{id}', 'LibraryController@libfolderdelete');


//Employee Documentation configuration

Route::get('config/employee-documentation', 'LibraryController@add');
Route::get('library/type-add', 'LibraryController@addtype');
Route::post('library/type-add', 'LibraryController@typestore');
//Route::get('library/folder-add', 'LibraryController@libraryadd');
//Route::post('library/folder-add', 'LibraryController@librarystore');

Route::get('library/folder-add', 'LibraryController@library_folderadd');
Route::post('library/folder-add', 'LibraryController@library_folderstore');

Route::get('library/type-edit/{id}', 'LibraryController@edittype');
Route::post('library/type-edit/{id}', 'LibraryController@updatetype');
Route::get('library/type-delete/{id}', 'LibraryController@deletetype');
Route::get('library/library-folder', 'LibraryController@libraryadd');
Route::post('library/library-folder', 'LibraryController@librarystore');
Route::get('library/lib-folder-edit/{id}', 'LibraryController@libraryedit');
Route::post('library/lib-folder-edit/{id}', 'LibraryController@libraryupdate');
Route::get('library/lib-folder-delete/{id}', 'LibraryController@librarydelete');

//for Documents
Route::post('employee/addempdoc/{id}/{folid}', 'EmployeeController@storeEmpDoc');
Route::get('employee/deleteempdoc/{id}/{empid}/{folid}', 'EmployeeController@deleteEmpDoc');
Route::get('employee/add-employee/', 'EmployeeController@addEmployee');
Route::post('employee/add-employee/', 'EmployeeController@addEmployee');
Route::get('employee/edit-employee/{id}', 'EmployeeController@editEmployee');
Route::post('employee/edit-employee/{id}', 'EmployeeController@editEmployee');
Route::get('employee/view-employee/{id}', 'EmployeeController@viewEmployee');
Route::get('employee/view-employee/{id}/{folid}', 'EmployeeController@viewEmployee');
//Training - Roshimon

Route::get('training', 'TrainingController@index');
Route::post('training','TrainingController@index');

Route::get('training/download/{id}','TrainingController@download');


//sRoute::get('training/add', 'TrainingController@add');
Route::get('training/add','TrainingController@addNewTraining');
Route::post('training/add', 'TrainingController@store');

Route::get('training/register-view/{id}', 'TrainingController@registerView');
Route::post('training/register-view/{id}', 'TrainingController@registerView');

Route::post('training/register', 'TrainingController@regstore');

Route::post('training/userregister','TrainingController@userRegstore');
Route::get('training/userregister','TrainingController@userRegstore');

Route::post('training/userregister/{id}','TrainingController@userRegister');
Route::get('training/userregister/{id}','TrainingController@userRegister');

Route::post('training/approveall', 'TrainingController@approveall');

Route::post('employee/assign','EmployeeController@assignAll');

Route::get('training/edit/{id}', 'TrainingController@edit');
Route::get('training/view/{id}','TrainingController@view');
//Route::get('training/view/{id}','TrainingController@empview');
Route::get('training/my-view/{id}','TrainingController@myView');

Route::post('training/edit/{id}', 'TrainingController@update');

Route::post('training/close/{id}', 'TrainingController@close');
Route::get('training/close/{id}', 'TrainingController@close');

Route::get('training/approval/{id}', 'TrainingController@approval');
Route::post('training/approval/{id}', 'TrainingController@approval');

Route::get('training/approval-list', 'TrainingController@viewAllRegistrants');
Route::post('training/approval-list', 'TrainingController@viewAllRegistrants');

Route::get('training/approval-list/{id}', 'TrainingController@registrantApproval');
Route::get('training/rejection-list/{id}','TrainingController@registrantRejection');
Route::get('training/registrants/{id}','TrainingController@viewRegistrants');
Route::post('training/registrants/{id}','TrainingController@viewRegistrants');
Route::get('training/complete/{id}','TrainingController@trainingComplete');
//Route::get('training/add', 'TrainingController@addNewTraining');
//Route::post('training/add', 'TrainingController@addNewTraining');
//Route::get('training/setup-training', 'TrainingController@trainingAddData');

Route::get('training/approval-view/{id}','TrainingController@approvalView');

Route::get('training/my-training','TrainingController@myTraining');
Route::post('training/my-training','TrainingController@myTraining');

Route::get('training/bulk-register/{id}','TrainingController@bulkRegister');
Route::post('training/bulk-register/{id}','TrainingController@bulkRegister');

Route::get('test', 'TrainingController@test');

Route::get('training/training-register','TrainingController@getTrainingSummaryView');
Route::post('training/training-register','TrainingController@getTrainingSummaryView');

Route::get('training/training-approval', 'TrainingController@getTrainingApproval');
Route::post('training/training-approval', 'TrainingController@getTrainingApproval');

Route::get('training/training-details', 'TrainingController@getTrainingViewDetails');
Route::post('training/training-details', 'TrainingController@getTrainingViewDetails');

/*Performance Policy settings*/

Route::get('config/performance-policy', 'PerformancePolicyController@index');
Route::get('config/performance-policy/add', 'PerformancePolicyController@addPolicy');
Route::post('config/performance-policy/add', 'PerformancePolicyController@storePolicy');
Route::get('config/performance-policy/add-factor','PerformancePolicyController@addFactor');
Route::post('config/performance-policy/add-factor','PerformancePolicyController@storeFactor');

Route::get('config/performance-policy/edit/{id}', 'PerformancePolicyController@editPolicy');
Route::post('config/performance-policy/edit/{id}', 'PerformancePolicyController@updatePolicy');

Route::get('config/performance-policy/edit-factor/{id}', 'PerformancePolicyController@editFactor');
Route::post('config/performance-policy/edit-factor/{id}', 'PerformancePolicyController@updateFactor');
Route::get('config/performance-policy/delete-factor/{id}', 'PerformancePolicyController@deleteFactor');

Route::get('config/performance-policy/edit-policyfactor/{id}', 'PerformancePolicyController@editPolicyfactor');
Route::post('config/performance-policy/edit-policyfactor/{id}', 'PerformancePolicyController@updatePolicyfactor');
Route::get('config/performance-policy/delete/{id}', 'PerformancePolicyController@deletePolicy');

/*end of performance settings*/

//performance management
/*Route::get('performance_management','PerformanceController@index');
Route::get('performance_management/add', 'PerformanceController@add');
Route::post('performance_management/add', 'PerformanceController@store');
Route::get('performance_management/add_project', 'PerformanceController@add_project');
Route::post('performance_management/add_project', 'PerformanceController@store_project');
Route::get('performance_management/add_objective', 'PerformanceController@add_objective');
Route::post('performance_management/add_objective', 'PerformanceController@store_objective');
Route::get('performance_management/add_approve', 'PerformanceController@add_approve');
Route::post('performance_management/add_approve', 'PerformanceController@add_approve');
Route::get('performance_management/add_feedback', 'PerformanceController@add_feedback');
Route::post('performance_management/add_feedback', 'PerformanceController@add_feedback');*/


//performance management
Route::get('performance_management','PerformanceController@index');
Route::post('performance_management','PerformanceController@index');
Route::get('performance_management/add', 'PerformanceController@add');
Route::post('performance_management/add', 'PerformanceController@store');
Route::get('performance_management/add_project', 'PerformanceController@add_project');
Route::post('performance_management/add_project', 'PerformanceController@store_project');
Route::get('performance_management/add_objective', 'PerformanceController@add_objective');
Route::post('performance_management/add_objective', 'PerformanceController@store_objective');
Route::get('performance_management/add_approve', 'PerformanceController@add_approve');
Route::post('performance_management/add_approve', 'PerformanceController@add_approve');
Route::get('performance_management/add_feedback', 'PerformanceController@add_feedback');
Route::post('performance_management/add_feedback', 'PerformanceController@add_feedback');
Route::get('performance_management/add_selfassess', 'PerformanceController@add_selfassess');
Route::post('performance_management/add_selfassess', 'PerformanceController@add_selfassess');
Route::get('performance_management/add_reviewassess', 'PerformanceController@add_reviewassess');
Route::post('performance_management/add_reviewassess', 'PerformanceController@store_reviewassess');
Route::get('performance_management/add_finalproject', 'PerformanceController@add_finalproject');
Route::post('performance_management/add_finalproject', 'PerformanceController@store_finalproject');

//Route::get('performance_management/review_level/{id}', 'PerformanceController@key_reviewer');
Route::get('performance_management/reviewlevel/{id}', 'PerformanceController@reviewlevel');
Route::get('performance_management/otherkeyreviewer/{id}', 'PerformanceController@otherkeyreviewer');
Route::get('performance_management/otherkeyreviwersupervisor/{id}', 'PerformanceController@otherkeysupervisor');
Route::get('performance_management/otherkeyreviweremp/{id}', 'PerformanceController@otherkeyemp');

Route::get('performance_management/assignreviewer', 'PerformanceController@assignreviewer');
Route::post('performance_management/assignreviewer', 'PerformanceController@storereviewer');
Route::get('performance_management/approveobjective/{id}', 'PerformanceController@approve');
Route::post('performance_management/approveobjective/{id}', 'PerformanceController@storeapprove');

Route::get('performance_management/annual_final', 'PerformanceController@annual_final');
Route::post('performance_management/annual_final', 'PerformanceController@annual_final');
Route::get('performance_management/project_final', 'PerformanceController@project_final');
Route::post('performance_management/project_final', 'PerformanceController@project_final');
Route::get('performance_management/final_close', 'PerformanceController@final_close');
Route::post('performance_management/final_close', 'PerformanceController@final_close');

Route::get('performance_management/editobjective/{id}', 'PerformanceController@editobjective');
Route::post('performance_management/editobjective/{id}', 'PerformanceController@updateobjective');

Route::get('performance_management/editapprove/{id}', 'PerformanceController@editapprove');
Route::post('performance_management/editapprove/{id}', 'PerformanceController@updateapprove');
Route::get('performance_management/edit_selfassess/{id}', 'PerformanceController@edit_selfassess');
Route::post('performance_management/edit_selfassess/{id}', 'PerformanceController@update_selfassess');
Route::get('performance_management/edit_reviewassess/{id}', 'PerformanceController@edit_reviewassess');
Route::post('performance_management/edit_reviewassess/{id}', 'PerformanceController@update_reviewassess');
Route::get('performance_management/edit_annualfinal/{id}', 'PerformanceController@edit_annualfinal');
Route::post('performance_management/edit_annualfinal/{id}', 'PerformanceController@update_annualfinal');

Route::get('performance_management/delete/{id}', 'PerformanceController@delete');

Route::get('performance_management/finalise_close/{id}', 'PerformanceController@editfinaliseclose');
Route::post('performance_management/finalise_close/{id}', 'PerformanceController@finaliseclose');
Route::get('performance_management/finalise/{id}', 'PerformanceController@editfinalise');
Route::post('performance_management/finalise/{id}', 'PerformanceController@finalise');

Route::get('performance/sendback/{id}', 'PerformanceController@sendback');
Route::get('performance/employeesubmit/{id}', 'PerformanceController@EmployeeSubmit');
Route::get('performance/reviewersubmit/{id}', 'PerformanceController@ReviewerSubmit');
Route::get('performance/keyreviewer/{id}', 'PerformanceController@Keyreviewersubmit');

/*end of performance  management */


//Performance review
Route::get('employee/performance-review/{id}', 'EmployeeController@addEmpPerformance');
Route::get('employee/edit-performance-review/{empid}/{pfid}', 'EmployeeController@editEmpPerformance');
Route::get('employee/delete-performance-review/{empid}/{id}', 'EmployeeController@deleteEmpPerformance');
//Performance Goal
Route::get('employee/performance-goal/{id}', 'EmployeeController@addEmpPerformancegoal');
Route::get('employee/edit-performance-goal/{empid}/{pfid}', 'EmployeeController@editEmpPerformancegoals');
Route::get('employee/delete-performance-goal/{empid}/{id}', 'EmployeeController@deleteEmpPerformancegoals');
//for Performance review
Route::post('employee/storeperformance/{id}','EmployeeController@storeEmpPerformance');
Route::post('employee/storeperformance/{empid}/{id}','EmployeeController@updateEmpPerformance');
Route::post('employee/storeperformancegoals/{id}','EmployeeController@storeEmpPerformancegoals');
Route::post('employee/storeperformancegoals/{empid}/{id}','EmployeeController@updateEmpPerformancegoals');


//Payout Report
Route::get('payout-report', 'PayoutReportController@index');
Route::post('payout-report', 'PayoutReportController@index');
Route::get('payout-report/commission', 'PayoutReportController@commission');
Route::post('payout-report/commission', 'PayoutReportController@commission');
Route::get('payout-report/training', 'PayoutReportController@training');
Route::post('payout-report/training', 'PayoutReportController@training');
Route::get('payout-report/overtime', 'PayoutReportController@overtime');
Route::post('payout-report/overtime', 'PayoutReportController@overtime');
Route::get('reports/excel/bonus-report', 'ExcelController@BonusReportExcel');
Route::get('reports/bonus-report/pdf', 'ReportPdfController@BonusReportPdf');
Route::get('reports/excel/commission-report', 'ExcelController@CommissionReportExcel');
Route::get('reports/commission-report/pdf', 'ReportPdfController@CommissionReportPdf');
Route::get('reports/excel/training-report', 'ExcelController@TrainingReportExcel');
Route::get('reports/training-report/pdf', 'ReportPdfController@TrainingReportPdf');
Route::get('reports/excel/overtime-report', 'ExcelController@OvertimeReportExcel');
Route::get('reports/overtime-report/pdf', 'ReportPdfController@OvertimeReportPdf');

Route::get('payout-report/performance', 'PayoutReportController@performance');
Route::post('payout-report/performance', 'PayoutReportController@performance');
Route::get('reports/excel/performance-report', 'ExcelController@PerformanceReportExcel');
Route::get('reports/performance-report/pdf', 'ReportPdfController@PerformanceReportPdf');


Route::get('reports/training-registrants-report/pdf/{id}', 'ReportPdfController@TrainingRegistrantsReportPdf');

?>
