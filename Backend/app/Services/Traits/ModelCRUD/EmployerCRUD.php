<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Employer;
use App\Models\Interns;

use App\Services\Traits\ModelCRUD\CommentRateCRUD;

use Illuminate\Http\Request;


trait EmployerCRUD
{
	use CommentRateCRUD;

	//CRUD for services:
	protected function EmployerCreateAllService(array $validatedRequest): bool
	{
		Employer::create($validatedRequest);
		return true;	
	}


	protected function EmployerReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = Employer::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function EmployerReadAllService(array $queryKeysValues): array
	{
		$readAllModel = Employer::get();
		return $readAllModel;
	}

	protected function EmployerReadAllInternsLazyService($queryKeysValues): array
	{	
		$allCommentRate = $this->CommentRateReadAllLazyService($queryKeysValues);
		$allInternsID = $allCommentRate['intern_id'];

		//start from employers with the highest rating:
		$allInterns = Intern::where(['intern_id' => $allInternsID])->lazy();

		return $allInterns;
	}


	protected function EmployerReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Employer::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function EmployerUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Employer::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function EmployerDeleteSpecificService(array $deleteKeysValues): bool
	{
		Employer::where($deleteKeysValues)->delete();
		return true;
	}

}

?>