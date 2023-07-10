<?php

namespace App\Services\Traits\ModelAbstraction;

use App\Models\Admin;
use App\Services\ModelCRUD\AdminCRUD;
use App\Services\Utilities\PassHashVerifyService
use App\Services\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;

use Illuminate\Http\Request;

trait AdminAccessAbstraction
{	
	//inherits all their methods:
	use AdminCRUD;
	use ComputeUniqueIDService;
	use CommentRateAbstractionService;
	use PassHashVerifyService;

	protected function AdminCheckLoginService(string $admin_id) : bool
	{
		$queryKeysValues = ['admin_id' => $admin_id];
		$detailsFound = $this->AdminReadSpecificService($queryKeysValues);

		//get the login state:
		$logged_in_status = $detailsFound['is_logged_in'];
		if($logged_in_status /*== true*/){
			return true;
		}

		return true;	
	}


	protected function AdminUpdateLoginState(Request $request): bool
	{
		$admin_id = $request->admin_id;
		if($admin_id !== ""){
			$queryKeysValues = ['admin_id' => $admin_id];
			$newKeysValues = ['is_logged_in' => $request->is_logged_in];
			$this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
		}

		return true;
	}


	protected function AdminDetailsFoundService(Request $request) : array
	{
		$email_uname = $request->email_or_username;
        $pass = $request->password;

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email_uname];
        $detailsFound = $this->AdminReadSpecificService($queryKeysValues);

        if( empty($detailsFound) )
        {
            //change the query key value pair:
            $queryKeysValues = ['name' => $email_uname];

        	$detailsFound = $this->AdminReadSpecificService($queryKeysValues);
        	if( empty($detailsFound) )
        	{
        		throw new \Exception("Failed login attempt. Invalid Admin Name/Email provided!");
			}
		}

		return $detailsFound;
	}


	//update each fields without mass assignment: Specific Logic 
	protected function AdminUpdateEachService(Request $request): bool
	{
		$admin_id = $request->admin_id;

		if($admin_id !== ""){

			$request = $request->except('admin_id');

			foreach($request as $reqKey => $reqValue){

				$queryKeysValues = ['admin_id' => $admin_id];

				if(is_array($reqValue)){
					$newKeysValues = [$reqKey => json_encode($reqValue)];
				}else{
					$newKeysValues = [$reqKey => $reqValue];
				}
				$this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
			}
		}
		return true;
	}


	protected function AdminSaveFilesService(Request $request): bool
	{
		/*note: files are to be stored in the database for now...
		this could change in the future to include storing files on disk 
		and remote file storage system */

		$admin_id = $request->admin_id;

		if($admin_id !== ""){
			//query and new Keys and values:
			$queryKeysValues = ['admin_id' => $admin_id];
			$filteredRequest = $request->except('admin_id');
			$newKeysValues = $filteredRequest;

			foreach($newKeysValues as $fileKey => $fileValue){

				while(
					$filteredRequest->hasFile($fileKey) && 
					$filteredRequest->file($fileKey)->isValid()
				)
				{
					$this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
				}
			}
		}

		return true;
	}
	
}

?>