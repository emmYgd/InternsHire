import Vue from "./libs/vue.min.js";
import AbstractModel from "./../Models/AbstractModel.js";

	//use the Vue library here:
	new Vue({
		
		el: '#dashboard_init',

		/*life-cyle methods: data(), beforeMount(), mounted(), beforeCreate(), 
		created(), beforeUpdate(), updated(), beforeUnmount(), unmounted()*/
		data:
		{
			currentInternID:'',
			syncCurrentInternDetailsModel:null,
			syncAvailableJobsDetailsModel:null,
			syncEmployersModel:null,
		},
		
		//for authentication:
		async beforeMount()
		{
			//before the page loads, first check if the user is logged in:
			console.log("Before Anything happens, ensure the user is logged in");

			//By first checking their local storage ID:
			console.log("Local Storage id:", localStorage.currentInternID);
			//sync the current InternID first:
			this.currentInternID = localStorage.currentInternID;

			//if it is empty, redirect to login
			if(this.currentInternID === undefined || 
				this.currentInternID === null ||
				this.currentInternID === "")
			{
				
				window.location.replace('InternLogin.html')
			}

			//if it is not empty->

			//next is to use the internID to confirm that this is a logged-in user, should in case they have logged out on other devices:
			let method = "POST";
			let confirmServerUrl = 'http://localhost/InternsHire/Backend/public/api/v1/interns/auth/confirm/login/state';
				
			let jsonRequestModel = {
				'intern_id' : this.currentInternID,
			};

			//console.log("InitJson", jsonRequestModel);

			let serverModel = await AbstractModel(method,confirmServerUrl,jsonRequestModel);
			console.log("SyncModel", serverModel);

			this.server_confirm_model = serverModel;
			//if it isn't logged in on the server:
			if((this.server_confirm_model.code == 0) &&
				(this.server_confirm_model.serverStatus == "notLoggedIn")
			)
			{
				//redirect again:
				setInterval(
					window.location.replace('InternLogin.html'), 5000
				);
			}
			//otherwise continue...*/
		},

		//for some simulteneous fetchings:
		mounted()
		{
			//Immediately the page loads:
			console.log("I will make some simulteneous requests now:");

			//Promise.all([

				//this.PrefetchCurrentInternDetails();
				//this.PrefetchAvailableJobDetails();
				//this.PrefetchEmployersDetails();//prefetch employers that wish to be seen by the intern...
				
			//]);

		},
		
		methods: 
		{
			

			/*async PrefetchAvailableJobDetails()
			{
				let method = "GET";
				let serverUrl = "http://localhost/InternsHire/Backend/public/api/v1/interns/dashboard/utils/job/search";
				let jsonRequestModel = "";
				
				let serverModel = await AbstractModel(method, serverUrl, jsonRequestModel);
				this.syncAvailableJobsDetailsModel = serverModel;
			},

			async PrefetchEmployersDetails()//search for potential employers that wants to be seen...
			{
				let method = "GET";
				let serverUrl = "http://localhost/InternsHire/Backend/public/api/v1/interns/dashboard/utils/intern/" + this.currentInternID +"/search/employers";
				let jsonRequestModel = "";

				let serverModel = await AbstractModel(method, serverUrl, jsonRequestModel);
				this.syncEmployersModel = serverModel;
			},*/

		},
		
		computed: 
		{
			
		},
		
		watch: 
		{

			/*syncAvailableJobsDetailsModel(newValue)
			{
				localStorage.AvailableJobsDetailsModel = JSON.stringify(newValue);		
			},	

			syncEmployersModel(newValue)
			{
				localStorage.EmployersModel = JSON.stringify(newValue);
			},*/
		},
		
	});
	
	
	//now mount this Vue app:
	//InternRegisterController.mount('#register');