<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Intern;
use App\Services\Traits\ModelCRUD\InternCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use Illuminate\Http\Request;

trait InternAccessAbstraction
{
	//inherits all their methods:
	use InternCRUD;
	use ComputeUniqueIDService;
	use PassHashVerifyService;

	protected function InternConfirmLoginStateService($intern_id) : bool
	{

		$queryKeysValues = ['intern_id' => $intern_id];
		$detailsFound = $this->InternReadSpecificService($queryKeysValues);

		//get the login state:
		$login_status = $detailsFound['is_logged_in'];
		return $login_status;
	}


	protected function InternUpdateLoginState(Request $request): bool
	{
		$intern_id = $request->input('intern_id');
		if($intern_id !== ""){
			$queryKeysValues = ['intern_id' => $intern_id];
			$newKeysValues = ['is_logged_in' => $request->is_logged_in];
			$this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
		}

		return true;
	}


	protected function InternDetailsFoundService(Request $request) //: array
	{
		$email_uname = $request->input('email_or_username');
        $pass = $request->input('password');

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email_uname];
        $detailsFound = $this->InternReadSpecificService($queryKeysValues);
        //$detailsFound = Intern::where($queryKeysValues)->first();
        if( empty($detailsFound) )
        {
            //change the query key value pair:
            $queryKeysValues = ['username' => $email_uname];

        	$detailsFound = $this->InternReadSpecificService($queryKeysValues);
        	if( $detailsFound === null )
        	{
        		throw new \Exception("Failed login attempt. Invalid Username/Email provided!");
			}
		}

		return $detailsFound;
	}


	protected function InternUpdatePasswordService(Request $request): bool
	{
		$email_or_username = $request->input('email_or_username');
        $new_pass = $request->input('new_pass');

		//hash password before save:
        $hashedPass = $this->HashPassword($new_pass);

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email_or_username];

		$newKeysValues = ['password' => $hashedPass];

		//attempt at email, then password:
        $has_updated = $this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$has_updated){
        	$queryKeysValues = ['username' => $email_or_username];
        	$this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
        }

        return true;
	}


	//update each fields without mass assignment: Specific Logic
	protected function InternUpdateEachService(Request $request): bool
	{
		$intern_id = $request->input('intern_id');
		$queryKeysValues = ['intern_id' => $intern_id];

		$newKeysValues = $request->except('intern_id');

			/*foreach($request as $reqKey => $reqValue)
			{	
				$queryKeysValues = ['intern_id' => $intern_id];
				if(is_array($reqValue)){
					$newKeysValues = [$reqKey => json_encode($reqValue)];
				}else{
					$newKeysValues = [$reqKey => $reqValue];
				}
			}*/
		$is_intern_updated = $this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
		return $is_intern_updated;	
	}


	protected function InternSaveFilesService(Request $request): bool
	{
		/*note: files are to be stored in the database for now...
		this could change in the future to include storing files on disk
		and remote file storage system */

		$intern_id = $request->intern_id;

		if($intern_id !== ""){
			//query and new Keys and values:
			$queryKeysValues = ['intern_id' => $intern_id];
			$filteredRequest = $request->except('intern_id');
			$newKeysValues = $filteredRequest;

			foreach($newKeysValues as $fileKey => $fileValue){

				while(
					$filteredRequest->hasFile($fileKey) &&
					$filteredRequest->file($fileKey)->isValid()
				)
				{
					$this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
				}
			}
		}

		return true;
	}

}

?>
