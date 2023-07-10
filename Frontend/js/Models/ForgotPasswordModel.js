/*error handling pattern: only the ajax errors are handled inline...
	all the other errors/exceptions throws error messages which are handled by the try/catch structure  
*/
let forgot_pass = async () => {

	console.log("We are cool");

	//call ajax:
	let req = $.ajax({
		"url" : "http://localhost:8000/api/v1/interns/forgot/password",
		"method": "PUT",
		"dataType": "json",
		"data": {
			"email_or_username" : "YoungEmmy", //"emmanueladediji@gmail.com",
			"new_pass": "my141pass"
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

forgot_pass();