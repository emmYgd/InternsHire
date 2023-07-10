<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Assessment;

use Illuminate\Http\Request;

trait AssessmentCRUD
{	
	//CRUD for services:
	protected function AssessmentCreateAllService($anyParam)
	{
		Assessment::create($anyParam); 	
		return true;		
	}


	protected function AssessmentReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = Assessment::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function AssessmentReadAllService(): array
	{
		$readAllModel = Assessment::get();
		return $readAllModel;
	}


	protected function AssessmentReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Assessment::where($queryKeysValues)->get();
		return $readAllModel;
	}

	protected function AssessmentReadAllLazyService(): array
	{
		//all applications:
		$details = Assessment::lazy();
		return $details;//use hidden and visible to guard this..
	}


	protected function AssessmentReadSpecificAllLazyService(array $queryKeysValues): array
	{
		//all applications:
		$details = Assessment::where($queryKeysValues)->lazy();
		return $details;//use hidden and visible to guard this..
	}


	protected function AssessmentUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Assessment::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function AssessmentDeleteSpecificService(array $deleteKeysValues): bool
	{
		Assessment::where($deleteKeysValues)->delete();
		return true;
	}

}

?>