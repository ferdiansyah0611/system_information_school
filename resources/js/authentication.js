export default class Authentication{
	constructor(){

	}
	pushed(data){
		window.localStorage.setItem('users', data);
	}
	get(){
		return window.localStorage.getItem('users');
	}
	check(){
		var app = window.localStorage.getItem('users');
		if(app == undefined || app == null){
			return false;
		}else{
			return true;
		}
	}
	required(){
		var app = window.localStorage.getItem('users');
	}
}