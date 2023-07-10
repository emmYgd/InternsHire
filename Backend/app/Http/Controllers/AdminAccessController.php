<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Validators\AdminAccessRequestRules;

use App\Services\Interfaces\AdminAccessInterface;
use App\Services\Traits\ModelAbstraction\AdminAbstraction;

final class AdminAccessController extends Controller implements AdminAccessInterface
{
    use AdminAccessRequestRules;
    use AdminAbstraction;
    
    public function __construct()
    {
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

            $detailsFound = $this->AdminDetailsFoundService($request);

            //verify password in the details found:
            $is_pass_verified = $this->VerifyPassword($validatedPass, $detailsFound['password']);
            if(!$is_pass_verified){
                throw new \Exception("Failed login attempt. Invalid Password Provided!");
            }

            //set query:
            $uniqueToken = $detailsFound['admin_id'];
            $queryKeysValues = ['admin_id' => $uniqueToken];

            //set the is_logged_in status as true:
            $newKeysValues = ['is_logged_in' => true];

            $change_login_status = $this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$change_login_status){
                throw new \Exception("Failed login attempt. You are not an Admin.");

                //fire an event to send a mail to the admin here to report of this failed attempt..
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
    

    public function editProfile(Request $request): JsonResponse
    {
         $status = array();

        try{

            //get rules from validator class:
            $reqRules = $this->editRules();

            //validate here:'new_pass'
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails()){
                throw new \Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $is_details_saved = $this->AdminUpdateEachService($request);
            if(!$is_details_saved/*false*/){
                throw new \Exception("Details not saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'detailsSaved',
            ];

        }catch(\Exception $ex){

            $status = [
                'code' => 0,
                'serverStatus' => 'detailsNotSaved',
                'short_description' => $ex->getMessage()
            ];

        }finally{
            return response()->json($status, 200);
        }
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
            $files_has_saved = $this->AdminSaveFilesService($request);
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


    public function logout(Request $request):  JsonResponse
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

            $has_logged_out = $this->AdminUpdateLoginStateService($request);
            if(!$has_logged_out/*false*/){
                throw new \Exception("Not logged out yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'loggedOut',
            ];

            //redirect on the frontend on receiving this... 

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
