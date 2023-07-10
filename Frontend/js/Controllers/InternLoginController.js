import Vue from "./libs/vue.min.js";
import {InternLogin} from "./Commons/Login.js";
import AbstractModel from "./../Models/AbstractModel.js";

	//use the Vue library here:
	new Vue({
		
		el: '#login',

		/*life-cyle methods: data(), beforeMount(), mounted(), beforeCreate(), 
		created(), beforeUpdate(), updated(), beforeUnmount(), unmounted()*/
		data:
		{
			internID: '',

			//UI to Vue:init
			internEmailOrUsername:'',
			internPassword:'',

			//Vue States:
			login_btn_clicked:false,
			server_sync_model:null,
				
			//Vue to UI:
			error_message:'',
			success_message:'',
		},
		
		/*beforeMount(){
			console.log("Hello There");
		},*/
		/*mounted(){
			console.log("Hello There");
			console.log(this.internFirstName +'' + this.internLastName);
		},*/
		
		methods: 
		{
			
			async SyncLoginModel()
			{
				//console.log(this.internEmailOrUsername);
				//console.log(this.internPassword);
				let serverModel = await InternLogin(this.internEmailOrUsername, this.internPassword);

				console.log("SyncModel", serverModel);
				this.server_sync_model = serverModel;
			},

			//entry function:
			async InternLogin(ev)
			{
				ev.preventDefault();
				
				//set the button as clicked for watchers to animate loading icon:
				this.login_btn_clicked = true;
				
				await this.SyncLoginModel();

				console.log("AppModelValue: ", this.server_sync_model);

				//navigate through the model received: 
				if( 
					(this.server_sync_model.code==1) &&
					(this.server_sync_model.serverStatus=='Found!')
				)
				{
					this.internID = this.server_sync_model.uniqueToken; 
					
					//set success message:
					this.success_message = "Logged In successfully, Loading Dashboard Now!";
					//redirect interns to dashboard waiting for 5secs:
					setInterval(
						window.location.replace('InternDashboard.html'), 3000
					);
					console.log("I should have redirected!");

				}else if
				(
					(this.server_sync_model.code==0) &&
					(this.server_sync_model.serverStatus=='loginFailed!')
				)
				{	
					//set error message:
					this.error_message = this.server_sync_model.short_description;
					console.log(this.error_message);
				}
				else
				{
					this.error_message = "Failure. Please check Your Internet Connection"
				}

				if(this.error_message !== "")
				{
					//delay briefly to show the loading spinner
					setInterval(
						this.login_btn_clicked = false, 5000
					);
					//console.log("I should have redirected!");
				}

			},

		},
		
		computed: 
		{
			
		},
		
		watch: 
		{
			//I have used watchers for animations and other mascellaneous
			internID(newInternID)
			{
				//this will aid us in persistence..
				localStorage.currentInternID = newInternID;
				console.log(localStorage.currentInternID);
			}
		},
		
	});	
	//now mount this Vue app:
	//InternRegisterController.mount('#register');