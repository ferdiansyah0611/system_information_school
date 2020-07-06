<template>
	<div>
		<div class="account-pages my-2 pt-sm-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="mt-4 text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-6">
                                    <img src="/vendor/template/images/error-img.png" alt="" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                            <h1 class="mt-5 text-uppercase text-white font-weight-bold mb-3">Sorry, Page not Found</h1>
                            <h5 class="text-white-50">We will be back soon</h5>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
	</div>
</template>
<script>
export default{
	beforeMount() {
		window.title = '404 Error';
	},
	mounted() {
		document.body.classList.add('bg-primary');
	}
}
</script>