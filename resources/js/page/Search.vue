<template>
	<div>
		<div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Search data</h4>
                    </div>
                </div>
            </div>
        </div>
		<div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="card col-12">
                        <div class="card-body">
                        	<h5>Search by users</h5>
                        	<div class="col-sm-12 col-md-3 float-left" v-for="data in DataUser" :key="data.id">
                        		<img class="img-thumbnail" :src="'/storage/image/' + data.avatar" alt="avatar profile">
                        		<p>Name : {{data.name}}</p>
                        		<p>NISN : {{data.nisn}}</p>
                        		<p>School : {{data.school_name}}</p>
                        		<button class="btn btn-info col-12">Check profile</button>
                        	</div>
                        	<h5>Search by school</h5>
                        	<div class="col-sm-12 col-md-3 float-left" v-for="data in DataSchool" :key="data.id">
                        		<p>School : {{data.name}}</p>
                        		<button class="btn btn-info col-12">Check data</button>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<pagination :data="PaginateUser" @pagination-change-page="searchData"></pagination>
	</div>
</template>
<script>
export default{
	data() {
		return {
			PaginateUser : {},
			DataUser : [],
			PaginateSchool : {},
			DataSchool : [],
		}
	},
	created() {
		this.searchData();
	},
	methods : {
		async searchData(paginate = 1) {
			await axios({
				url : '/api/search/' + this.$route.params.search,
				methods : 'get',
				headers : {
					'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
				}
			}).then(result => {
				console.log(result.data);
				this.PaginateUser = result.data.user;
				this.DataUser = result.data.user.data;
				this.PaginateSchool = result.data.school;
				this.DataSchool = result.data.school.data;
			}).catch(error => {
				console.error(error.message);
			});
		}
	}
}
</script>