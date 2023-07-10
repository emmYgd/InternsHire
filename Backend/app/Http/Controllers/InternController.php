<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Validators\InternRequestRules;
use App\Services\Interfaces\InternInterface;
use App\Services\Traits\ModelAbstraction\InternAccessAbstraction;
use App\Services\Traits\ModelAbstraction\InternAbstraction;



final class InternController extends Controller //implements InternInterface
{
    use InternRequestRules;
    use InternAccessAbstraction;
    use InternAbstraction;

    public function __construct()
    {
        //$this->createAdminDefault();
    }

    public function InternGetOwnDetails(Request $request=null, string $currentInternID=''): JsonResponse
    {
        $status = array();

        try{
            //get rules from validator class:
            $reqRules = $this->internGetOwnDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $detailsFound = $this->InternGetOwnDetailsService($currentInternID);
            if( empty($detailsFound) )
            {
                throw new \Exception("Intern Details Not Found");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'currentInternDetailsFound',
                'intern' => $detailsFound
            ];

        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'currentInternDetailsNotFound',
                'short_description' => $ex->getMessage()
            ];

        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}

    }

    public function InternUpdateDetails(Request $request): JsonResponse
    {
        $status = array();

        try{
            //get rules from validator class:
            $reqRules = $this->internUpdateDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $details_has_updated = $this->InternUpdateDetailsService($request);
            if(!$details_has_updated)
            {
                throw new \Exception("Intern Details Not Updated Successfully!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'UpdateSuccess!',
            ];

        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'UpdateError!',
                'short_description' => $ex->getMessage()
            ];

        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}

    }

    public function InternSearchEmployers(Request $request=null, string $currentInternID=''): JsonResponse
    {
        $status = array();

        try{
            //get rules from validator class:
            $reqRules = $this->internSearchRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $detailsFound = $this->InternSearchAllEmployersService();
            if( empty($detailsFound) ){
                throw new \Exception("Employers not Found");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'employersFound',
                'employers' => $detailsFound
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'employersNotFound',
                'short_description' => $ex->getMessage()
            ];

        }//finally{
            return response()->json($status, 200);
        //}

    }

    //interns must have searched for employers (each having a unique id before being able to comment:)
    public function CommentRateEmployers(Request $request): JsonResponse
    {
        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->commentRateRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

             //create without mass assignment:
            $is_details_saved = $this->InternCommentRateEmployers($request);
            if(!$is_details_saved/*false*/){
                throw new \Exception("Details not saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'commentRatingsSaved',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'commentRatingsNotSaved',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }

    }


}
