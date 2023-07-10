<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Interfaces\EmployerInterface;
use App\Services\Traits\ModelAbstraction\EmployerAbstraction;

final class EmployerController extends Controller //implements EmployerInterface
{
    use EmployerAbstractionService;

    use InternRequestRules;
    use InternAccessAbstraction;

    public function __construct()
    {
        //$this->createAdminDefault();
    }

    public function EmployerSearchInterns(Request $request): JsonResponse
    {
        $status = array();

        try{
            //get rules from validator class:
            $reqRules = $this->employerSearchRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $detailsFound = $this->EmployerSearchAllInternsService();
            if( empty($detailsFound) ){
                throw new \Exception("Employers not Found");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'internsFound',
                'employers' => $detailsFound
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'internsNotFound',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }

    }

    
    //interns must have searched for employers (each having a unique id before being able to comment:)
    public function CommentRateInterns(Request $request): JsonResponse 
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
            $is_details_saved = $this->EmployerCommentRateInterns($request);
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

