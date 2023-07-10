<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Employer;

use App\Services\Traits\ModelCRUD\EmployerCRUD;
//use App\Services\Traits\ModelCRUD\InternCRUD;
use App\Services\Traits\ModelCRUD\JobsCRUD;
use App\Services\Traits\ModelCRUD\ApplicationCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

trait InternJobsAbstraction
{	
	//inherits all their methods:
	use EmployerCRUD;
	use JobsCRUD;
	use ApplicationCRUD;
	use ComputeUniqueIDService;

	public function InternGeneralJobsSearchService(): LazyCollection 
	{
		//intern search all jobs:
		$allJobs = $this->JobsReadAllLazyService();
		return $allJobs;
	}


	protected function InternJobsApplyService(Request $request): bool 
	{	
		$toBeSaved = $request->all();
		//update array:
		$toBeSaved->application_id = $this->genUniqueNumericId();
		$has_applied = $this->ApplicationCreateAllService($toBeSaved);

		return $has_applied;
	}

	protected function InternViewAllJobsAppliedService(Request $request): array 
	{

		$intern_id = $request->intern_id;
		$queryKeysValues = ['intern_id' => $intern_id];

		$applyDetails = $this->ApplicationReadAllLazyService($queryKeysValues);

		return $appliedJobDetails;
	}

	//Delay so Employers won't see it yet:
	protected function InternChangeJobApplyStatusService(Request $request): array
	{
		$queryKeysValues = [
			'intern_id' => $request->employer_id,
			'job_id' => $request->job_id,
		];

		$newKeysValues = ['is_delayed' => $request->is_delayed];

		$this->ApplicationUpdateSpecificService($queryKeysValues, $newKeysValues);
		return true;
	}

	//delete job application:
	protected function InternDeleteJobApplyService(Request $request): array
	{
		$queryKeysValues = [
			'intern_id' => $request->intern_id,
			'job_id' => $request->job_id,
		];
		$this->ApplicationDeleteSpecificService($deleteKeysValues);
		return true;
		
	}



}

?>