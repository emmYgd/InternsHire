import AbstractModel from "./.././../Models/AbstractModel.js";

//We will use these in more than one page:
let InternLogin = async (EmailOrUsername, Password) =>
{
	var serverModel;

	let method = "POST";
	let serverUrl = 'http://localhost/InternsHire/Backend/public/api/v1/interns/auth/login/dashboard';
				
	let jsonRequestModel = {
		'email_or_username' : EmailOrUsername,
		'password' : Password
	};

	serverModel = await AbstractModel(method,serverUrl,jsonRequestModel);
	console.log("SyncModel", serverModel);
	return serverModel;
}

let EmployerLogin = async (EmailOrUsername, Password) =>
{

}

export {InternLogin};