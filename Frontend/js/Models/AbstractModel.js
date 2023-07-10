/*error handling pattern: only the ajax errors are handled inline...
	all the other errors/exceptions throws error messages which are handled by the try/catch structure  
*/
//import {Axios} from "./../Models/libs/axios.js";

	let AbstractModel = async (method,serverUrl,jsonRequestModel) => 
	{
		console.log("We are cool");
		console.log('json Request Model:',jsonRequestModel);

		var req;
		var respData;

		//compose request:
		if (jsonRequestModel == '')
		{
			req = axios({
  				method: method,
  				url: serverUrl,
  				responseType: 'json',
			});
		}
		else
		{
			req = axios({
  				method: method,
  				url: serverUrl,
  				responseType: 'json',
  				data: jsonRequestModel
			});
		}

			//now await response:
			await req.then( (resp) => {
				console.log("Model: ", resp.data);
				respData = resp.data;
			});

			await req.catch( (error) => {

				if (error.response) 
				{
					// The request was made and the server responded with a status code
      				// that falls out of the range of 2xx
					console.log("Response Received: ", error.response);
					respData = error.response.data;
				}
				else if (error.request) 
				{
      				// The request was made but no response was received
      				console.log('Error', error.request);
      				respData = error.request;
    			} 
    			else 
    			{
      				// Something happened in setting up the request that triggered an Error
      				console.log('Error', error.message);
      				respData = error.message;
    			}
			});

		 /*{
				"username" : "YoungEmmy",
				"email": "emmanueladediji@gmail.com",
				"password": "my12pass",
				"firstname": "Emmanuel",
				"lastname": "Adediji",
				
				"institution": "University of Ibadan",
				"course_of_study": "Computer Science",
				"current_school_grade": 4.50,
				"years_of_experience": 1,
				

				"skillsets": {
					"1": "Java",
					"2": "NodeJS",
					"3": "Python",
					"4": "Objective-C"
				},

				//all these can be updated after login to dashboard
				//profile picture
				/*"cover_letter": "I am cool",
				//upload picture of the internship letter
				//upload personal profile picture
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
						"perks" : "",
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
			}*/
		return respData;
		console.log("Response Received");
	}

export default AbstractModel;
