<?php 

namespace App\Services\Traits\ModelAbstraction;

use App\Models\AssessmentCRUD;
use App\Services\ModelCRUD\AssessmentAbstraction;

u//se App\Services\Utilities\ComputeUniqueIDService;
//use App\Services\Traits\Utilities\PassHashVerifyService;

use Illuminate\Http\Request;

trait AdminExtrasAbstraction
{   
    //inherits all their methods:
    use AssessmentCRUD;
    use AssessmentAbstraction;
    //use ComputeUniqueIDService;
    //use PassHashVerifyService;

    protected function AdminCreateTestService(Request $request): bool
    {
        //create through mass assignment
        $testDetails = $request->all();
        $is_tests_saved = $this->AssessmentCreateAllService($testDetails);

        return $is_tests_saved;
    }


    //update each fields without mass assignment: Specific Logic
    protected function AdminUpdateTestService(Request $request): bool
    {
        $admin_id = $request->admin_id;
        if($admin_id !== "")
        {
            $request = $request->except('admin_id', 'assessment_id');

            $queryKeysValues = [
                'admin_id' => $request->admin_id,
                'id' => $request->assessment_id,
            ];

            //initialize:
            $newKeysValues = array();

            foreach($request as $reqKey => $reqValue)
            {
                if(is_array($reqValue))
                {
                    //Note: the json encode here can be casted in the Models settings but left here for uniformity purposes:
                    $newKeysValues = [$reqKey => json_encode($reqValue)];
                }else
                {
                    $newKeysValues = [$reqKey => $reqValue];
                }

                $this->AssessmentUpdateSpecificService($queryKeysValues, $newKeysValues);
            }
        }

        return true;

    }


    protected function AdminViewAllTestsService(Request $request): array 
    {
        //view:
        $admin_id = $request->admin_id;
        $queryKeysValues = ['admin_id' => $admin_id];

        $testDetails = $this->AssessmentReadAllLazyService();

        return $testDetails; 
    }


    protected function AdminDeleteTestService(Request $request): bool
    {
        $queryKeysValues = [
            'intern_id' => $request->admin_id,
            'id' => $request->assessment_id,
        ];
        $is_details_deleted = $this->AssessmentDeleteSpecificService($queryKeysValues);
        return $is_details_deleted;   
    }


}

?>