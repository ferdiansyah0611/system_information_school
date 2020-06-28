import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		Users : [],
		Class : [],
		School : []
	},
	mutations: {
		UsersData(state, data){
			this.state.Users = data;
		},
		ClassData(state, data){
			this.state.Class = data;
		},
		SchoolData(state, data){
			this.state.School = data;
		}
	},
	actions: {}
});