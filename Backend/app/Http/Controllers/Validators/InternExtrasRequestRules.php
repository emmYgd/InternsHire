<?php

namespace App\Http\Controllers\Validators;

trait AdminExtrasRequestRules 
{
    protected function loadSkillsTestsRules(): array
    {
		//set validation rules:
        $rules = [
            'intern_id' => 'required | unique:interns',
            'test_skill_name' => 'required'
        ];

        return $rules;
    }


    protected function submitMarkSkillsTestsRules(): array
    {
        //set validation rules:
        $rules = [
            'intern_id' => 'required | unique:interns',
            'test_submit_details' => 'required | json',
            /*key/value pairs for questions and answers
            {
                'one': {
                    'question': '',
                    'intern_answer' : '',
                },

                'two':{
                    'question' : '',
                    'intern_answer' : '',
                }

            }*/
        ];

        return $rules;
    }


    protected function viewAllAttemptedTestsRules(): array
    {
        //set validation rules:
        $rules = [
            'intern_id' => 'required | unique:interns',
        ];

        return $rules;
    }

}
