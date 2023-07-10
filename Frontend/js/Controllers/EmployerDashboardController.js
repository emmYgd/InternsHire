import Vue from "./libs/vue.min.js";
import AbstractModel from "./../Models/AbstractModel.js";
//import Login from "./EmployerLoginController.js";

	//use the Vue library here:
	new Vue({
		
		el: '#vue_dashboard_job_inject',

		/*life-cyle methods: data(), beforeMount(), mounted(), beforeCreate(), 
		created(), beforeUpdate(), updated(), beforeUnmount(), unmounted()*/
		data:
		{
			currentEmployerID:'',
			//UI to Vue:general dashboard
			employerImage:'',
			employerGender:'',
			employerFirstName:'',
			employerLastName: '',
			employerEmail:'',
			employerUsername:'',

			//UI to Vue:for job postings:
			employerJobTitle:'',
			employerJobDescription: '',
			employerJobRequirements:'',
			employerJobAddress:'',
			employerJobState: '',
			employerJobCountry: '',
			employerJobApplicationValidity:'',
			employerExpectedStartDate: '',
			employerInternshipPeriod:'',
			employerSalaryOrIncentive:'',
			employerLocationType:'',
			employerJobNature: '',
			employerCurrencyOfPayment: '',


			//employer Web Presence
			employerTwitter:'',
			employerLinkedIn:'',
			employerFacebook:'',
			employerFacebook:'',

			chat_urls: '',

			//UI to Vue:continue
			employerInstitution: '',
			employerCourseOfStudy:'',
			employerYearOrLevel:'',
			employerSchoolGrade:'',
			employerCurrentLocation:'',
			employerPreferredJobLocations:'',
			employerYearsOfExperience: '',
			employerSkills:'',

			//Vue States:
			is_logged_in:false,
			update_profile_btn_clicked:false,
			submit_profile_update_btn_clicked:false,
			search_job_btn_clicked:false,
			job_post_btn_clicked: false,

			server_sync_model_employer:null,
			server_sync_model_job:null,
			server_confirm_model:null,

			request_error:'',
				
			//Vue to UI:
			progress:false,
			error_message:'',
			success_message:'',
			reg_completed: false,
		},
		
		//for authentication:
		/*beforeMount()
		{
			//before the page loads, first check if the user is logged in:
			console.log("Before Anything happens, ensure the user is logged in");

			//By first checking their local storage ID:
			console.log("Local Storage id:", localStorage.currentEmployerID);
			//sync the current EmployerID first:
			this.currentEmployerID = localStorage.currentEmployerID;

			//if it is empty, redirect..
			if(this.currentEmployerID == "")
			{
				setInterval(
					window.location.replace('EmployerLogin.html'), 5000
				);
			}

			//if it is not empty->

			//next is to use the employerID to confirm from server if the current user is logged in:
			let method = "POST";
			let confirmServerUrl = 'http://localhost/EmployersHire/Backend/public/api/v1/employers/auth/confirm/loggedin/state';
				
			let jsonRequestModel = {
				'currentEmployerID' : this.currentEmployerID,
			};

			let serverModel = await AbstractModel(method,confirmServerUrl,jsonRequestModel);
			console.log("SyncModel", serverModel);

			this.server_confirm_model = serverModel;
			//if it isn't logged in on the server:
			if(this.server_confirm_model.is_logged_in !== true)
			{
				//redirect again:
				setInterval(
					window.location.replace('EmployerLogin.html'), 5000
				);
			}
			//otherwise continue...
		},*/

		//for some simulteneous fetchings:
		/*mounted()
		{
			//Immediately the page loads:
			console.log("I will make some simulteneous requests now:");

			//get all the details of this current employers:
			this.SyncCurrentEmployerModel();

			//prefetch top 5-jobs summary: 
			//(this will be displayed properly and comprehensively on the employer's job search page)
			this.SyncTopFiveEmployerJobSummaryModel();

			//prefetch top 5 Employers: 
			//(this will be displayed properly and comprehensively on the employer's employer search page)
			this.SyncTopFiveEmployers();
		},*/
		
		methods: 
		{
			/*async SyncCurrentEmployerModel()
			{
				let method = "GET";
				let serverUrl = "";
				let requestHeaderComponent = this.currentEmployerID;
				let serverModel = await AbstractGetModel(method, serverUrl, requestHeaderComponent);
				this.server_sync_model_employer = serverModel;
			},*/

			/*async SyncTopThreeInternSummaryModel()
			{
				let method = "GET";
				let serverUrl = "";
				let requestHeaderComponent = this.currentEmployerID;
				let serverModel = await AbstractGetModel(method, serverUrl, requestHeaderComponent);
				this.server_sync_model_employer = serverModel;
			},*/

			/*async SyncAllJobPostedWithInternThatApplied()
			{
	
			}
			*/


			async SyncSubmitJobPostModel()
			{
				let method = "POST";
				let serverUrl = 'http://localhost/InternsHire/Backend/public/api/v1/employers/dashboard/utils/job/post';
				
				let jsonRequestModel = {
					'employer_id': this.currentEmployerID,
					'owner' : 'employer',
					'job_title': this.employerJobTitle,
					'job_description': this.employerJobDescription,
					'job_requirement': this.employerJobRequirements,
					'address': this.employerJobAddress,
					'state': this.employerJobState,
					'country': this.employerJobCountry,
					'date_expired': this.employerJobApplicationValidity,
					'expected_start': this.employerExpectedStartDate,
					'internship_period': this.employerInternshipPeriod,
					'salary_or_incentives': this.employerSalaryOrIncentive,
					'location_type': this.employerLocationType,
					'nature': this.employerJobNature,
					'currency_of_payment': this.employerCurrencyOfPayment,
					'is_delayed': false
				};

				let serverModel = await AbstractModel(method,serverUrl,jsonRequestModel);
				console.log("SyncModel", serverModel);
				this.server_sync_model = serverModel;
			},



			//entry function:
			async EmployerSubmitJobPost(ev)
			{
				ev.preventDefault();
				//console.log("I am clicked");
				
				//set the button as clicked for watchers to animate loading icon:
				this.job_post_btn_clicked = true;
				
				await this.SyncSubmitJobPostModel();

				console.log("AppModelValue: ", this.server_sync_model);

				//navigate through the model received: 
				if( 
					(this.server_sync_model.code==1) &&
					(this.server_sync_model.serverStatus=='CreationSuccess!')
				)
				{
					//set success message:
					this.success_message = "Created Successfully!";
					//redirect employers to register others details after waiting for 5secs:
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
					this.error_message = "Failure. Please check Your Employeret Connection"
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
			async EmployerContinueRegister(ev)
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
					//redirect employers to dashboard after waiting for 5secs:

					//put the employer_id in a local storage for use by the dashboard page:
					localStorage.currentEmployerID = this.server_sync_model.id

					setInterval(
						window.location.replace('EmployerDashboard.html'), 5000
					);
					console.log("I should have redirected!");
				}else if(
					(this.server_sync_model.code==0) &&
					(this.server_sync_model.serverStatus=='DetailsNotSaved!')
				)
				{	
					//set error message:
					this.error_message = this.server_sync_model.short_description;
					console.log(this.error_message);
				}else
				{
					this.error_message = "Failure. Please check Your Employeret Connection"
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
			//I have used watchers for events that need to both update on the frontend and backend: 
			EmployerImage(newEmployerImage)
			{
				
			}
		},
		
	});
	
	
	//now mount this Vue app:
	//EmployerRegisterController.mount('#register');