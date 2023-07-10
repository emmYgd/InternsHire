/*error handling pattern: only the ajax errors are handled inline...
	all the other errors/exceptions throws error messages which are handled by the try/catch structure  
*/
let edit = async () => {

	console.log("We are cool");

	//call ajax:
	let req = $.ajax({
		"url" : "http://localhost:8000/api/v1/interns/edit/profile",
		"method": "PUT",
		"dataType": "json",
		"data": {
			"username" : "",
			"email" : "emmanueladediji@gmail.com",
			/*"password": "my12pass",
			"firstname": "Emmanuel",
			"lastname": "Adediji",*/
			//"resume" : "",
			//"profile_picture" : "",
			//"internship_letter_img" : "",
			"cover_letter": "I am cool",
			"institution": "University of Ibadan",
			"course_of_study": "Computer Science",
			"current_school_grade": 4.80,
			"years_of_experience": 2,

			"skillsets": {
				"1": "Java",
				"2": "NodeJS",
				"3": "Python",
				"4": "Objective-C"
			},

			"experiences": {

				"1": {
					"jobRole" : "Engineering Intern",
					"org_name" : "Concrete Nigeria Enterprises",
					"brief_description" : "Cool Engineering Practices",
					"from" : new Date("July 30 2019"),//for DateTime:new Date(yr,mnth,day,hr,min,sec)
					"to" : new Date("December 2 2020"),
					"salary" : "",
					"perks" : "",
					"reasons_for_leaving" : ""
				},

				"2": {
					"jobRole" : "Engineering Intern",
					"org_name" : "Concrete Nigeria Enterprises",
					"brief_description" : "Cool Engineering Practices",
					"from" : new Date("July 30 2019"),//for DateTime:new Date(yr,mnth,day,hr,min,sec)
					"to" : new Date("December 2 2020"),
					"salary" : "",
					"perks" : "Bread and Butter lol",
					"reasons_for_leaving" : ""
				},

				"3":{

				}

			},

			"job_preferences" : {

				"duration_range" : {
					"from": "6months",
					"to" : "1year"
				},

				"salary_range" : {
					"currency": "NGN",
					"from" : "25,000",
					"to" : "30,000"
				},

				"locations" : {
					"1" : "Ibadan",
					"2" : "Lagos",
					"3" : ""
				}
			}

		}
	});

	console.log(req);

	//handle request:
	await req.done( (resp)=> {
		$("#display_resp").text(resp);
		console.log(resp);
	});

	await req.fail( (resp)=> {
		$("#display_fail").text(resp);
	});

	await req.done( ()=> {
		$("#display_done").text("This is done");
	});

	console.log("We are here");
}

edit();