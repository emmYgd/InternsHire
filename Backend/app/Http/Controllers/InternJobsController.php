<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\InternInterface;
use App\Http\Controllers\Validators\InternJobsRequestRules;
use App\Services\Traits\ModelAbstraction\InternJobsAbstraction;


class InternJobsController extends Controller //implements InternInterface
{
    
    use InternJobsRequestRules;
    use InternJobsAbstraction;


    public function __construct()
    {
        //$this->createAdminDefault();
    }


    public function GeneralJobSearch(Request $request)
    {
        $status = array();

        try
        {
            //get rules from validator class:
            /*there is no need to guard this, 
            interns not logged in can still search for jobs...*/
            $reqRules = $this->generaljobSearchRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $jobDetailsFound = $this->InternGeneralJobsSearchService();
            if( empty($jobDetailsFound) ) 
            {
                throw new \Exception("Jobs Not Found, Please search again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Jobs Found!',
                'jobs' => $jobDetailsFound
            ];

        }catch(\Exception $ex)
        {

            $status = [
                'code' => 0,
                'serverStatus' => 'Job Not Posted Yet!',
                'short_description' => $ex->getMessage(),
            ];

        }//finally{
            return response()->json($status, 200);
        //}
    }

    
    public function JobApply(Request $request)
    {
        $status = array();

        try{
            //get rules from validator class:
            /*there is no need to guard this, 
            interns not logged in can still search for jobs...*/
            $reqRules = $this->jobApplyRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            //this should return in chunks or paginate:
            $intern_has_applied = $this->InternJobsApplyService($request);
            if(!$intern_has_applied) {
                throw new \Exception("Job Application not Successful. Try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Job Application Successful!',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'Application Unsuccessful!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    public function ViewAllJobsApplied(Request $request)
    {
        $status = array();
        try
        {
            //get rules from validator class:
            /*there is no need to guard this, 
            interns not logged in can still search for jobs...*/

            $reqRules = $this->viewAllJobsAppliedRequestRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $details_found = $this->InternViewAllJobsAppliedService($request);
            if( empty($details_found) ) 
            {
                throw new \Exception("No Job Application Details were found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Job Application Details found!',
                'detailsFound' =>  $details_found
            ];

        }
        catch(\Exception $ex)
        {

            $status = [
                'code' => 0,
                'serverStatus' => 'Retrieval Error!',
                'short_description' => $ex->getMessage()
            ];

        }
        finally
        {
            return response()->json($status, 200);
        }
    }

    //Employer won't see a deactivated application: 
    public function ChangeJobApplyStatus(Request $request)
    {
        $status = array();
        try{

            $reqRules = $this->changeJobApplyStatusRequestRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $status_changed = $this->InternChangeJobApplyStatusService($request);
            if( !$status_changed ) {
                throw new \Exception("Error in changing application status.");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Application Status Changed!',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'Could not change application Status!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }

    }

    public function DeleteJobApply(){

        $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->deleteJobApplyRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails()){
            throw new \Exception("Access Error, Not logged in yet!");
         }

         //this should return in chunks or paginate:
         $has_details_deleted = $this->InternsDeleteJobApplyService($request);
         if(!$has_details_deleted){
            throw new \Exception("Details not deleted successfully!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Application Withdrawn successfully!',
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Withdrawal Unsuccessful!',
            'short_description' => $ex->getMessage()
         ];

      }finally{
         return response()->json($status, 200);
      }

    }
        
}
