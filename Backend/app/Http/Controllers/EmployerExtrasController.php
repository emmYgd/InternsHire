<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Validators\EmployerExtrasRequestRules;
use App\Services\Interfaces\EmployerInterface;
use App\Services\Traits\EmployerAbstractionService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployerExtrasController extends Controller implements EmployerInterface
{
    use EmployerAbstractionService;
    use EmployerExtrasRequestRules;

    //This makes it possible for the admin to take charge and include the testing process before employee can submit their details:
    protected function OutsourceRecruitment(): JsonResponse
    {
        $status = array();

        try{
            //get rules from validator class:
            $reqRules = $this->outsourceRecruitmentRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $employer_has_outsourced = $this->EmployerOutsourceRecruitmentService($request);
            if(!$employer_has_outsourced) {
                throw new \Exception("Employer's Intentions to delegate recruitment not registered yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Recruitment Delegated Successfully!',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'Recruitment Outsource Error!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }

    }

    protected function 


}
