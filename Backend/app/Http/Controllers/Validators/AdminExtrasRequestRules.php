<?php

namespace App\Http\Controllers\Validators;

trait AdminExtrasRequestRules {


    protected function setSkillsTestsRules(): array
    {

		//set validation rules:
        $rules = [
            'admin_id' => 'required | unique:admins',
            'test_skill_name' => 'required',
            'duration' => 'required',//this should be in form of time,
            'instruction' => 'required',
            'hints' => 'required | different:instruction',
            'all_test_number' => 'required | numeric',
            'question' => 'required',
            'options' => 'required | json',
            'answer' => 'required',
            'max_attempt_count' => 'nullable',//interns cannot take the test when it is more than this...
            'pass_mark' => 'nullable | numeric'

        ];
        return $rules;
    }


    protected function updateSkillsTestsRules(): array
    {
        //set validation rules:
        $rules = [

            'admin_id' => 'required | unique:admins',
            'assessment_id' => 'required | unique:assessments'
            'test_skill_name' => 'nullable',
            'duration' => 'nullable',//this should be in form of time,
            'instruction' => 'nullable',
            'hints' => 'nullable | different:instruction',
            'all_test_number' => 'nullable | numeric',
            'question' => 'nullable',
            'options' => 'nullable | json',
            'answer' => 'nullable',
            'max_attempt_count' => 'nullable',
            'pass_mark' => 'nullable | numeric'
        ];

        return $rules;
    }


    protected function viewAllSkillsTestsRules(): array
    {
        //set validation rules:
        $rules = [
            'admin_id' => 'required | unique:admins',
        ];

        return $rules;
    }


    protected function deleteSkillsTestsRules(): array
    {
        //set validation rules:
        $rules = [
            'admin_id' => 'required | unique:admins',
            'assessment_id' => 'requied | unique:assessments',
        ];

        return $rules;
    }


}