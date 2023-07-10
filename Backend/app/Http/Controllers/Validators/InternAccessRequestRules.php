<?php

namespace App\Http\Controllers\Validators;

trait InternAccessRequestRules {

	protected function registerRules(): array
    {

		//set validation rules:
        $rules = [

            'firstname' => 'required | different:lastname',
            'lastname' => 'required | different:firstname',
            'email' => 'different:username,firstname,lastname', //unique:intern' - this should be validated during login,
            'username' => 'required | different:email,firstname,lastname', //unique:intern' - this should be validated during login,
            'password' => 'required | min:7 | max:15', //confirmed | unique:intern - this should be validated during login,


            //optionals:
            /*'resume' => 'nullable | file | image | mimes:pdf,msword,jpg,png | nullable',
            'picture' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'cover_letter' => 'nullable | string | min:5 | max:1000', //size:1000',
            'institution' => 'nullable | string | different:firstname,lastname,cover_letter',
            'course_of_study' => 'nullable | string | different:firstname,lastname,cover_letter,institution',
            'current_school_grade' => 'nullable | numeric',
            'internship_letter_img' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'skillsets' => 'nullable | json ',
            'years_of_experience' => 'nullable | numeric',
            'experiences' => 'nullable | json', //unique:intern',
            'job_preferences' => 'nullable | json'*/

        ];

        return $rules;
    }

    protected function loginRules(): array
    {
		//set validation rules:
        $rules = [
            'email_or_username' => 'required | different:password',
            'password' => 'required | min:7 | max:15 | different:email_or_username'
        ];

        return $rules;
    }

    protected function forgotPassRules():array
    {
        //set validation rules:
        $rules = [
            'email_or_username' => 'required | different:new_pass',
            'new_pass' => 'required | alpha_num | min:7 | max:15 | different:email_or_username'
        ];

        return $rules;
    }

    protected function updateLoginStateRules(): array 
    {
        $rules =  [
            'intern_id'=>'required | exists:interns',
            'is_logged_in'=> 'required | bool',
        ];
        return $rules;
    }

     protected function confirmLoginStateRules(): array
     {
        $rules =  [
            'intern_id'=>'required | exists:interns',
        ];
        return $rules;
     }

    protected function editRules():array
    {

        //set validation rules:
        $rules = [
            //'intern_id' => 'required',

            'institution' => 'required ',
             'course_of_study' => 'required | different:institution',
             'year_or_level' => 'required | numeric',
             'current_school_grade' => 'required',
             'current_location' => 'required',
             'preferred_job_locations' => 'required',
             'years_of_experience' => 'required | numeric',
             'skillsets' => 'required',

            /*'resume' => 'nullable | file | image | mimes:pdf,msword,jpg,png | nullable',
            'profile_picture' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400'
            'cover_letter' => 'nullable | string | min:5 | max:1000',
            
           
            'current_school_grade' => 'nullable | numeric',
            /*'internship_letter_img' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'experiences' => 'nullable | json', //unique:intern',
            'job_preferences' => 'nullable | json'*/
        ];

        return $rules;

    }

    protected function filesAndImagesRules(): array{

        //set validation rules:
        $rules = [
            'username' => 'nullable | different:email',
            'email' => 'nullable | email | different:username',
            'intern_id' => 'required | unique: interns',
            'resume' => 'nullable | file | image | mimes:pdf,msword,jpg,png | nullable',
            'profile_picture' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'internship_letter_img' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }


    protected function logoutRules(): array
    {
        //set validation rules:
        $rules = [
            'intern_id' => 'required | unique: interns',
            'is_logged_in' => 'required | bool'
        ];

        return $rules;
    }

}

?>
