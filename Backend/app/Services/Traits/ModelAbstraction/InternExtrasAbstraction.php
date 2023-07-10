<?php 

namespace App\Services\Traits\ModelAbstraction;

use App\Models\AssessmentCRUD;
use App\Services\ModelCRUD\AssessmentAbstraction;

u//se App\Services\Utilities\ComputeUniqueIDService;
//use App\Services\Traits\Utilities\PassHashVerifyService;

use Illuminate\Http\Request;

trait InternExtrasAbstraction
{   
    //inherits all their methods:
    use AssessmentCRUD;
    use AssessmentAbstraction;
    //use ComputeUniqueIDService;
    //use PassHashVerifyService;

    protected function InternLoadTestsQuestionsOptionsService(Request $request): any 
    {
        //view:
        $intern_id = $request->intern_id;

        if($intern_id !== ""){ 

            $queryKeysValues = ['test_skill_name' => $request->test_skill_name];

            $allTestDetails = $this->AssessmentReadSpecificAllLazyService($queryKeysValues);

            //check if this interns have attempted this test more than the number of times set by the Admin:
            $admin_max_attempt = $allTestDetails->max_attempt_times;

            //now check the number of attempts of this intern:
            $attempt_details = $allTestDetails->intern_assessment_attempts->where(['intern_id' => $intern_id])->get();
            $attempt_times = $attempt_details->attempt_times;

            if($attempt_times >== $admin_max_attempt)
            {
                return false;
            }

            //else, return questions and options:

            return $allTestDetails;
 
        }
    }


    protected function InternSubmitMarkTestsService(Request $request): any
    {
        $intern_id = $request->intern_id;
        if($intern_id !== "")
        {
            $filteredRequest = $request->except('intern_id');

            $assessment_id = $request->assessment_id;

            //initialize:
            $queryKeysValues = array();
            $updateKeysValues = array();
            $newKeysValues = array();


            $user_QA = array();
            $results = array();

            foreach($filteredRequest as $reqKey => $reqValue)
            {
                if(!is_array($reqValue))
                {   
                    //enter the inner array loop of question and answer:
                    $user_QA = json_decode($reqValue);
                }else
                {
                    $user_QA = $reqValue;
                    //now loop through the QA array again:
                    for($user_QA as $QA_key => $QA_value)
                    {
                        $question = $QA_key['question'];
                        $intern_answer = $QA_key['intern_answer'];

                        //start CRUD in database:

                        //STEP1 - first update the attempt count:

                        $queryKeysValues = ['id'=> $assessment_id];
                        $updateKeysValues = ['attempt_times' => 1 ];
                        $allAssessmentDetails = $this->AssessmentReadSpecificAllLazyService($queryKeysValues);

                        //use this opportunity to get the pass_mark field that the admin has entered - which will be used sometimes later:
                        $pass_mark = $allAssessmentDetails->pass_mark;

                        //now use this to update intern attempt count:
                         $allAssessmentDetails->intern_assessment_attempts()->update($updateKeysValues);

                        //if true:
                        //STEP2 - register intern_id for this question:

                        $queryKeysValues = ['question'=> $question];
                        $updateKeysValues = ['intern_id' => $intern_id];

                        $allAssessmentDetails = $this->AssessmentReadAllLazyService();

                        $allAssessmentDetails->intern_assessment_attempts()->where($queryKeysValues)->update($updateKeysValues);

                        //if true:
                        //STEP3 - start marking for this user by comparing with the answer column and recording the total mark and percentage:

                        $queryKeyValues = [
                            'intern_id' => $intern_id,
                            'question'=> $question,
                            'answer' => $intern_answer
                        ];

                        $correctAnswers =  $allAssessmentDetails->intern_assessment_attempts()->where($queryKeyValues);

                        $total_score = $correctAnswers->count();

                        //save the total score:
                        $correctAnswers->update(['test_score' => $total_score]);
                        //if true:
                        $correctAnswers->update(['percentage_score' => $total_score]);//this will be calculated in the Model settings by the mutatotors or accessors accordingly...

                        //if true;
                        //STEP 4 - update the has_passed status:
                        $new_percentage_score = $correctAnswers->percentage_score;
                        //$pass_mark has been obtained before hand.
                        $correctAnswers->update(['has_passed' => ($new_percentage_score >= $pass_mark ) ? true : false]);
                    }
                }
            }

            //check the database for results now:
            $results = [
                'test_score' => $total_score,
                'percentage_score' => $percentage_score,
                'has_passed' => $has_passed,
                'attempts_made' => $attempts_made,
            ];
        }

        return $results;
    }


    /*protected function InternViewAllAttemptedService(Request $request): any
    {
        $intern_id = $request->intern_id;
        if($intern_id !== "")
        {
            $request->intern_id
        }
    }*/
    
}