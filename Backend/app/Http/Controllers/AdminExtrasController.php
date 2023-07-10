<?php

namespace App\Http\Controllers;

use App\Validators\AdminExtrasRequestRules;

use App\Services\Interfaces\AdminInterface;
use App\Services\Traits\ModelAbstraction\AdminExtrasAbstraction;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminExtrasController extends Controller //implements AdminInterface
{
	use AdminExtrasRequestRules;
    use AdminExtrasAbstraction;


    protected function CreateSkillsTests(Request $request)
    {
        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->setSkillsTestsRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $is_details_saved = $this->AdminCreateTestService($request);
            if(!$is_details_saved/*false*/){
                throw new \Exception("Test Details not saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Test Details Saved!',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'Test Details Not Saved!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    protected function UpdateSkillsTests(Request $request)
    {
    	status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->updateSkillsTestsRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $has_updated_test = $this->AdminUpdateTestService($request);
            if(!$has_updated_test/*false*/){
                throw new \Exception("Test have been updated successfully!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Updated Successfully!',
            ];

            //redirect on the frontend on receiving this... 

        }catch(\Exception $ex){

             $status = [
                'code' => 0,
                'serverStatus' => 'Not Updated Successfully',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


   	protected function ViewAllSkillsTests(Request $request)
    {
    	$status = array();

        try{

            $reqRules = $this->viewAllSkillsTestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $details_found = $this->AdminViewAllTestsService($request);
            if( empty($details_found) ) {
                throw new \Exception("No tests were found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Tests Details found!',
                'detailsFound' =>  $details_found
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'Retrieval Error!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    protected function DeleteSkillsTests(Request $request)
    {
    	$status = array();

      	try{
         	//get rules from validator class:
         	$reqRules = $this->deleteSkillsTestsRules();

         	//validate here:
         	$validator = Validator::make($request->all(), $reqRules);

         	if($validator->fails()){
            	throw new \Exception("Access Error, Not logged in yet!");
         	}

         	//this should return in chunks or paginate:
         	$has_details_deleted = $this->AdminDeleteTestService($request);
         	if(!$has_details_deleted){
            	throw new \Exception("Tests not deleted successfully!");
         	}

         	$status = [
            	'code' => 1,
            	'serverStatus' => 'Deletion Successful!',
         	];

      	}catch(\Exception $ex){

         	$status = [
            	'code' => 0,
            	'serverStatus' => 'Deletion Un-successful!',
            	'short_description' => $ex->getMessage()
         	];

      	}finally{
         	return response()->json($status, 200);
      	}

    }

}



