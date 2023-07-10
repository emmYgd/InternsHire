<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Employer;
use App\Services\Traits\ModelCRUD\EmployerCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;

trait EmployerAccessAbstraction
{	
	//inherits all their methods:
	use EmployerCRUD;
	use ComputeUniqueIDService;
	use PassHashVerifyService;

	protected function EmployerCheckLoginService(string $employer_id) : bool
	{
		$queryKeysValues = ['employer_id' => $employer_id];
		$detailsFound = $this->EmployerReadSpecificService($queryKeysValues);

		//get the login state:
		$logged_in_status = $detailsFound['is_logged_in'];
		if(!$logged_in_status /*== true*/)
		{
			return false;
		}

		return true;	
		
	}


	protected function EmployerUpdateLoginStateService(Request $request): bool
	{
		$employer_id = $request->input('employer_id');
		if($employer_id !== ""){
			$queryKeysValues = ['employer_id' => $employer_id];
			$newKeysValues = ['is_logged_in' => $request->input('is_logged_in')];
			$this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);
		}

		return true;
	}


	protected function EmployerDetailsFoundService(Request $request) : array
	{
		$email = $request->input('email');
        $pass = $request->input('password');

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email];
        $detailsFound = $this->EmployerReadSpecificService($queryKeysValues);

        if( empty($detailsFound) )
        {
            throw new \Exception("Failed login attempt. Invalid Username/Email provided!");
		}

		return $detailsFound;
	}


	protected function EmployerUpdatePasswordService(Request $request): bool
	{
		$email = $request->input('email');
        $new_pass = $request->input('new_pass');

		//hash password before save:
        $hashedPass = $this->HashPassword($new_pass);

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email];
		
		$newKeysValues = ['password' => $hashedPass];

		//attempt at email, then password:
       	$this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);

        return true;
	}


	//update each fields without mass assignment: Specific Logic 
	protected function EmployerUpdateEachService(Request $request): bool
	{
		$employer_id = $request->input('employer_id');

		if($employer_id !== ""){

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


	protected function EmployerSaveFilesService(Request $request): bool
	{
		/*note: files are to be stored in the database for now...
		this could change in the future to include storing files on disk 
		and remote file storage system */

		$employer_id = $request->input('employer_id');

		if($employer_id !== ""){
			//query and new Keys and values:
			$queryKeysValues = ['employer_id' => $employer_id];
			$filteredRequest = $request->except('employer_id');
			$newKeysValues = $filteredRequest;

			foreach($newKeysValues as $fileKey => $fileValue){

				while(
					$filteredRequest->hasFile($fileKey) && 
					$filteredRequest->file($fileKey)->isValid()
				)
				{
					$this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);
				}
			}
		}

		return true;
	}


}

?>