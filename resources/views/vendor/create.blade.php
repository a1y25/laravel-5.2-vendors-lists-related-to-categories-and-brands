@extends('welcome')

@section('content')
	

	<div class="container" id="app">
		


		<h1>Create a Vendor</h1>

		<div class="form-group">
		  <label for="">Name</label>
		  <input type="text" class="form-control" name="name" v-model="name">
		</div>		


		<div class="form-group">
		  <label for="">Address</label>
		  <input type="text" class="form-control" name="address" v-model="address">
		</div>		

		<div class="form-group">
		 <label for="">Brands</label>
		 <select id="brands-select" class="form-control">
		 	<option></option>
			<option v-for="brand in brands" value="@{{brand.id}}">@{{brand.title}}</option>
		</select>
		</div>

		<div v-if="vendorBrands.length">
			<h4>
				<span v-for="vendorBrand in vendorBrands" class="label label-default">
				@{{vendorBrand.title}} 
				<button class="btn btn-xs btn-danger" @click='removeVendor(vendorBrand)'>&times;</button>
			</span>
			</h4>
		</div>

		<div class="form-group">
		  <label for="">Categories</label>
		  <select id="categories-select" class="form-control" name="">
			<option></option>
			<option v-for="category in categories" value="@{{category.id}}">@{{category.title}}</option>
		  </select>
		</div>


		<div v-if="vendorCategories.length">
			<h4>
				<span v-for="vendorCategory in vendorCategories" class="label label-default">
				@{{vendorCategory.title}} 
				<button class="btn btn-xs btn-danger" @click='removeCategory(vendorCategory)'>&times;</button>
			</span>
			</h4>
		</div>
	
		<button @click="createVendor" class="btn btn-sm btn-info">Create</button>
	</div>
	

	<script>

		// var brands;
		var brandSelect =$('#brands-select').select2({
			placeholder: "Select Brand"
		});

		var categorySelect = $('#categories-select').select2({
			placeholder: "Select Category"
		});

		brandSelect.on('select2:select', function (e){
			var data = e.params.data;

			var duplicate = VendorApp.vendorBrands.filter(function (brand){
				return brand.id===data.id;
			});	

			if(duplicate.length) return;

			VendorApp.vendorBrands.push({id:data.id, title: data.text});
		});


		categorySelect.on('select2:select',function (e){
			var data = e.params.data;
			var duplicate = VendorApp.vendorCategories.filter(function (brand){
				return brand.id===data.id;
			});	

			if(duplicate.length) return;

			VendorApp.vendorCategories.push({id:data.id, title: data.text});
		});


		var VendorApp = new Vue({
		  	el: '#app',
		 	data: {
  			  brands: [],
  			  categories: [],
  			  vendorBrands: [],
  			  vendorCategories:[]
		  	},
		 	methods:{
		 		removeVendor(brand){
		 			this.vendorBrands.$remove(brand);
		 		},
		 		removeCategory(category){
		 			this.vendorCategories.$remove(category);
		 		},
		 		createVendor(){

		 			var data = {
		 				name: this.name,
		 				address: this.addresss,
		 				brands: this.vendorBrands.map(function (brand){return brand.id;}),
		 				categories: this.vendorCategories.map(function (category){return category.id})
		 			};

		 			this.$http.post('/api/vendor', data).then(function (){
		 				alert('vendor created success.')

		 			},function (){
		 				alert('cannot insert data.');
		 			});

		 		},
		 		fetchBrands(){
		 			this.$http.get('/api/brands').then(function (response){
		 				this.brands = response.data;
		 			});
		 		},

		 		fetchCategories(){
		 			this.$http.get('/api/categories').then(function (response){
		 				this.categories = response.data;
		 			});
		 		}
 			},
 			created(){
 				this.fetchBrands();
 				this.fetchCategories();		 		
 			}
		});
	</script>
@stop