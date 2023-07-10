<?php

namespace App\Http\Controllers\Validators;

trait InternRequestRules {

  protected function internGetOwnDetailsRules(): array
  {
    //set validation rules: no rules, this is a get request
    $rules = [
      //'intern_id' => 'required | alpha_num | unique: interns | size:20',
        /*'employer_id' => 'required | alpha_num | unique:employers | size0',*/
    ];

    return $rules;
  }

  protected fucntion internUpdateDetailsRules(): array
  {
    $rules = [
        'intern_id' => 'required | alpha_num | exists: interns',
        'firstname' => 'nullable | string | different:lastname,username',
        'lastname' => 'nullable | string | different:firstname,username',
        'username' => 'nullable | string | different:firstname,lastname',
        'email' => 'nullable | email',
        'phone_number'=> 'nullable',
        'gender'=> 'nullable | string',
        'age'=> 'nullable | numeric',
        'occupation'=> 'nullable | string',
        'location' => 'nullable | string',
        'address' => 'nullable | string',
        'institution' => 'nullable | string',
        'course_of_study' => 'nullable | string',
        'year_or_level' => 'nullable | numeric',
        'grade'=> 'nullable | numeric',
        'years_of_experience' => 'nullable | numeric',
        'preferred_job_location' => 'nullable | string',
    ];

    return $rules;
  }

  protected function internSearchRules(): array
  {
    //set validation rules: no rules, this is a get request
    $rules = [
      //'intern_id' => 'required | alpha_num | unique: interns | size:20',
        /*'employer_id' => 'required | alpha_num | unique:employers | size0',*/
    ];

    return $rules;
  }

  protected function commentRateRules(): array
  {
    //set validation rules:
    $rules = [
      'intern_id' => 'required | alpha_num | unique: interns | size:20 ',
      'employer_id' => 'required | alpha_num | unique:employers | size:20',
      'comment' => 'nullable | min: 5| max: 1000',
      'rate' => 'nullable | numeric'
    ];

    return $rules;
  }

}
