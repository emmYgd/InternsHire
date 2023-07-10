<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\EmployerInterface;
use App\Services\Traits\ModelAbstraction\EmployerJobsAbstraction;

use App\Http\Controllers\Validators\EmployerJobsRequestRules;

final class EmployerJobsController extends Controller //implements EmployerInterface
{
   use EmployerJobsAbstraction;
   use EmployerJobsRequestRules;

   public function __construct()
   {
        //$this->createAdminDefault();
   }


   public function PostJobs(Request $request): JsonResponse
   {
      $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->postJobsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new \Exception("Invalid Input provided!");
         }

         //this should return in chunks or paginate:
         $is_job_posted = $this->EmployerPostJobsService($request);
         if(!$is_job_posted) {
            throw new \Exception("Job not posted!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Job Posted Successfully!',
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Job Not Posted Yet!',
            'short_description' => $ex->getMessage()
         ];

      }//finally{
         return response()->json($status, 200);
      //}

   }


   public function ChangeJobPosted(Request $request): JsonResponse
   {
      $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->changeJobPostedRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails()){
            throw new \Exception("Invalid Input Provided!");
         }

         $is_details_saved = $this->EmployerChangeJobPostedService($request);
         if(!$is_details_saved){
            throw new \Exception("Employers not Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Job Details Saved Successfully!'
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Job Details Saved Not Saved Yet!',
            'short_description' => $ex->getMessage()
         ];

      }finally{
         return response()->json($status, 200);
      }

    }


    public function ViewAllJobPosts(Request $request): JsonResponse
    {
      $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->viewAllJobPostsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails()){
            throw new \Exception("Access Error, Not logged in yet!");
         }

         //this should return in chunks or paginate:
         $detailsFound = $this->EmployerSearchAllJobPostsService($request);
         if( empty($detailsFound) ){
            throw new \Exception("Employers not Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Jobs Found!',
            'employers' => $detailsFound
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Jobs Not Found!',
            'short_description' => $ex->getMessage()
         ];

      }finally{
         return response()->json($status, 200);
      }

   }

   public function DeleteJobPost(Request $request): JsonResponse
   {
      $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->deleteJobPostRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails()){
            throw new \Exception("Access Error, Not logged in yet!");
         }

         //this should return in chunks or paginate:
         $has_details_deleted = $this->EmployerDeleteJobPostService($request);
         if(!$has_details_deleted){
            throw new \Exception("Details not deleted successfully!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Job Post Deleted',
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Job Post Not Deleted Yet!',
            'short_description' => $ex->getMessage()
         ];

      }finally{
         return response()->json($status, 200);
      }

   }


   public function DelayJobPost(Request $request): JsonResponse
   {
      $status = array();

      try{
         //get rules from validator class:
         $reqRules = $this->delayJobPostRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails()){
            throw new \Exception("Access Error, Not logged in yet!");
         }

         //this should return in chunks or paginate:
         $is_job_delayed = $this->EmployerDelayJobPostService($request);
         if( !$is_job_delayed ){
            throw new \Exception("Error! This job has not been delayed!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'Job Post Delayed!',
         ];

      }catch(\Exception $ex){

         $status = [
            'code' => 0,
            'serverStatus' => 'Job Not Delayed Yet!',
            'short_description' => $ex->getMessage()
         ];

      }finally{
         return response()->json($status, 200);
      }
   }

}
