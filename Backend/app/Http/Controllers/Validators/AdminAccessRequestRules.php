<?php

namespace App\Http\Controllers\Validators;

trait AdminAccessRequestRules {

    protected function loginRules(): array
    {

		//set validation rules:
        $rules = [
            'email_or_username' => 'nullable | different:password',
            'password' => 'required | alpha_num | min:7 | max:15 | different:email_or_username'
        ];

        return $rules;

    }

    protected function editRules():array
    {

        //set validation rules:
        $rules = [
            'admin_id' => 'required | unique:admins'
            'admin_org' => 'nullable | string | min:5 | max:1000',
            'vision' => 'nullable | string | different:admin_org',
            'mission' => 'nullable | string | different:vision,admin_org',
            'year_of_establishment' => 'nullable | numeric'

            'skillsets' => 'nullable | json',
            'years_of_experience' => 'nullable | numeric',
            'experiences' => 'nullable | json', //unique:admin',
            'job_preferences' => 'nullable | json'
        ];

        return $rules;

    }

    protected function filesAndImagesRules(): array
    {

        //set validation rules:
        $rules = [

            'admin_id' => 'required | unique: admins',
            'logo' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',

        ];

        return $rules;
    }


    protected function logoutRules(): array
    {

        //set validation rules:
        $rules = [
            'admin_id' => 'required | unique: admins',
            'is_logged_in' => 'required | bool'
        ];

        return $rules;
    }

    

}

?>