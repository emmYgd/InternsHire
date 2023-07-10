<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Jobs;
use App\Models\Application;

use Illuminate\Http\Request;

trait ApplicationCRUD
{
	//CRUD for services:
	protected function ApplicationCreateAllService(any $paramsToBeSaved): bool
	{ 
		Application::create($paramsToBeSaved);
		return true;		
	}

	protected function ApplicationReadAllLazyService(array $queryKeysValues): array
	{
		//all applications:
		$all_applications = Application::where($queryKeysValues)->lazy();

		//all jobs:
		$all_applied_jobs = $allApplications->job;

		return $all_applied_jobs;//use hidden and visible to guard this..
	}

	protected function ApplicationUpdateSpecificService($queryKeysValues, $newKeysValues)
	{
		Application::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function ApplicationDeleteSpecificService($queryKeysValues)
	{
		Application::where($queryKeysValues)->delete();
		return true;
	}


}