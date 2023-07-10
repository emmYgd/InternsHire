<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Validators\EmployerAccessRequestRules;

use App\Services\Interfaces\EmployerAccessInterface;
use App\Services\Traits\ModelAbstraction\EmployerAbstraction;
use App\Services\Traits\ModelAbstraction\EmployerAccessAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;


class EmployerAccessController extends Controller //implements EmployerInterface
{

    use EmployerAccessRequestRules;
    use EmployerAccessAbstraction;
    use EmployerAbstraction;
    use ComputeUniqueIDService;
    use PassHashVerifyService;
    
    public function __construct()
    {
        //$this->createAdminDefault();
    }
    

    public function register(Request $request): JsonResponse 
    {

        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->registerRules();

            //first validate the requests:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                //throw Exception:
                throw new \Exception("Invalid Input provided!");
            }

            //pass the validated value to the Model Abstraction Service: 
            $is_details_saved = $this->EmployerCreateAllService($request->all());

            if(!$is_details_saved){
                throw new \Exception("Your details could not be registered. Please try again!"); 
            }

            //since password can't be saved through mass assignment, so save specific:
            $hashedPass = $this->HashPassword($request->input('password'));

            //unique id can't be saved through mass assignment, so save specific:
            $uniqueID = $this->genUniqueAlphaNumID();

            $queryKeysValues = [
                'email' => $request->input('email'),
            ];

            $newKeysValues = [ 
                'password' => $hashedPass, 
                'employer_id' => $uniqueID,
            ];

            $are_pass_id_saved = $this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$are_pass_id_saved){
                throw new \Exception("Your details could not be registered. Please try again!"); 
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'CreationSuccess!',
                'employer_id' => $uniqueID,
            ];

        }catch(\Exception $ex){

            $duplicationWarning1 = "Integrity constraint violation";
            $duplicationWarning2 = "SQLSTATE[23000]";

            $status = [
                'code' => 0,
                'serverStatus' => 'CreationError!',
                'short_description' => $ex->getMessage()
            ];

            if( 
                ($status['short_description']).str_contains($duplicationWarning1, $duplicationWarning2) 
            )
            {
                $status['warning'] = 'One of the unique fields have been used!';
            }

        }//finally{

            return response()->json($status, 200);

        //}

    }


    public function loginDashboard(Request $request): JsonResponse
    {

        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->loginRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $detailsFound = $this->EmployerDetailsFoundService($request);

            //verify password in the details found:
            $is_pass_verified = $this->VerifyPassword($validatedPass, $detailsFound['password']);
            if(!$is_pass_verified){
                throw new \Exception("Failed login attempt. Invalid Password Provided!");
            }

            //set query:
            $uniqueToken = $detailsFound['employer_id'];
            $queryKeysValues = ['employer_id' => $uniqueToken];

            //set the is_logged_in status as true:
            $newKeysValues = ['is_logged_in' => true];

            $change_login_status = $this->EmployerUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$change_login_status){
                throw new \Exception("Failed login attempt. Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Found',
                'uniqueToken' => $uniqueToken
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'loginFailed',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    public function forgotPassword(Request $request): JsonResponse
    {

        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->forgotPassRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $has_updated = $this->EmployerUpdatePasswordService($request);

            if(!$has_updated){
                throw new \Exception("Password could not be changed");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'passUpdated',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'updateFailed',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }
    
    //after login, must provide the employer_id token:
    public function editProfile(Request $request): JsonResponse
    {
         $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->editRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $is_details_saved = $this->EmployerUpdateEachService($request);
            if(!$is_details_saved/*false*/){
                throw new \Exception("Details not saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'DetailsSaved!',
            ];

        }
        catch(\Exception $ex)
        {

            $status = [
                'code' => 0,
                'serverStatus' => 'DetailsNotSaved!',
                'short_description' => $ex->getMessage()
            ];

        }//finally{
            return response()->json($status, 200);
        //}
    }


    //tested with get but not with put...
    public function editFilesAndImages(Request $request):  JsonResponse
    {
        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->filesAndImagesRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $files_has_saved = $this->EmployerSaveFilesService($request);
            if(!$files_has_saved/*false*/){
                throw new \Exception("File Details not saved!");
            }

             $status = [
                'code' => 1,
                'serverStatus' => 'filesSaved',
                //'requestLists' => $request->all()
            ];

        }catch(\Exception $ex){

             $status = [
                'code' => 0,
                'serverStatus' => 'filesNotSaved',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }

    }

    public function updateLoginState(Request $request): JsonResponse
    {
         $status = array();
        
        try
        {
            //get rules from validator class:
            $reqRules = $this->updateLoginStateRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Invalid Input provided!");
            }

            $has_logged_in = $this->EmployerUpdateLoginStateService($request);
            if(!$has_logged_in/*false*/)
            {
                throw new \Exception("Not logged in yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'loggedIn',
            ];

        }
        catch(\Exception $ex)
        {

             $status = [
                'code' => 0,
                'serverStatus' => 'notLoggedIn',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    public function logout(Request $request):  JsonResponse
    {
        $status = array();
        
        try
        {
            //get rules from validator class:
            $reqRules = $this->logoutRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $has_logged_out = $this->EmployerUpdateLoginStateService($request);
            if(!$has_logged_out/*false*/){
                throw new \Exception("Not logged out yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'loggedOut',
            ];

        }catch(\Exception $ex){

             $status = [
                'code' => 0,
                'serverStatus' => 'notLoggedOut',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }

}
