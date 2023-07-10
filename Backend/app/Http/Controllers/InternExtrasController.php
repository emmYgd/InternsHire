<?php
namespace App\Http\Controllers;

use App\Validators\InternExtrasRequestRules;

use App\Services\Interfaces\InternExtrasInterface;
use App\Services\Traits\ModelAbstraction\InternExtrasAbstraction;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InternExtrasController extends Controller //implements AdminInterface
{
	use InternExtrasRequestRules;
    use InternExtrasAbstraction;

    protected function LoadSkillsTests(Request $request): array 
    {
    	$status = array();

        try{

            $reqRules = $this->loadSkillsTestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $details_found = $this->InternLoadTestsQuestionsOptionsService($request);
            if( empty($details_found) ) {
                throw new \Exception("No tests were found!");
            }elseif(!details_found/*false*/)
            {
            	throw new \Exception("You have reached the maximum number of attempts for this test!");
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


    protected function SubmitMarkSkillsTests(Request $request): array 
    {
    	status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->submitMarkSkillsTestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $results = $this->InternSubmitMarkTestsService($request);
            if( empty($results/*false*/) ){
                throw new \Exception("Error in evaluation. Try Again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Updated Successfully!',
                'markedResults' => $results
            ];

            //redirect on the frontend on receiving this... 

        }catch(\Exception $ex){

             $status = [
                'code' => 0,
                'serverStatus' => 'Not Marked Successfully',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    protected function ViewAllTakenSkillsTestsAndResults(Request $request): array 
    {
    	$status = array();

        try{

            $reqRules = $this->viewAllAttemptedTestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $details_found = $this->InternViewAllAttemptedService($request);
            if( empty($details_found) ) {
                throw new \Exception("No test summary were found. 
                	Seems like you haven't taken any test yet!");
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

}

?>