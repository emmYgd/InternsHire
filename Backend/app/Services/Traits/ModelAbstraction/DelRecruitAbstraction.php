<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\DelegateRecruitment;
use App\Services\Traits\DelegateRecruitment;

use Illuminate\Http\Request;

trait DelRecruitAbstraction
{
	protected function EmployerOutsourceRecruitmentService(Request $request): bool
	{
		$employer_id = $request->employer_id;
		$payment_id = $request->payment_id;
		$recruitment_type = $request->recruitment_type;

		$toBeSavedParams = [
			'employer_id' => $employer_id,
			'payment_id' => $payment_id,//intern that was rated,  
			'recruitment_type' => $recruitment_type
		];

		//now register employer's interest to outsource recruitment to us:
		$delegate_has_saved = $this->DelegateRecruitmentCreateAllService($toBeSavedParams);
		return $delegate_has_saved;
	}
	
}

?>