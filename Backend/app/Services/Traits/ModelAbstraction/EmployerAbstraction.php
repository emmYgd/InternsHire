<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Employer;
use App\Services\Traits\ModelCRUD\EmployerCRUD;
use App\Services\Traits\ModelCRUD\InternCRUD;
use App\Services\Traits\ModelCRUD\JobsCRUD;
use App\Services\Traits\ModelAbstraction\CommentRateAbstraction;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;

trait EmployerAbstraction
{	
	//inherits all their methods:
	use EmployerCRUD;
	use InternCRUD;
	use JobsCRUD;
	use ComputeUniqueIDService;
	use CommentRateAbstraction;

	protected function EmployerSearchAllInternsService() : array
	{
		$queryKeysValues = ['owner' => 'employer'];
		$allInterns = $this->EmployerReadAllInternsLazyService($queryKeysValues);
		return $allInterns;
	} 


	protected function EmployerCommentRateInternsService(Request $request): bool
	{
		$employer_id = $request->employer_id;
		$interns_id = $request->interns_id;
		$comment = $request->comment;
		$rate = $request->rate;
		
		//first generate a unique comment_rate_id:
		$comment_rate_id = $this->genUniqueNumericId();

		$toBeSavedParams = [
			'comment_rate_id' => $comment_rate_id,
			'owner' => 'employer',
			'intern_id' => $intern_id,//intern that was rated,  
			'employer_id' => $employer_id, //employer that rated/commented, gotten from the search function.
			'comment' => $comment,
			'rate' => $rate
		];

		//now save first in the comment_rate_table:
		$this->EmployerCommentRateCreateAllService($toBeSavedParams);
		return true;
	}


}
