<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\Auth\LoginController;
//use App\Http\Controllers\Admin\LogicController;
//use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManageDepositController;
use App\Http\Controllers\Admin\ManageWithdrawalController;
use App\Http\Controllers\Admin\InvPlanController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\Settings\AppSettingsController;
use App\Http\Controllers\Admin\Settings\ReferralSettings;
use App\Http\Controllers\Admin\Settings\PaymentController;
use App\Http\Controllers\Admin\Settings\SubscriptionSettings;
use App\Http\Controllers\Admin\IpaddressController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Http\Controllers\Admin\ClearCacheController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\ManageAssetController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\SignalProvderController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\TradingAccountController;
use App\Http\Controllers\Admin\DemoRequestController;
use App\Http\Controllers\Admin\SecondAccountRequestController;
use App\Http\Controllers\Admin\AccountsImportController;
use Illuminate\Support\Facades\Route;

Route::post('/admin/user/add-second-account', [ManageUsersController::class, 'addSecondAccount'])
    ->name('admin.user.addSecondAccount');
Route::post('/admin/user/add-second-accountdep', [ManageDepositController::class, 'adddeposit'])
    ->name('admin.user.addSecondAccountdep');

Route::prefix('adminlogin')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('adminloginform')->middleware('adminguest');
        Route::post('login', 'adminlogin')->name('adminlogin');
        Route::post('logout', 'adminlogout')->name('adminlogout');
        Route::get('dashboard', 'validate_admin')->name('validate_admin');
    });
});
Route::controller(TwoFactorController::class)->group(function () {
    // Two Factor controller for Admin.
    Route::get('admin/2fa', 'showTwoFactorForm')->name('2fa');
    Route::post('admin/twofa', 'verifyTwoFactor')->name('twofalogin');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('admin/forgot-password', 'forgotPassword')->name('admin.forgetpassword');
    Route::post('admin/send-request', 'sendPasswordRequest')->name('sendpasswordrequest');
    Route::get('/admin/reset-password/{email}', 'resetPassword')->name('resetview');
    Route::post('/reset-password-admin', 'validateResetPasswordToken')->name('restpass');
});


Route::middleware(['isadmin', '2fa'])->prefix('admin/dashboard')->group(function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'index')->name('admin.dashboard');
        Route::get('plans', 'plans')->name('plans');
        Route::get('new-plan', 'newplan')->name('newplan');
        Route::get('edit-plan/{id}', 'editplan')->name('editplan');
        Route::get('manageusers', 'manageusers')->name('manageusers');
        Route::get('manage-crypto-assets', 'managecryptoasset')->name('managecryptoasset');
        Route::get('active-investments', 'activeInvestments')->name('activeinvestments');
       
        // CRM ROUTES
        Route::get('calendar', 'calendar')->name('calendar');
        Route::get('task', 'showtaskpage')->name('task');
        Route::get('mtask', 'mtask')->name('mtask');
        Route::get('viewtask', 'viewtask')->name('viewtask');
        Route::get('customer', 'customer')->name('customer');
        Route::get('leads', 'leads')->name('leads');
        Route::get('leadsassign', 'customer')->name('leadsassign');
        Route::get('user-plans/{id}',  'userplans')->name('user.plans');
        Route::get('email-services',  'emailServices')->name('emailservices');
        Route::get('platform',  'aboutonlinetrade')->name('aboutonlinetrade');
        Route::get('mwithdrawals', 'mwithdrawals')->name('mwithdrawals');
        Route::get('manage-deposits', 'mdeposits')->name('mdeposits');
        Route::get('agents',  'agents')->name('agents');
        Route::get('addmanager', 'addmanager')->name('addmanager');
        Route::get('madmin', 'madmin')->name('madmin');
        Route::get('msubtrade', 'msubtrade')->name('msubtrade');
        Route::get('settings', 'settings')->name('settings');
        Route::get('frontpage', 'frontpage')->name('frontpage');
        Route::get('adduser', 'adduser')->name('adduser');
        // KYC Routes
        Route::get('kyc-applications', 'kyc')->name('kyc');
        Route::get('kyc-application/{id}', 'viewKycApplication')->name('viewkyc');
        Route::get('adminprofile', 'adminprofile')->name('adminprofile');
    });

    Route::controller(KycController::class)->group(function () {
        Route::post('processkyc', 'processKyc')->name('processkyc');
    });

    Route::controller(CrmController::class)->group(function () {
        Route::post('addtask', 'addtask')->name('addtask');
        Route::post('updatetask', 'updatetask')->name('updatetask');
        Route::get('deltask/{id}', 'deltask')->name('deltask');
        Route::get('markdone/{id}', 'markdone')->name('markdone');
        Route::post('updateuser', 'updateuser')->name('updateuser');
        Route::get('convert/{id}', 'convert')->name('convert');
        Route::post('assign', 'assign')->name('assignuser');
    });

    Route::controller(ManageUsersController::class)->group(function () {
        Route::get('user-wallet/{id}', 'userwallet')->name('user.wallet');
        Route::get('fetchusers', 'fetchUsers')->name('fetchusers');
        Route::get('referrals-overview', 'referralsOverview')->name('admin.referrals.overview');
        Route::post('sendmailsingle', 'sendmailtooneuser')->name('sendmailtooneuser');
        Route::post('AddHistory', 'addHistory')->name('addhistory');
        Route::post('edituser', 'edituser')->name('edituser');
        Route::get('getusers/{num}/{item}/{order}', 'getusers')->name('getusers');
        Route::get('resetpswd/{id}', 'resetpswd')->name('resetpswd');
        Route::get('login-activity/{id}', 'loginactivity')->name('loginactivity');
        Route::get('clear-activity/{id}', 'clearactivity')->name('clearactivity');
        Route::get('add-referral/{id}', 'showUsers')->name('showusers');
        Route::post('add-referral', 'addReferral')->name('addref');
        Route::get('switchuser/{id}', 'switchuser');
        Route::get('clearacct/{id}', 'clearacct')->name('clearacct');
        Route::post('saveuser', 'saveuser')->name('createuser');
        Route::get('user-details/{id}', 'viewuser')->name('viewuser');
        Route::get('email-verify/{id}', 'emailverify')->name('emailverify');
        Route::get('uublock/{id}', 'ublock');
        Route::get('uunblock/{id}', 'unblock');
        Route::get('delsystemuser/{id}', 'delsystemuser');
        Route::get('usertrademode/{id}/{action}', 'usertrademode');
        Route::post('sendmailtoall', 'sendmailtoall')->name('sendmailtoall');
        Route::get('deleteplan/{id}', 'deleteplan')->name('deleteplan');
        Route::get('approveplan/{id}', 'approvePlan')->name('approveplan');
        Route::get('markas/{status}/{id}', 'markplanas')->name('markas');
    });


    Route::controller(ManageDepositController::class)->group(function () {
    Route::get('deldeposit/{id}', 'deldeposit')->name('deldeposit');
    Route::get('pdeposit/{id}', 'pdeposit')->name('pdeposit');
    Route::get('viewimage/{id}', 'viewdepositimage')->name('viewdepositimage');

    Route::post('editamount', 'editamount')->name('editamount');
    Route::post('deposits/update/{id}', 'updateDeposit')->name('deposit.update');

    Route::post('editamount/{id}', 'npdeposit')->name('npdeposit');
    });

    Route::controller(ManageWithdrawalController::class)->group(function () {
        Route::post('pwithdrawal', 'pwithdrawal')->name('pwithdrawal');
        Route::get('process-withdrawal-request/{id}', 'processwithdraw')->name('processwithdraw');
    });

    Route::controller(PaymentController::class)->group(function () {
        // Payment settings
        Route::post('addwdmethod', 'addpaymethod')->name('addpaymethod');
        Route::put('updatewdmethod', 'updatewdmethod');
        Route::get('edit-method/{id}', 'editmethod')->name('editpaymethod');
        Route::get('delete-method/{id}', 'deletepaymethod')->name('deletepaymethod');
        //enable and disbale payment method routes
        Route::get('toggle-method-status/{id}', 'togglePaymentMethodStatus')->name('togglestatus');
        Route::put('update-method', 'updatemethod')->name('updatemethod');
        Route::put('paypreference', 'paypreference')->name('paypreference');
        Route::put('updatecpd', 'updatecpd')->name('updatecpd');
        Route::put('updategateway', 'updategateway')->name('updategateway');
        Route::put('update-transfer-settings', 'updateTransfer')->name('updatetransfer');
        Route::get('settings/payment-settings', 'paymentview')->name('paymentview');
    });

    Route::controller(TopupController::class)->group(function () {
        Route::post('topup', 'topup')->name('topup');
    });


    Route::controller(IpaddressController::class)->group(function () {
        Route::get('ipaddress', 'index')->name('ipaddress');
        Route::get('allipaddress', 'getaddress')->name('allipaddress');
        Route::get('delete-ip/{id}', 'deleteip')->name('deleteip');
        Route::post('add-ip', 'addipaddress')->name('addipaddress');
    });

    /* Route::controller(SettingsController::class)->group(function () {
        Route::post('updatesettings', 'updatesettings');
        Route::post('updateasset', 'updateasset');
        Route::post('updatemarket', 'updatemarket');
        Route::post('updatefee', 'updatefee');
        Route::get('deletewdmethod/{id}', 'deletewdmethod');
    }); */

    Route::controller(ManageAdminController::class)->group(function () {
        Route::get('unblock/{id}', 'unblockadmin');
        Route::get('ublock/{id}', 'blockadmin');
        Route::get('deleletadmin/{id}', 'deleteadminacnt')->name('deleteadminacnt');
        Route::post('editadmin', 'editadmin')->name('editadmin');
        Route::get('adminchangepassword', 'adminchangepassword');
        Route::post('adminupdatepass', 'adminupdatepass')->name('adminupdatepass');
        Route::get('resetadpwd/{id}', 'resetadpwd')->name('resetadpwd');
        Route::post('sendmail', 'sendmail')->name('sendmailtoadmin');
        Route::post('changestyle', 'changestyle')->name('changestyle');
        Route::post('saveadmin', 'saveadmin');
        Route::post('update-profile', 'updateadminprofile')->name('upadprofile');
    });

    Route::controller(FrontendController::class)->group(function () {
        // This Route is for frontpage editing
        Route::post('savefaq', 'savefaq')->name('savefaq');
        Route::post('savetestimony', 'savetestimony')->name('savetestimony');
        Route::post('saveimg', 'saveimg')->name('saveimg');
        Route::post('savecontents', 'savecontents')->name('savecontents');
        //Update Frontend Pages
        Route::post('updatefaq', 'updatefaq')->name('updatefaq');
        Route::post('updatetestimony', 'updatetestimony')->name('updatetestimony');
        Route::post('updatecontents', 'updatecontents')->name('updatecontents');
        Route::post('updateimg', 'updateimg')->name('updateimg');
        // Delete fa and tes routes
        Route::get('delfaq/{id}', 'delfaq');
        Route::get('deltestimony/{id}', 'deltest');
        // privacy policy
        Route::get('privacy-policy', 'termspolicy')->name('termspolicy');
        Route::post('privacy-policy', 'savetermspolicy')->name('savetermspolicy');
    });

    Route::controller(InvPlanController::class)->group(function () {
        Route::post('addplan', 'addplan')->name('addplan');
        Route::post('updateplan', 'updateplan')->name('updateplan');
        Route::get('trashplan/{id}', 'trashplan')->name('trashplan');
    });

    /* Route::controller(LogicController::class)->group(function () {
        Route::post('addagent', 'addagent');
        Route::get('viewagent/{agent}', 'viewagent')->name('viewagent');
        Route::get('delagent/{id}', 'delagent')->name('delagent');
    }); */

    Route::controller(AppSettingsController::class)->group(function () {
        // Update App Information
        Route::put('updatewebinfo', 'updatewebinfo')->name('updatewebinfo');
        Route::put('updatepreference', 'updatepreference')->name('updatepreference');
        Route::put('updateemail', 'updateemail')->name('updateemailpreference');
        // Settings Routes
        Route::get('settings/app-settings', 'appsettingshow')->name('appsettingshow');
        Route::post('update-theme', 'updateTheme')->name('theme.update');
    });

    Route::controller(ReferralSettings::class)->group(function () {
        // Update referral settings info
        Route::put('update-bonus', 'updaterefbonus')->name('updaterefbonus');
        Route::get('settings/referral-settings', 'referralview')->name('refsetshow');
        // Update other bonus settings info
        Route::put('other-bonus', 'otherBonus')->name('otherbonus');
    });

    Route::controller(ImportController::class)->group(function () {
        Route::get('download-doc', 'downloadDoc')->name('downlddoc');
        // This route is to import data from excel
        Route::post('fileImport', 'fileImport')->name('fileImport');
    });

    Route::controller(SubscriptionSettings::class)->group(function () {
        Route::put('updatesubfee', 'updatesubfee')->name('updatesubfee');
        Route::get('settings/subscription-settings', 'index')->name('subview');
    });

    Route::controller(ManageAssetController::class)->group(function () {
        // Crypto Asset
        Route::get('setcryptostatus/{asset}/{status}', 'setassetstatus')->name('setassetstatus');
        Route::get('useexchange/{value}', 'useexchange')->name('useexchange');
        Route::post('exchangefee', 'exchangefee')->name('exchangefee');
    });


    Route::controller(MembershipController::class)->group(function () {
        //memebership module
        Route::get('courses', 'showCourses')->name('courses');
        Route::post('add-course', 'addCourse')->name('addcourse');
        Route::patch('update-course', 'updateCourse')->name('updatecourse');
        Route::get('delete-course/{id}', 'deleteCourse')->name('deletecourse');

        Route::get('courses-lessons/{id}', 'showLessons')->name('lessons');
        Route::post('add-lesson', 'addLesson')->name('addlesson');
        Route::patch('update-lesson', 'updateLesson')->name('updatedlesson');
        Route::get('delete-lesson/{id}/{courseId}', 'deleteLesson')->name('deletelesson');

        Route::get('categories', 'category')->name('categories');
        Route::post('add-category', 'addCategory')->name('addcategory');
        Route::get('delete-cat/{id}', 'deleteCategory')->name('deletecategory');
        Route::get('lessons-without-course', 'lessonWithoutCourse')->name('less.nocourse');
    });


    // subscription copy trading
    //master account
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('trading-settings', 'myTradingSettings')->name('tsettings');
        Route::get('symbol-maps', 'symbolMapping')->name('symbolmaps');
        Route::post('create-copytrade-account', 'createCopyMasterAccount')->name('create.master');
        Route::get('delete-master-account/{id}', 'deleteMasterAccount')->name('del.master');
        Route::post('renew-master-account', 'renewAccount')->name('renew.master');
        //update strategy
        Route::post('update-strategy', 'updateStrategy')->name('updatestrategy');
        Route::get('delsub/{id}', 'delsub');
        Route::get('confirmsub/{id}', 'confirmsub');
        Route::get('invoices/{id}', 'invoices')->name('admin.invoices');
    });

    Route::controller(TradingAccountController::class)->group(function () {
        //subscriber account
        Route::get('trading-accounts', 'tradingAccounts')->name('tacnts');
        Route::post('create-sub-account', 'createSubscriberAccount')->name('create.sub');
        Route::get('delete-sub-account/{id}', 'deleteSubAccount')->name('del.sub');
        Route::get('payment', 'payment')->name('tra.pay');
        Route::post('renew-trading-account', 'renewAccount')->name('renew.acnt');
        //Copy trade
        Route::post('/start-copy-account', 'copyTrade')->name('cptrade');
        //deployment.
        Route::get('/deployment/{id}/{deployment}', 'deployment')->name('acnt.deployment');
        Route::get('deployment-all/{accounttype}/{deploytype}', 'deploymentAll')->name('deploymentAll');
    });

    /*
		Trading signal modules
		users can subscribe to signal channel to get access
	*/

    //signals
    Route::controller(SignalProvderController::class)->group(function () {
        Route::get('trading-signals', 'tradeSignals')->name('signals');
        Route::post('post-signals', 'addSignals')->name('postsignals');
        Route::get('publish-signals/{signal}', 'publishSignals')->name('pubsignals');
        Route::put('update-result', 'updateResult')->name('updt.result');
        Route::get('delete-signal/{signal}', 'deleteSignal')->name('delete.signal');
        //signal fees 
        Route::get('signal-settings', 'settings')->name('signal.settings');
        Route::put('save-signal-settings', 'saveSettings')->name('save.settings');
        Route::get('chat-id', 'getChatId')->name('chat.id');
        Route::get('delete-id', 'deleteChatId')->name('delete.id');
        //subscribers
        Route::get('signal-subscribers', 'subscribers')->name('signal.subs');
        Route::get('delete-subscriber/{id}', 'deleteSubscriber')->name('delete.subscriber');
    });

    // clear cache
    Route::get('clearcache', [ClearCacheController::class, 'clearcache'])->name('clearcache');

    // Accounts Import
    Route::controller(AccountsImportController::class)->group(function () {
        Route::get('accounts', 'index')->name('admin.accounts.index');
        Route::post('accounts/import', 'import')->name('admin.accounts.import');
        Route::get('accounts/sample', 'downloadSample')->name('admin.accounts.sample');
    });

    // Demo Account Requests
    Route::controller(DemoRequestController::class)->group(function () {        Route::get('demo-requests', 'index')->name('admin.demo.requests');
        Route::post('demo-requests/{id}/status', 'updateStatus')->name('admin.demo.status');
        Route::delete('demo-requests/bulk', 'bulkDestroy')->name('admin.demo.bulk-destroy');
        Route::delete('demo-requests/{id}', 'destroy')->name('admin.demo.destroy');
    });

    // Second Account Requests
    Route::controller(SecondAccountRequestController::class)->group(function () {
        Route::get('second-account-requests', 'index')->name('admin.second.requests');
        Route::post('second-account-requests/{id}/status', 'updateStatus')->name('admin.second.status');
        Route::delete('second-account-requests/bulk', 'bulkDestroy')->name('admin.second.bulk-destroy');
        Route::delete('second-account-requests/{id}', 'destroy')->name('admin.second.destroy');
        Route::get('secondary-accounts', 'secondaryList')->name('admin.secondary.list');
        Route::get('create-secondary-account', 'createForm')->name('admin.secondary.create');
        Route::post('create-secondary-account', 'store')->name('admin.secondary.store');
        Route::get('generate-passwords', 'generatePasswords')->name('admin.secondary.passwords');
        Route::get('fetch-user-credentials', 'fetchUserCredentials')->name('admin.secondary.credentials');
        Route::post('secondary-accounts/{id}/update-password', 'updateLoginPassword')->name('admin.secondary.updatepwd');
        Route::delete('secondary-accounts/bulk', 'bulkDestroySecondary')->name('admin.secondary.bulk-destroy');
        Route::delete('secondary-accounts/{id}', 'destroySecondary')->name('admin.secondary.destroy');
        // Trash / restore
        Route::get('secondary-accounts/trashed', 'trashedSecondary')->name('admin.secondary.trashed');
        Route::post('secondary-accounts/{id}/restore', 'restoreSecondary')->name('admin.secondary.restore');
        Route::post('secondary-accounts/bulk-restore', 'bulkRestoreSecondary')->name('admin.secondary.bulk-restore');
        Route::delete('secondary-accounts/{id}/force', 'forceDestroySecondary')->name('admin.secondary.force-destroy');
    });
});
