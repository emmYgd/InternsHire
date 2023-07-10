/*error handling pattern: only the ajax errors are handled inline...
	all the other errors/exceptions throws error messages which are handled by the try/catch structure  
*/

export class LoginModel{

	let register = async (url, jsonData) => {

		console.log("We are cool");

		//call ajax:
		let req = $.ajax({
			"url" : "http://localhost:8000/api/v1/interns/login/dashboard",
			"method": "POST",
			"dataType": "json",
			"data": {
				"email_or_username" : "YoungEmmy", //"emmanueladediji@gmail.com",
				"password": "my12pass"
			}
		});

		console.log(req);

		//handle request:
		await req.done( (resp)=> {
			//return response to any class that imports this...
			return resp;
			/*$("#display_resp").text(resp);
			console.log(resp);*/
		});

		await req.fail( (resp)=> {
			return resp;
			//$("#display_fail").text(resp);
		});

		/*await req.done( ()=> {
			//return "";
			//$("#display_done").text("This is done");
		});*/

		//console.log("We are here");
	}
}