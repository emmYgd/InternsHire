<?php

namespace Database\Factories;

use App\Models\Intern;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Intern::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'intern_id' => $this->faker->uuid,
            'intern_chat_id' => $this->faker->uuid,
            'is_logged_in' => $this->faker->boolean,
            'username' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => $this->faker->sha1,
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            //'resume' => $this->faker->
            'picture' => $this->faker->imageUrl('640', '480', 'cats'),
            'cover_letter' =>  $this->faker->text,
            'institution' => $this->faker->text,
            'course_of_study' => $this->faker->text,
            'current_school_grade' => $this->faker->randomFloat($nbMaxDecimals=NULL, $min=0, $max=7.0),
            'internship_letter_img' => $this->faker->imageUrl('640', '480', 'cats'),

            'skillsets' => $this->faker->optional->passthrough(json_encode([
                "1" => "java", 
                "2" => "groovy", 
                "3" => "php"
            ])),

            'years_of_experience' => $this->faker->randomDigitNotNull,

            'experiences' => $this->faker->optional->passthrough(json_encode([
                "1" => "Cool Nigeria Limited", 
                "2" => "Fresh Nigeria PLC", 
                "3" => "Aladin Movie Company"
            ])),

            'job_preferences' => $this->faker->optional->passthrough(json_encode([
                "1" => "Great Company", 
                "2" => "Competitive Salary", 
                "3" => "Great Work Culture"
            ])),

            //ids of the jobs applied for so far by the intern: 
            'jobs_applied' => $this->faker->optional->passthrough(json_encode([
                "1" => $this->faker->uuid, 
                "2" => $this->faker->uuid, 
                "3" => $this->faker->uuid
            ])),

            //ids of the jobs for which interns had once applied, to which response has been recieved from the employer:
            'jobs_responses' => $this->faker->optional->passthrough(json_encode([
                "1" => $this->faker->uuid, 
                "2" => $this->faker->uuid, 
                "3" => $this->faker->uuid
            ])),

            'comment_rate' => $this->faker->optional->passthrough(json_encode([
                "employer_unique_id" => $this->faker->uuid, 
                "comment" => $this->faker->text, 
                "rating" => $this->faker->numberBetween($min=0, $max=5)
            ])),

            'payment_id' => $this->faker->optional->passthrough(json_encode([
                "1" => $this->faker->uuid, 
                "2" => $this->faker->uuid, 
                "3" => $this->faker->uuid
            ]))

        ];
    }
}
