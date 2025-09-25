<?php

//guest

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ApplicantAccountController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatatableController;
use App\Http\Controllers\Admin\DiscController;
use App\Http\Controllers\Admin\HandleImageController;
use App\Http\Controllers\Admin\IqController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GuestController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\GuestAuth;
use App\Jobs\SubmitJob;
use App\PersonalData;

Route::get('/', function () {
    return redirect()->route('guest-login');
});

Route::controller(GuestController::class)->group(function () {
    Route::get('login', 'login')->name('guest-login');
    Route::post('post-login', 'postLogin')->name('guest-post-login');
    Route::get('change-lang', 'changeLang')->name('guest-change-lang');
});

Route::controller(MainController::class)->group(function () {
    Route::post('create-or-update-career', 'createOrUpdateCareer');
});

Route::get('template', function () {
    $data = PersonalData::where('id', 406)->first();
    return dispatch(new SubmitJob('Thank You For Your Application', 'thank-you', $data));
    return view('thank-you', compact('data'));
});

Route::middleware(GuestAuth::class)->group(function () {
    Route::controller(ApplicantController::class)->group(function () {
        Route::get('home', 'home')->name('guest-home');
        Route::get('personal-data', 'personalData')->name('guest-personal-data');
        Route::post('save-personal-data/{id}/{part}', 'savePersonalData')->name('guest-save-personal-data');
        Route::post('confirmation-submit/{id}', 'confirmationSubmit')->name('guest-confirmation-submit');
        Route::get('complete-personal-data', 'completePersonalData')->name('guest-complete-personal-data');
        Route::get('detail-personal-data', 'detailPersonalData')->name('guest-detail-personal-data');
        Route::get('intro-disc', 'introDisc')->name('guest-intro-disc');
        Route::get('disc', 'disc')->name('guest-disc');
        Route::post('save-disc', 'saveDisc')->name('guest-save-disc');
        Route::get('intro-iq', 'introIq')->name('guest-intro-iq');
        Route::get('iq', 'iq')->name('guest-iq');
        Route::post('save-iq', 'saveIq')->name('guest-save-iq');
        Route::get('complete-test', 'completeTest')->name('guest-complete-test');

        Route::post('time-diff', 'timeDiff')->name('time-diff');
    });

    Route::controller(GuestController::class)->group(function () {
        Route::get('logout', 'logout')->name('guest-logout');
    });
});

Route::controller(GuestController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::get('check-data-registration', 'checkDataRegistration')->name('check-data-registration');
    Route::get('check-nik', 'checkNik')->name('check-nik');
    Route::post('get-personal-register', 'register')->name('get-personal-register');
    Route::post('register', 'saveRegister')->name('save-register');
    Route::get('thanks', 'thankYouPage')->name('thank-you-page');
});

//admin
Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'auth');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'postLogin')->name('post-login');
        Route::get('resets-password', 'sendEmailPassword')->name('send-email-pass');
        Route::get('password/reset/{token}', 'resetPassword')->name('password.reset');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::post('password/reset', 'reset')->name('post.password.reset');
    });
});

Route::controller(DatatableController::class)->group(function () {
    Route::post('get-data', 'getData')->name('get-data');
});

Route::middleware(AdminAuth::class)->prefix('admin')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'homeAdmin')->name('admin');
    });

    Route::controller(MasterController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('load-status-employee', 'loadStatusEmploye')->name('load-status-employee');
        Route::get('load-position-employee', 'loadPositionEmployee')->name('load-position-employee');
    });

    Route::controller(LogController::class)->group(function () {
        Route::get('log', 'log')->name('log');
        Route::post('get-data', 'getData')->name('log-datatable');
    });

    Route::controller(MediaController::class)->group(function () {
        Route::post('get-modal-media/{type}', 'getModalMedia')->name('get-modal-media');
    });

    Route::prefix('setting')->group(function () {
        Route::controller(MasterController::class)->group(function () {
            Route::get('description-site', 'descSite')->name('desc-site');
            Route::get('multi-lang', 'multiLang')->name('multi-lang');

            Route::post('save/{type}', 'descSiteSave')->name('desc-site-save');
            Route::post('save-multi-lang', 'multiLangSave')->name('multi-lang-save');

            Route::get('profil', 'profil')->name('profil');
            Route::post('profil/save', 'profilSave')->name('profil-save');
            Route::post('change-password', 'changePassword')->name('change-password');

            Route::get('import-excel', 'importExcel')->name('import-excel');
            Route::post('import-excel/save', 'importExcelSave')->name('import-excel-save');
        });

        Route::controller(MainController::class)->group(function () {
            Route::get('general', 'setGeneral')->name('set-general');
        });

        Route::controller(HandleImageController::class)->prefix('handle_image')->group(function () {
            Route::get('/', 'handleImage')->name('handle_image');
            Route::post('get-data', 'getData')->name('handle_image-datatable');
            Route::get('entry/{id?}', 'getDataFirst')->name('handle_image-entry');
            Route::post('save/{id}', 'saveData')->name('handle_image-save');
            Route::post('delete/{id}', 'deleteData')->name('handle_image-delete');
            Route::post('multi-delete', 'deleteMulti')->name('handle_image-multi_delete');
            Route::get('/trace/{id}', 'trace')->name('handle_image-trace');
        });
    });

    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('/', 'role')->name('role');
        Route::post('get-data', 'getData')->name('role-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('role-entry');
        Route::post('save/{id}', 'saveData')->name('role-save');
        Route::post('delete/{id}', 'deleteData')->name('role-delete');
        Route::post('multi-delete', 'deleteMulti')->name('role-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('role-trace');
    });

    Route::controller(MediaController::class)->prefix('library')->group(function () {
        Route::get('image', 'mediaLibrary')->name('image');
        Route::get('video', 'mediaLibrary')->name('video');
        Route::get('file', 'mediaLibrary')->name('application');
        Route::get('audio', 'mediaLibrary')->name('audio');
        Route::post('save/{type}/{trigger?}', 'mediaLibrarySave')->name('media-library-save');
        Route::post('delete/{type}/{id}', 'mediaDelete')->name('media-library-delete');
        Route::post('multi/{type}', 'mediaMultiDelete')->name('media-library-multi-delete');
    });

    Route::controller(AccountController::class)->prefix('account')->group(function () {
        Route::get('/', 'account')->name('account');
        Route::post('get-data', 'getData')->name('account-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('account-entry');
        Route::post('save/{id}', 'saveData')->name('account-save');
        Route::post('delete/{id}', 'deleteData')->name('account-delete');
        Route::post('multi-delete', 'deleteMulti')->name('account-multi-delete');
        Route::get('autocomplete', 'autocomplete')->name('account-autocomplete');
        Route::get('reset/{id}', 'reset')->name('account-reset');
        Route::get('/trace/{id}', 'trace')->name('account-trace');
    });

    Route::controller(PositionController::class)->prefix('position')->group(function () {
        Route::get('/', 'position')->name('position');
        Route::post('get-data', 'getData')->name('position-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('position-entry');
        Route::post('save/{id}', 'saveData')->name('position-save');
        Route::post('delete/{id}', 'deleteData')->name('position-delete');
        Route::post('multi-delete', 'deleteMulti')->name('position-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('position-trace');
    });

    Route::controller(DiscController::class)->prefix('disc')->group(function () {
        Route::get('/', 'disc')->name('disc');
        Route::post('get-data', 'getData')->name('disc-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('disc-entry');
        Route::post('save/{id}', 'saveData')->name('disc-save');
        Route::post('delete/{id}', 'deleteData')->name('disc-delete');
        Route::post('multi-delete', 'deleteMulti')->name('disc-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('disc-trace');
    });

    Route::controller(IqController::class)->prefix('iq')->group(function () {
        Route::get('/', 'iq')->name('iq');
        Route::post('get-data', 'getData')->name('iq-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('iq-entry');
        Route::post('save/{id}', 'saveData')->name('iq-save');
        Route::post('delete/{id}', 'deleteData')->name('iq-delete');
        Route::post('multi-delete', 'deleteMulti')->name('iq-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('iq-trace');
    });

    Route::controller(CareerController::class)->prefix('career')->group(function () {
        Route::get('/', 'career')->name('career');
        Route::post('get-data', 'getData')->name('career-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('career-entry');
        Route::post('save/{id}', 'saveData')->name('career-save');
        Route::post('delete/{id}', 'deleteData')->name('career-delete');
        Route::post('multi-delete', 'deleteMulti')->name('career-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('career-trace');
    });

    Route::controller(AdminApplicantController::class)->prefix('applicant')->group(function () {
        Route::get('/', 'applicant')->name('applicant');
        Route::post('get-data', 'getData')->name('applicant-datatable');
        Route::get('/export', 'exportExcel')->name('applicant-export-excel');
        Route::get('entry/{id?}', 'getDataFirst')->name('applicant-entry');
        Route::post('save/{id}', 'saveData')->name('applicant-save');
        Route::post('delete/{id}', 'deleteData')->name('applicant-delete');
        Route::post('multi-delete', 'deleteMulti')->name('applicant-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('applicant-trace');
        Route::get('print-personal-data/{id}', 'printPersonalData')->name('applicant-print-personal-data');
        Route::get('print-personal-data2/{id}', 'printPersonalData2')->name('applicant-print-personal-data2');
        Route::get('print-disc/{id}', 'printDisc')->name('applicant-print-disc');
        Route::get('print-iq/{id}', 'printIq')->name('applicant-print-iq');
        Route::get('create-email/{id}', 'createEmail')->name('applicant-create-email');
        Route::get('email-test/{id}', 'kirimEmailOnlineTest')->name('applicant-email-test');
        Route::get('update-status/{id}/{typeStatus}', 'updateStatusKaryawan')->name('applicant-update-status');
        Route::get('entry-result-test/{id}/{typeStatus}', 'interviewTestResultView')->name('applicant-entry-result');
        Route::post('entry-result-test/{id}/{typeStatus}', 'interviewTestResultView')->name('applicant-entry-result');
        Route::post('cancel-recruitment', 'cancelRecruitment')->name('cancel-recruitment');
        Route::get('accept-applicant/{id}', 'acceptApplicant')->name('accept-applicant');
        Route::get('history/{id}', 'historyApplicant')->name('applicant-history');
        Route::post('change-status-group', 'changeStatusGroup')->name('applicant-change-status-group');
        Route::get('get-careers', 'getCareers')->name('applicant-get-careers');
        Route::post('save-change-careers/{id}', 'saveChangeCareers')->name('applicant-save-change-careers');
        Route::post('save-change-email/{id}', 'saveChangeEmail')->name('applicant-save-change-email');
    });

    Route::controller(ApplicantAccountController::class)->prefix('applicant-account')->group(function () {
        Route::get('/', 'applicantAccount')->name('applicant_account');
        Route::post('get-data', 'getData')->name('applicant_account-datatable');
        Route::get('entry/{id?}', 'getDataFirst')->name('applicant_account-entry');
        Route::post('save/{id}', 'saveData')->name('applicant_account-save');
        Route::post('delete/{id}', 'deleteData')->name('applicant_account-delete');
        Route::post('multi-delete', 'deleteMulti')->name('applicant_account-multi-delete');
        Route::get('/trace/{id}', 'trace')->name('applicant_account-trace');
        Route::get('reset/{id}', 'reset')->name('applicant_account-reset');
    });

});
