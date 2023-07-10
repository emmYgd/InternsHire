<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Intern;
use App\Models\Employer;

use App\Services\Traits\ModelCRUD\CommentRateCRUD;

use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

trait InternCRUD
{
	use CommentRateCRUD;

	//CRUD for services:
	protected function InternCreateAllService(Request | array $validatedRequest): bool
	{
		Intern::create($validatedRequest);
		return true;	
	}


	protected function InternReadSpecificService(array $queryKeysValues): Intern
	{	
		$readModel = Intern::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function InternReadAllService(): array
	{	
		$readAllModel = Intern::get();
		return $readAllModel;
	}

	protected function InternReadAllEmployersLazyService(): LazyCollection
	{	
		//start from employers with the highest rating:
		$allEmployers = Employer::lazy();
		return $allEmployers;
	}


	/*protected function InternReadAllEmployersLazyService($queryKeysValues): array
	{	
		$allCommentRate = $this->CommentRateReadAllLazyService($queryKeysValues);
		$allEmployersID = $allCommentRate['employer_id'];

		//start from employers with the highest rating:
		$allEmployers = Employer::where(['employer_id' => $allEmployersID])->lazy();

		return $allEmployers;
	}*/


	protected function InternReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Intern::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function InternUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Intern::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function InternDeleteSpecificService(array $deleteKeysValues): bool
	{
		Intern::where($deleteKeysValues)->delete();
		return true;
	}
}