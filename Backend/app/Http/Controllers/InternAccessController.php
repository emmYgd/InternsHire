<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Validators\InternAccessRequestRules;

use App\Services\Interfaces\InternAccessInterface;
use App\Services\Traits\ModelAbstraction\InternAccessAbstraction;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

final class InternAccessController extends Controller implements InternAccessInterface
{
    use InternAccessRequestRules;
    use InternAccessAbstraction;
    use PassHashVerifyService;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Intern Object:
        //public $intern = new Intern;
    }


    public function Register(Request $request): JsonResponse
    {
        $status = array();
        try
        {
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
            $is_details_saved = $this->InternCreateAllService($request->all());

            if(!$is_details_saved)
            {
                throw new \Exception("Your details could not be registered. Please try again!");
            }

            //since password can't be saved through mass assignment, so save specific:
            $hashedPass = $this->HashPassword($request->password);

            //unique id can't be saved through mass assignment, so save specific:
            $uniqueID = $this->genUniqueAlphaNumID();

            $queryKeysValues = [
                'email' => $request->email
            ];

            $newKeysValues = [
                'password' => $hashedPass,
                'intern_id' => $uniqueID
            ];

            $pass_id_has_saved = $this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$pass_id_has_saved)
            {
                throw new \Exception("Your details could not be registered. Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'CreationSuccess!',
                'intern_id' => $uniqueID
            ];

        }catch(\Exception $ex)
        {
            //$duplicationWarning3 = 'SQLSTATE[23000]';
            //$duplicationWarning1 = 'Integrity constraint violation';
            $duplicationWarning2 = '1062 Duplicate entry';

            $status = [
                'code' => 0,
                'serverStatus' => 'CreationError!',
                'short_description' => $ex->getMessage(),
            ];

            if(
                str_contains($status['short_description'], $duplicationWarning2)
            )
            {
                $status["warning"] = "One of the Supplied Fields have been used! Edit Either Your Email, Username or Password.";

                /*foreach($request->all() as $reqKey => $reqValue)
                {
                    //count the number of occurrence of each request value in the warning :
                    //init:
                    $count = substr_count($status['short_description'], $reqValue);
                    //$status["warnings"] = $count;
                    if($count < -1)
                    {
                        for($index=0; $index<=array_count_values($request->all()); $index++)
                        {
                            $status["warnings"][$index++] = "${$reqKey} has been used! Please input another.";
                        }
                    }
                }*/
            }

        }finally
        {
            return response()->json($status, 200);
        }

    }


    public function LoginDashboard(Request $request): JsonResponse
    {

        $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->loginRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Invalid Input provided!");
            }

            $detailsFound = $this->InternDetailsFoundService($request);

            //verify password in the details found:
            $is_pass_verified = $this->VerifyPassword($request->password, $detailsFound['password']);
            if(!$is_pass_verified)
            {
                throw new \Exception("Failed login attempt. Invalid Password Provided!");
            }

            //set query:
            $uniqueToken = $detailsFound['intern_id'];
            $queryKeysValues = ['intern_id' => $uniqueToken];

            //set the is_logged_in status as true:
            $newKeysValues = ['is_logged_in' => true];

            $change_login_status = $this->InternUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$change_login_status)
            {
                throw new \Exception("Failed login attempt. Please try again");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Found!',
                'uniqueToken' => $uniqueToken,
                'is_logged_in' => $change_login_status
            ];

        }catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'loginFailed!',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
    }


    public function ForgotPassword(Request $request): JsonResponse
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

            $has_updated = $this->InternUpdatePasswordService($request);

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

    public function ConfirmLoginState(Request $request): JsonResponse
    {
         $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->confirmLoginStateRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new \Exception("Invalid Input provided!");
            }

            $intern_id = $request->input('intern_id');

            $has_logged_in = $this->InternConfirmLoginStateService($intern_id);
            if($has_logged_in == false)
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
                'short_description' => $ex->getMessage(),
            ];

        }
        /*finally
        {}*/
            return response()->json($status, 200);
    }

    public function UpdateLoginState(Request $request): JsonResponse
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

            $has_logged_in = $this->InternUpdateLoginStateService($request);
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
                'short_description' => $ex->getMessage(),
            ];

        }
        finally
        {
            return response()->json($status, 200);
        }
    }


    public function EditProfile(Request $request): JsonResponse
    {
         $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->editRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $details_has_saved = $this->InternUpdateEachService($request);
            if(!$details_has_saved/*false*/)
            {
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
                'short_description' => $ex->getMessage(),
            ];

        }//finally{
            return response()->json($status, 200);
        //}
    }


    //tested with get but not with put...
    public function EditFilesAndImages(Request $request):  JsonResponse
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
            $files_has_saved = $this->InternSaveFilesService($request);
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


    public function Logout(Request $request):  JsonResponse
    {

         $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->logoutRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            $has_logged_out = $this->InternUpdateLoginStateService($request);
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

?>
