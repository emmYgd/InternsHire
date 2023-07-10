import Vue from "./libs/vue.min.js";
import AbstractModel from "./../Models/AbstractModel.js";

	//use the Vue library here:
	new Vue({
		
		el: '#vueInjectCurrentInternSync',

		/*life-cyle methods: data(), beforeMount(), mounted(), beforeCreate(), 
		created(), beforeUpdate(), updated(), beforeUnmount(), unmounted()*/
		data:
		{
			currentInternID:'',

			syncCurrentInternDetailsModel:null,

			//UI to Vue:init
			internImage:null,
			internGender:null,
			internAge:null,
			internOccupation:null,
			internCurrentLocation:null,
			internCurrentAddress:null,
			internFirstName:null,
			internLastName: null,
			internEmail:null,
			internPhoneNumber:null,
			internUsername:null,

			//intern Web Presence
			internTwitter:null,
			internLinkedIn:null,
			internFacebook:null,
			internInstagram:null,
			internGithub: null,

			//UI to Vue:continue
			internInstitution: null,
			internCourseOfStudy:null,
			internYearOrLevel:null,
			internSchoolGrade:null,
			internCurrentLocation:null,
			internPreferredJobLocations:null,
			internYearsOfExperience: null,
			internSkillsets:null,
			internLanguages:null,

			//Vue States:
			is_logged_in:false,
			update_profile_btn_clicked:false,
			submit_profile_update_btn_clicked:false,
			search_job_btn_clicked:false,
			job_apply_btn_clicked: false,

			//Vue to UI:
			progress:false,
			error_message:'',
			success_message:'',
			reg_completed: false,
		},
		
		//for authentication:
		beforeMount()
		{
			//wait for the local storage update first
			this.InitSync();
		},

		watch: 
		{
			syncCurrentInternDetailsModel(currentModel)
			{
				this.SyncCurrentInternDetailsValues(currentModel);
			},
			
			internUsername(newValue)
			{
				console.log(newValue);
			}
		},

		mounted()
		{	
			//we will use watchers for this...
			//this.SyncCurrentInternDetails();
		},
		
		methods: 
		{
			InitSync()
			{
				this.currentInternID = localStorage.currentInternID;
				//sync the received data to the data models:
				//check if local storage state is not equal to null or undefined:
				const localStorageModel = localStorage.CurrentInternDetailsModel;
				if(
					(localStorageModel !== null) &&
					(localStorageModel !== undefined)
				){
					this.syncCurrentInternDetailsModel = JSON.parse(localStorage.CurrentInternDetailsModel);
				}else{
					//send ajax requests to the server:
					this.PrefetchCurrentInternDetails();
				}
				
				console.log("Returned Model:", this.syncCurrentInternDetailsModel);
			},
			
			async PrefetchCurrentInternDetails()
			{
				let method = "GET";
				let serverUrl = "http://localhost/InternsHire/Backend/public/api/v1/interns/dashboard/utils/get/own/details/"+ this.currentInternID ;
				let jsonRequestModel = "";
				
				let serverModel = await AbstractModel(method, serverUrl, jsonRequestModel);
				
				//also save in the data model:
				this.syncCurrentInternDetailsModel = serverModel;
				
				//save in local db:
				localStorage.CurrentInternDetailsModel = JSON.stringify(serverModel);
				//console.log("Cool Details Right", this.syncCurrentInternDetails);
			},

			SyncCurrentInternDetailsValues(syncCurrentInternDetailsModel)
			{
				if( (this.syncCurrentInternDetailsModel.code == 1) &&
				(this.syncCurrentInternDetailsModel.serverStatus == "currentInternDetailsFound")
				){
					//Update the UI variables:
					//this.internImage = this.syncCurrentInternDetailsModel.intern.image;
					//this.internGender = this.syncCurrentInternDetailsModel.intern.gender;
					//this.internAge = this.syncCurrentInternDetailsModel.intern.age;
					//this.internOccupation = this.syncCurrentInternDetailsModel.intern.occupation;
					this.internFirstName = this.syncCurrentInternDetailsModel.intern.firstname;
					this.internLastName = this.syncCurrentInternDetailsModel.intern.lastname;
					this.internEmail = this.syncCurrentInternDetailsModel.intern.email;
					this.internUsername = this.syncCurrentInternDetailsModel.intern.username;
				
					//this.internTwitter = this.syncCurrentInternDetailsModel.intern.social_media.twitter;
					//this.internLinkedIn = this.syncCurrentInternDetailsModel.intern.social_media.linkedin;
					//this.internGithub = this.syncCurrentInternDetailsModel.intern.social_media.github;
					//this.internFacebook = this.syncCurrentInternDetailsModel.intern.social_media.facebook;
					//this.internInstagram = this.syncCurrentInternDetailsModel.intern.social_media.instagram;
					
					this.internInstitution = this.syncCurrentInternDetailsModel.intern.institution;
					this.internCourseOfStudy = this.syncCurrentInternDetailsModel.intern.course_of_study;
					this.internYearOrLevel = this.syncCurrentInternDetailsModel.intern.year_or_level;
					this.internSchoolGrade = this.syncCurrentInternDetailsModel.intern.current_school_grade;
					this.internCurrentLocation = this.syncCurrentInternDetailsModel.intern.current_location;
					this.internPreferredJobLocations = this.syncCurrentInternDetailsModel.intern.preferred_job_locations;
					this.internYearsOfExperience = this.syncCurrentInternDetailsModel.intern.years_of_experience;
					
					let receivedSkillsets  = this.syncCurrentInternDetailsModel.intern.skillsets;
					this.internSkillsets = receivedSkillsets.split(",");
					if(this.internSkillsets.length == 0){
						this.internSkillsets = receivedSkillsets.split("");
					} 
					
					/*let receivedLanguages = this.syncCurrentInternDetailsModel.intern.languages;
					this.internLanguages = receivedLanguages.split(",");
					if(this.internLanguages.length == 0){
						this.internLanguages = receivedLanguages.split("");
					} */
					
					//let emptyArray = [];
					
					//this.internFacebook = this.syncCurrentInternDetailsModel.intern.facebook;
					//this.internTwitter = this.syncCurrentInternDetailsModel.intern.twitter;
					//this.internLinkedIn = this.syncCurrentInternDetailsModel.intern.linkedin;
					//this.internGithub = this.syncCurrentInternDetailsModel.intern.github;
					//this.internInstagram = this.syncCurrentInternDetailsModel.intern.instagram
					
					console.log("First Name",this.internFirstName);
					console.log("City, State, Country:", this.internCurrentLocation);
					console.log("Job Locations:", this.internPreferredJobLocations);
					console.log("Skillsets:", this.internSkillsets);
					//console.log("Array Length:",emptyArray.length);
				}

			},
			
		},
		
		computed: 
		{
			
		},
		
	});
	
	//now mount this Vue app:
	//InternRegisterController.mount('#register');