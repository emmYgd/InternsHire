<?php

namespace App\Http\Controllers\Validators;

trait EmployerJobsRequestRules {

	protected function postJobsRules(): array
	{
		//set validation rules:
        $rules = [
        	//'employer_id' => 'required | unique:employers | size:20', 
            //'owner' => 'required',
           /* 'job_title' => 'required',
            'job_description' => 'required | different:job_title',
            'job_requirement' => 'required | different:job_title,job_title',
            'internship_period' => 'required',
            'date_expired' => 'required | ', 
            'expected_start' => 'nullable | string',
            'location_type' => 'nullable | different:nature',//remote or on-site 
            'nature' => 'nullable | different:address',//full-time or part-time
            'address' => 'nullable | different:state',
            'state' => 'nullable | different:country',
            'currency_of_payment' => 'nullable',//USD, EUR, NGN 
            'salary_or_incentives' => 'nullable',
            'is_delayed' => 'nullable | bool'*/
        ];

        return $rules;   
    }


    protected function changeJobPostedRules(): array
    {

        $rules = [
		      //set validation rules:
            'employer_id' => 'nullable | unique:employers | size:20', 
            'expected_start' => 'nullable | json',
            'location_type' => 'nullable | different:nature',//remote or on-site 
            'nature' => 'nullable | different:address',//full-time or part-time
            'address' => 'nullable | different:state',
            'state' => 'nullable | different:country',
            'currency_of_payment' => 'nullable',//USD, EUR, NGN 
            'salary_or_incentives' => 'nullable',
            'is_delayed' => 'required | bool',

        ];

        return $rules;

    }


    protected function viewAllJobPostsRules():array
    {
        //set validation rules:
        $rules = [
            'employer_id' => 'required | unique:employers | size:20',
        ];

        return $rules;
    }


    //edit important fields after login: all the nullable fields must now be compulsory:
    protected function editProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'employer_id' => 'required | unique:employers',
            'industry' => 'required',
            'category' => 'required',
            'unit_handling_recruitment' => 'required', //HR, Outsourced, or Founder
            'brief_details' => 'required | min:5, max:100', //what the company does, aims and objectives(brief)
            'salary_range' => 'required | json', //from/to - average salary willing to pay interns at this time
    		'online_presence' => 'required | json', //including: website, facebook, twitter, linkedin, etc
        ];
        return $rules;
    }


    protected function deleteJobPostRules(): array
    {

        //set validation rules:
        $rules = [
            'employer_id' => 'required | unique: employers',
            'job_post_id' => 'required | unique: jobs'
        ];

        return $rules;
    }


    protected function delayJobPostRules(): array
    {

        //set validation rules:
        $rules = [
            'employer_id' => 'required | unique: interns',
            'job_post_id' => 'required | unique: jobs',
            'is_delayed' => 'required | bool'
        ];

        return $rules;
    }

}
