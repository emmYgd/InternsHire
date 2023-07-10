import Vue from "./libs/vue.min.js";
import AbstractModel from "./../Models/AbstractModel.js";

	//use the Vue library here:
	new Vue({
		
		el: '#registration',

		/*life-cyle methods: data(), beforeMount(), mounted(), beforeCreate(), 
		created(), beforeUpdate(), updated(), beforeUnmount(), unmounted()*/
		data:
		{
			//UI to Vue:init
			internFirstName: '',
			internLastName: '',
			internEmail:'',
			internUsername:'',
			internPassword:'',

			//UI to Vue:continue
			internInstitution: '',
			internCourseOfStudy:'',
			internYearOrLevel:'',
			internSchoolGrade:'',
			internCurrentLocation:'',
			internPreferredJobLocations:'',
			internYearsOfExperience: '',
			internSkills:'',

			//Vue States:
			reg_btn_clicked:false,
			continue_btn_clicked: false,
			server_sync_model:null,
			request_error:'',
				
			//Vue to UI:
			progress:false,
			error_message:'',
			success_message:'',
			reg_completed: false,
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

			async SyncInitRegisterModel()
			{
				let method = "POST";
				let serverUrl = 'http://localhost/InternsHire/Backend/public/api/v1/interns/auth/register';
				
				let jsonRequestModel = {
					'firstname': this.internFirstName,
					'lastname' : this.internLastName,
					'email' : this.internEmail,
					'username' : this.internUsername,
					'password' : this.internPassword
				};

				let serverModel = await AbstractModel(method,serverUrl,jsonRequestModel);
				console.log("SyncModel", serverModel);
				this.server_sync_model = serverModel;
			},


			async SyncContinueRegisterModel()
			{
				let method = "POST";
				let serverUrl = 'http://localhost/InternsHire/Backend/public/api/v1/interns/auth/edit/profile';
				
				let jsonRequestModel = {
					'intern_id': this.server_sync_model.intern_id,
					'institution': this.internInstitution,
					'course_of_study': this.internCourseOfStudy,
					'year_or_level': this.internYearOrLevel,
					'current_school_grade': this.internSchoolGrade,
					'current_location': this.internCurrentLocation,
					'preferred_job_locations': this.internPreferredJobLocations,
					'years_of_experience': this.internYearsOfExperience,
					'skillsets': this.internSkills,
				};
				console.log(jsonRequestModel);

				let serverModel = await AbstractModel(method,serverUrl,jsonRequestModel);
				console.log("SyncModel", serverModel);
				this.server_sync_model = serverModel;
			},


			//entry function:
			async InternInitRegister(ev)
			{
				ev.preventDefault();
				
				//set the button as clicked for watchers to animate loading icon:
				this.reg_btn_clicked = true;
				
				await this.SyncInitRegisterModel();

				console.log("AppModelValue: ", this.server_sync_model);

				//navigate through the model received: 
				if( 
					(this.server_sync_model.code==1) &&
					(this.server_sync_model.serverStatus=='CreationSuccess!')
				)
				{
					//set success message:
					this.success_message = "Created Successfully! Now continue to input other details!";
					//redirect interns to register others details after waiting for 5secs:
					setInterval(
						this.progress = true, 5000
					);
					console.log("I should have redirected!");

				}else if(
					(this.server_sync_model.code==0) &&
					(this.server_sync_model.serverStatus=='CreationError!')
				)
				{	
					//set error message:
					this.error_message = this.server_sync_model.short_description;
					console.log(this.server_sync_model.short_description);

					//also check for warning:
					if(this.server_sync_model.warning !== undefined)
					{
						this.error_message = this.server_sync_model.warning;
					}
					console.log(this.error_message);
				}else
				{
					this.error_message = "Failure. Please check Your Internet Connection"
				}

				if(this.error_message !== "")
				{
					//delay briefly to show the loading spinner
					setInterval(
						this.reg_btn_clicked = false, 5000
					);
					console.log("I should have redirected!");
				}

			},


			//continue function
			async InternContinueRegister(ev)
			{
				ev.preventDefault();
				
				//set the button as clicked for watchers to animate loading icon:
				this.continue_btn_clicked = true;
				
				await this.SyncContinueRegisterModel();

				console.log("AppModelValue: ", this.server_sync_model);

				//navigate through the model received: 
				if( 
					(this.server_sync_model.code==1) &&
					(this.server_sync_model.serverStatus=='DetailsSaved!')
				)
				{
					//set success message:
					this.success_message = "Updated Successfully! Being redirected to your dashboard now!";
					//redirect interns to dashboard after waiting for 5secs:

					//put the intern_id in a local storage for use by the dashboard page:
					localStorage.currentInternID = this.server_sync_model.intern_id
					//this.continue_btn_clicked = false//for testing...
					setInterval
					(
						window.location.replace('InternLogin.html'), 5000
					);
					console.log("I should have redirected!");
				}else if
				(
					(this.server_sync_model.code==0) &&
					(this.server_sync_model.serverStatus=='DetailsNotSaved!')
				)
				{	
					//set error message:
					this.error_message = this.server_sync_model.short_description;
					console.log(this.error_message);
				}else
				{
					this.error_message = "Failure. Please check Your Internet Connection"
				}

				if(this.error_message !== "")
				{
					//delay briefly to show the loading spinner
					setInterval(
						this.continue_btn_clicked = false, 5000
					);
					console.log("I should have redirected!");
				}

			},

		},
		
		computed: 
		{
			
		},
		
		watch: 
		{
			//I have used watchers for animations and other mascellaneous
			Password(newPass, oldPass)
			{
				//This will be used to watch for changes and observe sensitive data(such as password)
				//let inputedPassword = 
			}
		},
		
	});
	
	
	//now mount this Vue app:
	//InternRegisterController.mount('#register');