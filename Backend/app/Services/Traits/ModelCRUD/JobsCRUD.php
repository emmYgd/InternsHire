<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Jobs;
use App\Models\Application;

use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

trait JobsCRUD
{
	//CRUD for services:
	protected function JobsCreateAllService(any | array $paramsToBeSaved): bool
	{ 
		Jobs::create($paramsToBeSaved);
		return true;		
	}


	protected function JobsReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = Jobs::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function JobsReadAllLazyService(): LazyCollection
	{
		//load this in chunk to avoid memory load:
		$readAllModel = Jobs::lazy();
		return $readAllModel;
	}

	protected function JobPostsReadAllLazyService(array $queryKeysValues): array
	{
		$allJobsPosted = Jobs::where($queryKeysValues)->lazy();
		return $allJobsPosted;
	}


	protected function JobsReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = Jobs::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function JobsUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Jobs::where($queryKeysValues)->update($newKeysValues);
		return true;
	}


	protected function JobsDeleteSpecificService(array $deleteKeysValues): bool
	{
		Jobs::where($deleteKeysValues)->delete();
		return true;
	}

}

?>