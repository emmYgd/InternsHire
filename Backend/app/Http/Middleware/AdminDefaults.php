<?php

namespace App\Http\Middleware;


use App\Models\Admin;

use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Closure;

final class AdminDefaults
{
	use ComputeUniqueIDService;
	//in groovy on grails, this would have been transactional:

	public function handle(Request $request, Closure $next){

		//create Admin Defaults in database:
		$this->createAdminDefault();

		return $next($request);
	}

	private function createAdminDefault()
	{
		Artisan::call('migrate:fresh');

		$defaultAdminDetails = new Admin();

		$defaultAdminDetails->admin_id = $this->genUniqueAlphaNumID();
		$defaultAdminDetails->email = env('ADMIN_MAIL');
		$defaultAdminDetails->name = env('ADMIN_USERNAME');
		$defaultAdminDetails->password = env('ADMIN_PASSWORD');

		$defaultAdminDetails->save();
	}

}
