<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Intern;
use App\Services\Traits\ModelCRUD\InternCRUD;
use App\Services\Traits\ModelCRUD\CommentRateCRUD;
use App\Services\Traits\ModelAbstraction\CommentRateAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

trait InternAbstraction
{
	//inherits all their methods:
	use InternCRUD;
	use CommentRateCRUD;
	use ComputeUniqueIDService;
	use CommentRateAbstraction;

	protected function InternGetOwnDetailsService(string $currentInternID): Intern
	{
		$queryKeysValues = ['intern_id' => $currentInternID];
		$internDetails = $this->InternReadSpecificService($queryKeysValues);
		return $internDetails;
	}

    protected function InternUpdateDetailsService(Request $request): bool
    {
        $intern_id = $request->input('intern_id');

        $queryKeysValues = ['intern_id' => $intern_id];
        $newKeysValues = $request->except('intern_id');

        //update accordingly:
        $is_details_updated = $this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
        return $is_details_updated;
    }

	protected function InternSearchAllEmployersService() : LazyCollection
	{
		//$queryKeysValues = ['owner' => 'employer'];
		$allEmployers = $this->InternReadAllEmployersLazyService();
		return $allEmployers;
	}


	protected function InternCommentRateEmployersService(Request $request): bool
	{
		$intern_id = $request->intern_id;
		$employer_id = $request->employer_id;
		$comment = $request->comment;
		$rate = $request->rate;

		//first generate a unique comment_rate_id:
		$comment_rate_id = $this->genUniqueNumericId();

		$toBeSavedParams = [
			'comment_rate_id' => $comment_rate_id,
			'owner' => 'intern',
			'intern_id' => $intern_id,//intern that rated this
			'employer_id' => $employer_id, //employer that was rated, gotten from the search function.
			'comment' => $comment,
			'rate' => $rate
		];

		//now save first in the comment_rate_table:
		$this->InternCommentRateCreateAllService($toBeSavedParams);
		return true;
	}



}
