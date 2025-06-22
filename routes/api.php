<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProgramController;


use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UniCampusController;
use App\Http\Controllers\UniIntakeController;
use App\Http\Controllers\UniLanguageController;
use App\Http\Controllers\UniProgramController;

use App\Http\Controllers\UniCourseController;

use App\Http\Controllers\StatusGroupController;
use App\Http\Controllers\StatusNameController;
use App\Http\Controllers\AppliedviaController;


use App\Http\Controllers\RegionController;
use App\Http\Controllers\BranchController;

use App\Http\Controllers\ConsultantController;

use App\Http\Controllers\RoleRightController;


use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UniversityAgentAssignmentController;


use App\Http\Controllers\LeadUploadController;

use App\Http\Controllers\LeadController;

use App\Http\Controllers\ApplicationController;

use App\Http\Controllers\AppDocumentController;
use App\Http\Controllers\AppAcademicController;
use App\Http\Controllers\AppDepositController;
use App\Http\Controllers\AppLanguageController;
use App\Http\Controllers\AppTrainingController;
use App\Http\Controllers\AppWorkingController;
use App\Http\Controllers\LeadDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('get-lead-application/{id}', [ApplicationController::class, 'getApplicationData']);
    Route::get('country-list', [CountryController::class, 'getCountryList']);

});
// Route::get('university-details', [UniversityController::class, 'universityDetails']);


Route::prefix('v1')->middleware('verify.cookie')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Country start
    |--------------------------------------------------------------------------
    */
    Route::get('country-index', [CountryController::class, 'indexCountry']);
    Route::post('country-insert', [CountryController::class, 'storeCountry']);
    Route::put('country-update/{id}', [CountryController::class, 'updateCountry']);
    Route::delete('country-destroy/{id}', [CountryController::class, 'destroyCountry']);


    /*
    |--------------------------------------------------------------------------
    | State start
    |--------------------------------------------------------------------------
    */
    Route::get('state-index', [StateController::class, 'indexState']);
    Route::post('state-insert', [StateController::class, 'storeState']);
    Route::put('state-update/{id}', [StateController::class, 'updateState']);
    Route::delete('state-destroy/{id}', [StateController::class, 'destroyState']);
    Route::get('get-state-by-Country', [StateController::class, 'getStateByCountry']);
    Route::get('get-city-by-state', [StateController::class, 'getCityByState']);


    /*
    |--------------------------------------------------------------------------
    | City start
    |--------------------------------------------------------------------------
    */
    Route::get('city-index', [CityController::class, 'indexCity']);
    Route::post('city-insert', [CityController::class, 'storeCity']);
    Route::put('city-update/{id}', [CityController::class, 'updateCity']);
    Route::delete('city-destroy/{id}', [CityController::class, 'destroyCity']);

    /*
    |--------------------------------------------------------------------------
    | Language start
    |--------------------------------------------------------------------------
    */
    Route::get('language-index', [LanguageController::class, 'indexLanguage']);
    Route::post('language-insert', [LanguageController::class, 'storeLanguage']);
    Route::put('language-update/{id}', [LanguageController::class, 'updateLanguage']);
    Route::delete('language-destroy/{id}', [LanguageController::class, 'destroyLanguage']);


    /*
    |--------------------------------------------------------------------------
    | Program start
    |--------------------------------------------------------------------------
    */
    Route::get('program-index', [ProgramController::class, 'indexProgram']);
    Route::post('program-insert', [ProgramController::class, 'storeProgram']);
    Route::put('program-update/{id}', [ProgramController::class, 'updateProgram']);
    Route::delete('program-destroy/{id}', [ProgramController::class, 'destroyProgram']);


    /*
    |--------------------------------------------------------------------------
    | University start
    |--------------------------------------------------------------------------
    */
    Route::get('university-index', [UniversityController::class, 'indexUniversity']);
    Route::get('university-details', [UniversityController::class, 'universityDetails']);
    Route::post('university-insert', [UniversityController::class, 'storeUniversity']);
    Route::post('university-update/{id}', [UniversityController::class, 'updateUniversity']);
    Route::delete('university-destroy/{id}', [UniversityController::class, 'destroyUniversity']);


    /*
    |--------------------------------------------------------------------------
    | Uni campus start
    |--------------------------------------------------------------------------
    */
    Route::get('uni-campus-index', [UniCampusController::class, 'indexUniCampus']);
    Route::post('uni-campus-insert', [UniCampusController::class, 'storeUniCampus']);
    Route::put('uni-campus-update/{id}', [UniCampusController::class, 'updateUniCampus']);
    Route::delete('uni-campus-destroy/{id}', [UniCampusController::class, 'destroyUniCampus']);


    /*
    |--------------------------------------------------------------------------
    | Uni intake start
    |--------------------------------------------------------------------------
    */
    Route::get('uni-intake-index', [UniIntakeController::class, 'indexUniIntake']);
    Route::post('uni-intake-insert', [UniIntakeController::class, 'storeUniIntake']);
    Route::put('uni-intake-update/{id}', [UniIntakeController::class, 'updateUniIntake']);
    Route::delete('uni-intake-destroy/{id}', [UniIntakeController::class, 'destroyUniIntake']);


    /*
    |--------------------------------------------------------------------------
    | Uni language start
    |--------------------------------------------------------------------------
    */
    Route::get('uni-language-index', [UniLanguageController::class, 'indexUniLanguage']);
    Route::post('uni-language-insert', [UniLanguageController::class, 'storeUniLanguage']);
    Route::put('uni-language-update/{id}', [UniLanguageController::class, 'updateUniLanguage']);
    Route::delete('uni-language-destroy/{id}', [UniLanguageController::class, 'destroyUniLanguage']);


    /*
    |--------------------------------------------------------------------------
    | Uni program start
    |--------------------------------------------------------------------------
    */
    Route::get('uni-program-index', [UniProgramController::class, 'indexUniProgram']);
    Route::post('uni-program-insert', [UniProgramController::class, 'storeUniProgram']);
    Route::put('uni-program-update/{id}', [UniProgramController::class, 'updateUniProgram']);
    Route::delete('uni-program-destroy/{id}', [UniProgramController::class, 'destroyUniProgram']);


    /*
    |--------------------------------------------------------------------------
    | Uni course start
    |--------------------------------------------------------------------------
    */
    Route::get('uni-course-index', [UniCourseController::class, 'indexUniCourse']);
    Route::post('uni-course-insert', [UniCourseController::class, 'storeUniCourse']);
    Route::put('uni-course-update/{id}', [UniCourseController::class, 'updateUniCourse']);
    Route::delete('uni-course-destroy/{id}', [UniCourseController::class, 'destroyUniCourse']);


    /*
    |--------------------------------------------------------------------------
    | Branch start
    |--------------------------------------------------------------------------
    */
    Route::get('branch-index', [BranchController::class, 'indexBranch']);
    Route::post('branch-insert', [BranchController::class, 'storeBranch']);
    Route::put('branch-update/{id}', [BranchController::class, 'updateBranch']);
    Route::delete('branch-destroy/{id}', [BranchController::class, 'destroyBranch']);



    /*
    |--------------------------------------------------------------------------
    | status start
    |--------------------------------------------------------------------------
    */

    Route::get('status-group-index', [StatusGroupController::class, 'indexStatusGroup']);
    Route::post('status-group-insert', [StatusGroupController::class, 'storeStatusGroup']);
    Route::put('status-group-update/{id}', [StatusGroupController::class, 'updateStatusGroup']);
    Route::delete('status-group-destroy/{id}', [StatusGroupController::class, 'destroyStatusGroup']);


    Route::get('status-name-index', [StatusNameController::class, 'indexStatusName']);
    Route::get('status-list-with-role', [StatusNameController::class, 'getStatusName']);
    Route::post('status-name-insert', [StatusNameController::class, 'storeStatusName']);
    Route::put('status-name-update/{id}', [StatusNameController::class, 'updateStatusName']);
    Route::delete('status-name-destroy/{id}', [StatusNameController::class, 'destroyStatusName']);

    /*
    |--------------------------------------------------------------------------
    | applied via
    |--------------------------------------------------------------------------
    */
    Route::get('appliedvia-index', [AppliedviaController::class, 'indexAppliedvia']);
    Route::post('appliedvia-insert', [AppliedviaController::class, 'storeAppliedvia']);
    Route::put('appliedvia-update/{id}', [AppliedviaController::class, 'updateAppliedvia']);
    Route::delete('appliedvia-destroy/{id}', [AppliedviaController::class, 'destroyAppliedvia']);


    /*
    |--------------------------------------------------------------------------
    | User start
    |--------------------------------------------------------------------------
    */
    Route::get('user-index', [UserController::class, 'indexUser']);
    Route::post('user-insert', [UserController::class, 'storeUser']);
    Route::put('user-update/{id}', [UserController::class, 'updateUser']);
    Route::delete('user-destroy/{id}', [UserController::class, 'destroyUser']);


    /*
    |--------------------------------------------------------------------------
    | TodoList start
    |--------------------------------------------------------------------------
    */
    Route::get('todolist-index', [TodoListController::class, 'indexTodoList']);
    Route::post('todolist-insert', [TodoListController::class, 'storeTodoList']);
    Route::put('todolist-update/{id}', [TodoListController::class, 'updateTodoList']);
    Route::delete('todolist-destroy/{id}', [TodoListController::class, 'destroyTodoList']);

    /*
    |--------------------------------------------------------------------------
    | UniversityAgentAssignmentController start
    |--------------------------------------------------------------------------
    */

    Route::get('university-agent-assignment-index', [UniversityAgentAssignmentController::class, 'indexUAAssignment']);
    Route::post('university-agent-assignment-insert', [UniversityAgentAssignmentController::class, 'storeUAAssignment']);
    Route::delete('university-agent-assignment-destroy/{id}', [UniversityAgentAssignmentController::class, 'destroyUAAssignment']);


    /*
    |--------------------------------------------------------------------------
    | Lead upload start
    |--------------------------------------------------------------------------
    */
    Route::get('leadupload-index', [LeadUploadController::class, 'indexLeadUpload']);
    Route::post('leadupload-insert', [LeadUploadController::class, 'storeLeadUpload']);
    Route::put('leadupload-update/{id}', [LeadUploadController::class, 'updateLeadUpload']);
    Route::delete('leadupload-destroy/{id}', [LeadUploadController::class, 'destroyLeadUpload']);

    Route::get('leadassign-update', [LeadUploadController::class, 'indexLeadAssign']);

    /*
    |--------------------------------------------------------------------------
    | Lead  start
    |--------------------------------------------------------------------------
    */
    Route::get('lead-index', [LeadController::class, 'indexLead']);
    Route::get('lead-add-data', [LeadController::class, 'leadAdditionalData']);
    Route::post('lead-insert', [LeadController::class, 'storeLead']);
    Route::put('lead-update/{id}', [LeadController::class, 'updateLead']);
    Route::put('lead-add-data-update', [LeadController::class, 'updateLeads']);
    Route::delete('lead-destroy/{id}', [LeadController::class, 'destroyLead']);

    Route::get('lead-index-admission', [LeadController::class, 'indexLeadAdmission']);
    Route::get('admission-add-data', [LeadController::class, 'admissionAdditionalData']);
    Route::put('update-application-data/{id}', [LeadController::class, 'updateLeadsApplicationData']);


    //lead personal
    Route::post('lead-personal-info-update/{id}', [LeadController::class, 'updateLeadPersonalInfo']);
    Route::get('lead-single-data/{id}', [LeadController::class, 'getLeadSingleData']);
    Route::post('lead-passport-update/{id}', [LeadController::class, 'updateLeadPassportInfo']);

    //lead document
    Route::get('get-lead-document/{id}', [LeadDataController::class, 'leadDocumentData']);
    Route::post('lead-document-update/{id}', [LeadDataController::class, 'updateLeadDocument']);

    //lead university
    Route::get('country-wise-university/{id}', [LeadDataController::class, 'getCountryWiseUniversity']);
    Route::get('university-wise-data/{id}', [LeadDataController::class, 'getUniversityWiseData']);
    Route::get('course-wise-data/{id}', [LeadDataController::class, 'getUniversityCourse']);

    //lead application
    Route::post('store-lead-application', [ApplicationController::class, 'storeIndex']);
    Route::get('get-lead-application/{id}', [ApplicationController::class, 'getApplicationData']);


    /*
    |--------------------------------------------------------------------------
    | ApplicationController start
    |--------------------------------------------------------------------------
    */
    Route::get('application-index', [ApplicationController::class, 'indexApplication']);
    Route::post('application-insert', [ApplicationController::class, 'storeApplication']);
    Route::put('application-update/{id}', [ApplicationController::class, 'updateApplication']);
    Route::delete('application-destroy/{id}', [ApplicationController::class, 'destroyApplication']);



    Route::post('asian-lead-user', [LeadController::class, 'assignLeadToUser']);



    Route::post('asian-lead-user', [LeadController::class, 'assignLeadToUser']);



    Route::post('asian-lead-user', [LeadController::class, 'assignLeadToUser']);


    /*
    |--------------------------------------------------------------------------
    | AppDocumentController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-document-index', [AppDocumentController::class, 'indexAppDocument']);
    Route::post('app-document-insert', [AppDocumentController::class, 'storeAppDocument']);
    Route::put('app-document-update/{id}', [AppDocumentController::class, 'updateAppDocument']);
    Route::delete('app-document-destroy/{id}', [AppDocumentController::class, 'destroyAppDocument']);


    /*
    |--------------------------------------------------------------------------
    | AppDepositController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-deposit-index', [AppDepositController::class, 'indexAppDeposit']);
    Route::post('app-deposit-insert', [AppDepositController::class, 'storeAppDeposit']);
    Route::put('app-deposit-update/{id}', [AppDepositController::class, 'updateAppDeposit']);
    Route::delete('app-deposit-destroy/{id}', [AppDepositController::class, 'destroyAppDeposit']);

    /*
    |--------------------------------------------------------------------------
    | AppDepositController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-academic-index', [AppAcademicController::class, 'indexAppAcademic']);
    Route::post('app-academic-insert', [AppAcademicController::class, 'storeAppAcademic']);
    Route::post('app-academic-update/{id}', [AppAcademicController::class, 'updateAppAcademic']);
    Route::delete('app-academic-destroy/{id}', [AppAcademicController::class, 'destroyAppAcademic']);



    /*
    |--------------------------------------------------------------------------
    | AppLanguageController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-language-index', [AppLanguageController::class, 'indexAppLanguage']);
    Route::post('app-language-insert', [AppLanguageController::class, 'storeAppLanguage']);
    Route::post('app-language-update/{id}', [AppLanguageController::class, 'updateAppLanguage']);
    Route::delete('app-language-destroy/{id}', [AppLanguageController::class, 'destroyAppLanguage']);


    /*
    |--------------------------------------------------------------------------
    | AppTraningController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-training-index', [AppTrainingController::class, 'indexAppTraining']);
    Route::post('app-training-insert', [AppTrainingController::class, 'storeAppTraining']);
    Route::post('app-training-update/{id}', [AppTrainingController::class, 'updateAppTraining']);
    Route::delete('app-training-destroy/{id}', [AppTrainingController::class, 'destroyAppTraining']);


    /*
    |--------------------------------------------------------------------------
    | AppWorkingController start
    |--------------------------------------------------------------------------
    */
    Route::get('app-working-index', [AppWorkingController::class, 'indexAppWorking']);
    Route::post('app-working-insert', [AppWorkingController::class, 'storeAppWorking']);
    Route::post('app-working-update/{id}', [AppWorkingController::class, 'updateAppWorking']);
    Route::delete('app-working-destroy/{id}', [AppWorkingController::class, 'destroyAppWorking']);

    Route::get('user-index', [UserController::class, 'indexUser']);
    Route::post('user-insert', [UserController::class, 'storeUser']);
    Route::put('user-update/{id}', [UserController::class, 'updateUser']);
    Route::delete('user-destroy/{id}', [UserController::class, 'destroyUser']);
    Route::get('get-user-by-role/{id}', [UserController::class, 'getUserByRole']);



    // branch manager
    Route::get('branch-manager-index', [BranchController::class, 'getBranchWithManager']);
    Route::post('branch-manager-store', [BranchController::class, 'storeNewManager']);
    Route::put('branch-manager-update/{id}', [BranchController::class, 'updateBranchManager']);

    /*
    |--------------------------------------------------------------------------
    | agent manager start
    |--------------------------------------------------------------------------
    */

    Route::get('agents-manager-index', [AgentController::class, 'getAgent']);
    Route::put('agents-manager-update/{id}', [AgentController::class, 'updateAgent']);

    /*
    |--------------------------------------------------------------------------
    | ConsultantAssign manager start
    |--------------------------------------------------------------------------
    */

    Route::get('consultant-branch-index', [ConsultantController::class, 'getConsultant']);
    Route::put('consultant-branch-update/{id}', [ConsultantController::class, 'updateConsultant']);


    /*
    |--------------------------------------------------------------------------
    | role start
    |--------------------------------------------------------------------------
    */
    Route::prefix('role-right')->group(function () {
        Route::get('/get-role', [RoleRightController::class, 'index']);
        Route::post('/store-role', [RoleRightController::class, 'storeRole']);
        Route::put('/update-role/{id}', [RoleRightController::class, 'updateRole']);
        Route::delete('/delete-role/{id}', [RoleRightController::class, 'deleteRole']);


        Route::get('/get-right', [RoleRightController::class, 'indexRight']);
        Route::post('/store-right', [RoleRightController::class, 'storeRight']);
        Route::put('/update-right/{id}', [RoleRightController::class, 'updateRight']);
        Route::delete('/delete-right/{id}', [RoleRightController::class, 'deleteRight']);

        Route::get('/get-role-right', [RoleRightController::class, 'indexRoleRight']);
        Route::get('/specific-role-right', [RoleRightController::class, 'specificRoleRight']);
        Route::post('/update-role-right', [RoleRightController::class, 'updateRoleRights']);
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'])->cookie('auth_token', '', -1, '/', 'localhost', true, true);
    });
});
