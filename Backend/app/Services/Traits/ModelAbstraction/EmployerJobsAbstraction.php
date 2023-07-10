<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Employer;

use App\Services\Traits\ModelCRUD\EmployerCRUD;
use App\Services\Traits\ModelCRUD\JobsCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;

trait EmployerJobsAbstraction
{	
	//inherits all their methods:
	use EmployerCRUD;
	use JobsCRUD;
	use ComputeUniqueIDService;

	protected function EmployerPostJobsService(Request $request) : bool
	{
		//extract the new array:
		$newKeysValues = [
			'jobs_id' => $this->genUniqueNumericId(),
			'employer_id' => $request->input('employer_id'),
			'owner' => $request->input('owner'),
			'job_title' => $request->input('job_title'),
			'job_description' => $request->input('job_description'),
			'job_requirement' => $request->input('job_requirement'),
			
			'address' => $request->input('address'),
			'state' => $request->input('state'),
			'country' => $request->input('country'),
			'date_expired' => $request->input('date_expired'),
			'expected_start' => $request->input('expected_start'),
			'internship_period' => $request->input('internship_period'),

			'location_type' => $request->input('location_type'),
			'nature' => $request->input('nature'),
			
			'currency_of_payment' => $request->input('currency_of_payment'),
			'salary_or_incentives' => $request->input('salary_or_incentives'),

			'is_delayed' => $request->input('is_delayed')
		];

		//save:
		$this->JobsCreateAllService($newKeysValues);
		return true;
	}


	protected function EmployerChangeJobPostedService(Request $request) : array 
	{
		$employer_id = $request->input('employer_id');

		if($employer_id !== "")
		{

			$request = $request->except('employer_id');

			foreach($request as $reqKey => $reqValue){

				$queryKeysValues = ['employer_id' => $employer_id];

				if(is_array($reqValue)){
					$newKeysValues = [$reqKey => json_encode($reqValue)];
				}else{
					$newKeysValues = [$reqKey => $reqValue];
				}
				$this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);
			}
		}
		return true;
	}


	protected function EmployerSearchAllJobPostsService(Request $request): array
	{
		$employer_id = $request->input('employer_id');
		$queryKeysValues = ['employer_id' => $employer_id];
		$detailsFoundAll = $this->JobPostsReadAllLazyService($queryKeysValues);

		return $detailsFoundAll;
	}

	protected function EmployerDeleteJobPostService(Request $request): array
	{
		$deleteKeysValues = [
			'employer_id' => $request->input('employer_id'),
			'job_id' => $request->input('job_id'),
		];
		$this->JobsDeleteSpecificService($deleteKeysValues);
		return true;
	}

	protected function EmployerDelayJobPostService(Request $request): array
	{
		$queryKeysValues = [
			'employer_id' => $request->input('employer_id'),
			'job_id' => $request->input('job_id'),
		];

		$newKeysValues = ['is_delayed' => $request->input('is_delayed')];

		$this->JobsUpdateSpecificService($queryKeysValues, $newKeysValues);
		return true;
	}


	

}