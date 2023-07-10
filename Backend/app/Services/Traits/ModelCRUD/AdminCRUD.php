<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Admin;

use Illuminate\Http\Request;

trait AdminCRUD
{
	use InternAbstractionService;
	use EmployerAbstractionService;
	use JobsAbstractionService;
	use ApplicationAbstractionService;
	use ChatAbstractionService;
	use PaymentAbstractionService;
	use TestAbstractionService;
	use DelRecruitAbstractionService;//DelegateRecruitment
	
	//CRUD for services:
	
	protected function AdminCreateAllService($anyParam)
	{
		Admin::create($anyParam);
		return true;		
	}


	protected function AdminReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = Admin::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function AdminReadAllService(array $queryKeysValues): array
	{
		$readAllModel = Admin::get();
		return $readAllModel;
	}


	protected function AdminReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Admin::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function AdminUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Admin::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function AdminDeleteSpecificService(array $deleteKeysValues): bool
	{
	 	Admin::where($deleteKeysValues)->delete();
		return true;
	}

}

?>