<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    //return $router->app->version();
    return "Hello World";
});

$router->post('cool_login', function () use ($router) {
    //return $router->app->version();
    return "Cool Things";
});

//Intern Group:
$router->group(['prefix' => 'api/v1/interns/', /*'middleware' => ''*/], function() use ($router)
{
	$router->group(['prefix' => 'auth/', /*'middleware' => ''*/],
		function() use ($router)
	{
		$router->get('register', [
    		//'as' => 'register',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@Register'
		]);

		$router->post('register', [
    		//'as' => 'register',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@Register'
		]);

		$router->get('login/dashboard', [
    		//'as' => 'login',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@LoginDashboard'
		]);

		$router->post('login/dashboard', [
    		//'as' => 'login',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@LoginDashboard'
		]);

		$router->post('forgot/password', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@ForgotPassword'
		]);

		//for testing:
		$router->get('edit/profile', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@EditProfile'
		]);

		$router->post('edit/profile', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@EditProfile'
		]);

		//optional pictures:
		$router->post('edit/files', [
    		//'as' => 'edit_files',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@EditFilesAndImages'
		]);

		$router->get('update/login/state', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@UpdateLoginState'
		]);

		$router->post('update/login/state', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@UpdateLoginState'
		]);

		$router->get('confirm/login/state', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@ConfirmLoginState'
		]);

		$router->post('confirm/login/state', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@ConfirmLoginState'
		]);

		$router->post('logout', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'InternAccessController@Logout'
		]);

	});


	$router->group(['prefix' => 'dashboard/utils/', /*'middleware' => ''*/],
		function() use ($router)
	{

		$router->get('get/own/details/{currentInternID}', [
			//'as' => 'search_employers',
			//'middleware' => 'init',
    		'uses' => 'InternController@InternGetOwnDetails'
		]);

		//this will include their pricing with or without shipping...
		$router->get('intern/{currentInternID}/search/employers/', [
			//'as' => 'search_employers',
			//'middleware' => 'init',
    		'uses' => 'InternController@InternSearchEmployers'
		]);

        $router->get('intern/update/intern/details', [
            //'as' => 'search_employers',
            //'middleware' => 'init',
            'uses' => 'InternController@InternUpdateDetails'
        ]);

		//this is for when the buyer searches for details of the goods that he already has the summary...
		//use json for loop in the frontend-JS...
		$router->get('comment_rate/employers', [
			//'as' => 'comment_rate_employers',
			//'middleware' => 'init',
    		'uses' => 'InternController@commentRateEmployers'
		]);

		$router->post('chat/employer', [
			//'as' => 'chat_employer',
			//'middleware' => 'init',
    		'uses' => 'InternController@chatEmployers'
		]);

		//all goods cleared from the cart(payment has been made)
		$router->get('take/skills/test/', [
			//'as' => 'take_skills_test',
			//'middleware' => 'init',
    		'uses' => 'InternExtrasController@LoadSkillsTest'//Pending or Cleared
		]);

		$router->get('submit/taken/test/', [
			//'as' => 'submit_test',
			//'middleware' => 'init',
    		'uses' => 'InternExtrasController@SubmitSkillsTest'//Pending or Cleared
		]);

		$router->get('view/all/skills/test/results', [
			//'as' => 'view_results',
			//'middleware' => 'init',
    		'uses' => 'InternExtrasController@ViewAllTakenSkillsTestsAndResults'//Pending or Cleared
		]);

		$router->get('job/search', [
			//'as' => 'job_search',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@GeneralJobSearch'
		]);

		 //Route::post('job/search/category/salary', 'InternJobController@CategorySalaryJobSearch');
        //Route::post('job/search/category/duration', 'InternJobController@CategoryDurationJobSearch');
        //Route::post('job/search/category/location', 'InternJobController@CategoryLocationJobSearch');

		$router->get('apply/to/job', [
			//'as' => 'apply_to_job',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@JobApply'
		]);


		$router->get('view/all/applied/jobs', [
			//'as' => 'view_applied_job',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@ViewAllJobsApplied'
		]);

		$router->post('job/apply/change/status', [
			//'as' => 'change_job_apply_status',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@ChangeJobApplyStatus'
		]);

		$router->post('job/apply/change/delete', [
			//'as' => 'delete_apply',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@DeleteJobApply'
		]);

		$router->post('comment/or/rate/experience', [
			'as' => 'comment_rate',
			//'middleware' => 'init',
    		'uses' => 'InternJobsController@ChangeJobApplyStatus'
		]);

		$router->post('make/payment', [
			//'as' => 'make_payment ',
			//'middleware' => 'init',
    		'uses' => 'PaymentController@internPay'
		]);

	});
});


$router->group(['prefix' => 'api/v1/employers/', /*'middleware' => ''*/], function() use ($router) {

	$router->group(['prefix' => 'auth/', /*'middleware' => ''*/],
	function() use ($router) {
		$router->get('register', [
    		//'as' => 'register',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@register'
		]);

		$router->post('register', [
    		//'as' => 'register',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@register'
		]);

		$router->post('login/dashboard', [
    		//'as' => 'login',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@loginDashboard'
		]);

		$router->post('forgot/password', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@forgotPassword'
		]);

		$router->get('edit/profile', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@editProfile'
		]);

		$router->post('edit/profile', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@editProfile'
		]);

		//optional pictures:
		$router->post('edit/files', [
    		//'as' => 'edit_files',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@editImages'
		]);


		$router->post('update/loggedin/state', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@updateLoginState'
		]);

		$router->post('logout', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'EmployerAccessController@logout'
		]);

	});

	$router->group(['prefix' => 'dashboard/utils/', /*'middleware' => ''*/],
	function() use ($router) {

		//this will include their pricing with or without shipping...
		$router->get('search/interns', [
			//'as' => 'search_interns',
			//'middleware' => 'init',
    		'uses' => 'EmployerController@EmployerSearchInterns'
		]);

		$router->get('recommend/intern', [
			//'as' => 'comment_rate_interns',
			//'middleware' => 'init',
    		'uses' => 'EmployerController@CommentRateInterns'
		]);

		$router->post('chat/intern', [
			//'as' => 'chat_intern',
			//'middleware' => 'init',
    		'uses' => 'EmployerController@ChatInterns'
		]);

		$router->get('job/post', [
			//'as' => 'post_job',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@PostJobs'
		]);

		$router->post('job/post', [
			//'as' => 'post_job',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@PostJobs'
		]);

		$router->get('job/posts/change', [
			//'as' => 'change_job_posts',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@ChangeJobPosted'
		]);

		$router->get('job/posts/view/all', [
			//'as' => 'view_job_posts',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@ViewAllJobPosts'
		]);

		$router->post('job/posts/delete', [
			//'as' => 'delete_job',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@DeleteJobPost'
		]);

		$router->get('job/posts/delay', [
			//'as' => 'delay_job',
			//'middleware' => 'init',
    		'uses' => 'EmployerJobsController@DelayJobPost'
		]);


		$router->get('outsource/interns/recruitment', [
			//'as' => 'delay_posted_job',
			//'middleware' => 'init',
    		'uses' => 'InternJobController@ViewAllJobsApplied'
		]);

		$router->post('outsource/interns/recruitment', [
			//'as' => 'outsource_hiring',
			//'middleware' => 'init',
    		'uses' => 'EmployerExtrasController@OutsourceRecruitment'
		]);

		$router->post('make/payment', [
			//'as' => 'make_payment',
			//'middleware' => 'init',
    		'uses' => 'PayController@EmployerPayment'
		]);//Not Implemented Yet
        //this enables the employers to pay, should in case they choose to outsource to us.

        //Route::post('report/interns', 'EmployerExtrasController@ReportInterns');
       	 //Route::get('generate/unique/url', 'EmployerExtrasController@GenUniqueUrl');
	});

});


$router->group(['prefix' => 'api/v1/admin/', /*'middleware' => ''*/], function() use ($router) {

	$router->group(['prefix' => 'auth/', /*'middleware' => ''*/],
	function() use ($router) {

		$router->post('login/dashboard', [
    		//'as' => 'login',
    		//'middleware' => 'init',
    		'uses' => 'AdminAccessController@loginDashboard'
		]);

		$router->post('forgot/password', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'AdminAccessController@forgotPassword'
		]);

		$router->post('update/admin/details', [
    		//'as' => 'forgot_password',
    		//'middleware' => 'init',
    		'uses' => 'AdminAccessController@updateAdminDetails'
		]);

		$router->post('logout', [
    		//'as' => 'logout',
    		//'middleware' => 'init',
    		'uses' => 'AdminAccessController@logout'
		]);

	});

	$router->group(['prefix' => 'dashboard/utils/', /*'middleware' => ''*/], function() use ($router) {

		$router->get('view/interns/all', [
			'as' => 'view_interns',
			//'middleware' => 'init',
    		'uses' => 'AdminInternsController@viewIntsAll'
		]);

		$router->get('view/general/interns/apply/all', [
			'as' => 'view_applied_interns',
			//'middleware' => 'init',
    		'uses' => 'AdminInternsController@viewAppliedInts'
		]);

		$router->post('view/specific/intern/apply/detail', [
			'as' => '',
    		'uses' => 'AdminInternsController@viewIntApplyDetail'
		]);

		$router->post('view/employers/all', [
			//'as' => 'view_all_employers',
    		'uses' => 'AdminEmployersController@viewEmpAll'
		]);

		//view all goods in motion and their respective locations:
		$router->post('view/employer/job/posts/all', [
			//'as' => 'all_jobs_posts',
    		'uses' => 'AdminEmployersController@viewEmpJobPosts'
		]);


		$router->get('view/employer/outsource/intern/recruitment', [
			//'as' => 'recruitment_outsource',
    		'uses' => 'AdminEmployersController@viewRecruitOutsource'
		]);

		//admin can create job posts on behalf of employee
		$router->post('create/employer/job/posts', [
			'as' => 'create_job_post',
    		'uses' => 'AdminEmployersController@createEmpJobPosts'
		]);

		$router->post('delete/employer/job/posts', [
			'as' => 'delete_job_post',
    		'uses' => 'AdminEmployersController@deleteEmpJobPosts'
		]);

		$router->post('create/skills/test/', [
			//'as' => 'create_skills_test',
    		'uses' => 'AdminExtrasController@CreateSkillsTests'
		]);

		$router->get('update/skills/test/', [
			//'as' => 'update_skills_test',
    		'uses' => 'AdminExtrasController@UpdateSkillsTests'
		]);

		$router->get('view/skills/test/{skill_name}', [
			//'as' => 'view_skills_tests',
    		'uses' => 'AdminExtrasController@ViewAllSkillsTests'
		]);

		$router->get('view/all/interns/by/test/taken/pass/or/fail', [
			//'as' => 'view_interns_by_tests',
    		'uses' => 'AdminExtrasController@ViewIntsByTestResults'
		]);

		$router->get('delete/skills/test', [
			//'as' => 'delete_skills_tests',
    		'uses' => 'AdminExtrasController@DeleteSkillsTests'
		]);

		 $router->get('view/employer/report/interns/all', [
			//'as' => 'view_employer_report',
    		'uses' => 'AdminExtrasController@viewReportedInterns'
		]);

        $router->get('view/interns_employers/chats/all', [
			//'as' => 'view_interns_employers_chats',
    		'uses' => 'AdminExtrasController@viewIntEmpChats'
		]);

		$router->get('chat/employer', [
			//'as' => 'chat_employer',
    		'uses' => 'AdminExtrasController@adminChatEmployer'
		]);

		$router->get('chat/intern', [
			//'as' => 'view_interns_employers_chats',
    		'uses' => 'AdminExtrasController@adminChatIntern'
		]);

		$router->get('delete/employer', [
			//'as' => 'delete_employer',
    		'uses' => 'AdminExtrasController@deleteEmployer'
		]);

		$router->get('delete/intern', [
			//'as' => 'delete_intern',
    		'uses' => 'AdminExtrasController@deleteIntern'
		]);

		$router->get('view/interns/pay', [
			//'as' => 'paid_interns',
    		'uses' => 'AdminExtrasController@viewInternsPay'
		]);


       	$router->get('view/employer/pay', [
			//'as' => 'paid_interns',
    		'uses' => 'AdminExtrasController@viewEmployersPay'
		]);

	});

});
