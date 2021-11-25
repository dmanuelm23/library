<template>
    <div class="content sm">
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    <ul class="breadcrumbs">
                        <li><a href="/home">Home</a></li>
                        <li>Categories</li>
                    </ul>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-12 col-sm-6 col-md-8 col-lg-6">
                    <h1>Categories</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="caja sm mb-15 especial" v-if="formSave==0">
                        <h2 class="inline-b mr-15">Add a new record</h2>
                        <a href="#" class="button-circle main link" @click.prevent="create()">
                            <i class="ri-add-line"></i>
                        </a> 
                    </div>
                    <div class="caja sm mb-15 especial" v-if="formSave==1">
                        <h2 class="inline-b mr-15">Add a new record</h2> <a style="display: none;" class="button-circle main link "><i class="ri-add-line"></i></a> 
                        <form action="#" method="post" accept-charset="utf-8">
                            <div class="row mt-15">
                                <div class="col-12 col-md-12">
                                    <div class="form-group" :class="{'error':invalid.name}">
                                        <label for="name">Name:</label>
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            :class="{'form-alert':invalid.name}"
                                            @click="validateAlerts(1)"
                                            required
                                            placeholder="Name"
                                            v-model="dataCategory.name"
                                        >
                                        <p class="message" v-for="(e_name, index) in errors.name" :key="index">{{e_name}}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group" :class="{'error':invalid.description}">
                                        <label for="description">Description:</label>
                                        <div class="form-group" >
                                            <textarea
                                                name="description"
                                                id="description"
                                                class="form-control"
                                                :class="{'form-alert':invalid.description}"
                                                required
                                                @click="validateAlerts(2)"
                                                placeholder="Description"
                                                v-model="dataCategory.description">
                                            </textarea>
                                            <p class="message" v-for="(e_description, index) in errors.description" :key="index">{{e_description}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-right">
                                    <button type="button" class="button secondary mr-15" @click.prevent="closeForm" data-dismiss="modal">Cancel</button>
                                    <button type="submit" @click.prevent="save()" class="button main ">Add new record</button>
                                </div>
                            </div>	
                        </form>
                    </div>
                    <div class="row mt-60 mb-30" id="ancla-list">
                        <div class="col-12 col-sm-6 col-md-8 col-lg-6">
                            <h2>Records</h2>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-6 text-right">
                            <div class="form-control-icono search">
                                <form >
                                    <input type="text" name="findName" class="form-control" id="findName" placeholder="Search" v-model="dataCategoryFilter.name">
                                    <button style="text-decoration: none; border: none; background-color: transparent;" type="submit"  @click.prevent="filter" ><i class="ri-search-line toggle"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-12">
                            <div class="tags-view">
                                <div class="tags">
                                    <button class="button-icon mr-15" @click="showFilter()"><i class="ri-filter-3-line"></i> Filter</button>
                                    <button class="button-icon right mr-15" :class="showNameFilter">Name: {{textName}} <i class="ri-close-line" @click.prevent="removeFilterName()"></i></button>
                                    <button class="button-icon right mr-15" :class="showDescriptionFilter">Description: {{textDescription}} <i class="ri-close-line" @click.prevent="removeFilterDescription()"></i></button>
                                </div>
                                <div class="displays">
                                    <div class="display" :class="cardShow?'active':''" id="mosaic" @click="switchToList()"> <i class="ri-grid-fill"></i> </div>
                                    <div class="display" :class="listShow?'active':''" id="bars" @click="switchToCard()"> <i class="ri-menu-line"></i> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-15 mt-30">
                            <div class="alert alert-success alert-dismissible inline-b" role="alert" id="alertCreate">
                                {{title_message_create}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" v-if="counter == 0">
                        <div class="col-6 col-md-4 col-lg-3 ">
                            <div class="caja xs empty">
                                <h4>You do not have records in this catalog yet</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-30" :class="card">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" v-for="category in categories" :key="category.id">
                            <div class="caja xs" :class="{'gris':category.status === 0, 'verde':category.id === cardGreen}">
                                <h4 class="text-and-circle-button">{{category.name}}</h4> 
                                <button class="button-circle hover red align-top float-right" @click="openModalDestroy(category)"><i class="ri-delete-bin-line"></i></button>
                                <div class="small">Description</div>
                                <p>{{category.description}}</p>
                                <div class="text-right">
                                    <button class="button-circle main mr-7" @click="openModalEdit(category)"><i class="ri-pencil-fill"></i></button>
                                    <button class="button-circle hover mr-7" @click.prevent="openModalBanned(category)">
                                        <i :class="category.status=== 0  ? 'ri-lock-line' : 'ri-lock-unlock-line'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>	
                    </div>
                    <div class="row mb-30" :class="list">	
                        <div class="col-12 mb-15"  v-for="category in categories" :key="category.id">
                            <div class="caja sm lista" :class="{'gris':category.status=== 0}">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="small">Name</div>
                                                <p>{{category.name}}</p> 
                                            </td>
                                            <td>
                                                <div class="small">Descripción</div>
                                                <p>{{category.description}}</p>
                                            </td>
                                            <td class="text-right">
                                                <button class="button-circle main mr-7" @click="openModalEdit(category)"><i class="ri-pencil-fill"></i></button>
                                                <button class="button-circle hover mr-7" @click.prevent="openModalBanned(category)">
                                                    <i :class="category.status=== 0  ? 'ri-lock-line' : 'ri-lock-unlock-line'"></i>
                                                </button>
                                                <button class="button-circle red align-top mb-0" @click="openModalDestroy(category)"><i class="ri-delete-bin-line"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"  v-if="counter>0">
                <div class="col">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item mr-2" v-if="pagination.current_page > 1" >
                                <a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page - 1)">
                                    <span>Back</span>
                                </a>
                            </li>
                            <li class="page-item mr-2" v-if="pagination.current_page == 1" >
                                <a class="button-pagination page-link disabled">
                                    <span>Back</span>
                                </a>
                            </li>
                            <li class="page-item mr-2" v-for="page in pagesNumber" :key="page">
                                <a href="#" :class="[page == isActive ? 'active' : '']" class="button-pagination page-link" @click.prevent="changePage(page)">
                                {{page}}
                                </a>
                            </li>
                            <li class="page-item mr-2" v-if="pagination.current_page < pagination.last_page">
                                <a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page + 1)">
                                    <span>Next</span>
                                </a>
                            </li>
                            <li class="page-item mr-2" v-if="pagination.current_page == pagination.last_page" >
                                <a class="button-pagination page-link disabled">
                                    <span>Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="modal-banned" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<p class="mb-0">{{titleBanned}} category</p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="mb-0"><small>We are going to {{titleBanned}} the category <span class="bold">“{{category}}”</span>. Are you sure you want to do it?</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="banned">{{titleBanned}}</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" id="modal-category" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="mb-0">{{title}}</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cleanFields()">
						<span aria-hidden="true">×</span>
					</button>
				</div>	
				<div class="modal-body">
					<form>
                        <div class="row mt-15">
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.name}">
                                    <label for="name">Name:</label>
                                    <input
                                        type="text"
                                        name="name_edit"
                                        id="name_edit"
                                        class="form-control"
                                        :class="{'form-alert':invalid.name}"
                                        required
                                        @click="validateAlerts(1)"
                                        placeholder="Name"
                                        v-model="dataCategory.name"
                                    >
                                    <p class="message" v-for="(e_name, index) in errors.name" :key="index">{{e_name}}</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.description}">
                                    <label for="description">Description:</label>
                                    <div class="form-group" >
                                        <input
                                            type="text"
                                            name="description_edit"
                                            id="description_edit"
                                            class="form-control"
                                            :class="{'form-alert':invalid.description}"
                                            required
                                            placeholder="Description"
                                            @click="validateAlerts(2)"
                                            v-model="dataCategory.description">
                                        <p class="message" v-for="(e_description, index) in errors.description" :key="index">{{e_description}}</p>
                                    </div>
                                </div>
                            </div>
							<div class="col-12 mt-15" :class="{'text-right':createOrEdit=='save'}">
								<button v-if="createOrEdit=='edit'" type="button" class="button secondary mr-15" @click="openModalDestroyModal()">Delete <i class="ri-delete-bin-line"></i></button>
								<button v-if="createOrEdit=='edit'" type="button" class="button secondary mr-12"  @click.prevent="openModalBannedModal(dataCategory.status)">{{titleBanned}}<i class="ri-lock-line"></i></button>
								<button v-if="createOrEdit=='edit'" type="button" class="button main float-right" @click.prevent="edit">Save</button>
							</div>
						</div>	
					</form>
				</div>		
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" id="modal-filter" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">	
				<div class="modal-header">
					<h2 class="mb-0"><i class="ri-filter-3-line align-top"></i> Search filter</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="#" method="post" accept-charset="utf-8">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="nameFilter">Search keywords for "Category":</label>
									<input type="text" name="nameFilter" class="form-control" id="nameFilter" placeholder="" v-model="dataCategoryFilter.name">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="descriptionFilter">Search keywords for "Description":</label>
									<input type="text" name="descriptionFilter" class="form-control" id="descriptionFilter" placeholder="" v-model="dataCategoryFilter.description">
								</div>
							</div>
							<div class="col-12 text-right">
								<button type="button" class="button secondary mr-15" @click.prevent="clearFilter">Clean up</button>
								<button type="submit" class="button main" @click.prevent="filter">Ready</button>
							</div>
						</div>	
					</form>
				</div>		
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<p class="mb-0">Delete</p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="mb-0"><small>Are you sure to delete the category? <span class="bold">“{{category}}”</span>.</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm mr-15" data-dismiss="modal">Cancel</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="destroy">Delete</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
</template>
<script>
import axios from 'axios';
export default {
    name:"Category",
    data() {
        return {
            errors:[],
            invalid:{
				'name':0,
				'description':0,
            },
            dataCategoryFilter:{
                name:'',
                description:'',
            },
            dataCategory:{
                name:'',
                description:'',
                status:'',
            },
            showFilterCategory:{
				name:'',
                description:'',
			},
            categories:[],
            textName:'',
            textDescription:'',
            formSave:0,
            createOrEdit:"save",
            title:'',
            categoryId:'',
            category:'',
            counter:1,
			title_message_create:'',
			timeDestroy: '',
			titleBanned: 'Block',
			titleBannedAlert : 'Unlock',
			show:'show',
			show_filter:'show-filter',
            hide:'hide',
			showClass: 'show-class',
			hideClass: 'hide-class',
			title_message: '',
			createOrEdit:"save",
			cardShow:1,
			listShow:0,
			IDLE_TIMEOUT :10,
			idleSecondsTimer:0,
			idleSecondsCounter :0,
			pagination:{
				'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
			},
			offset: 2,
			cardGreen:0,
        }
    },
    methods: {
        openModalBanned(data){
			$('#modal-category').modal('hide');
			$('#modal-banned').modal('show');
			this.categoryId = data.id;
			this.category = data.name;
			this.titleBanned = data.status ? 'Block' : 'Unlock';
			this.title_message_create = data.status ? "We block the category successfully." : "We unlocked the category successfully.";
		},
		openModalBannedModal(status){
			$('#modal-category').modal('hide');
			$('#modal-banned').modal('show');
			this.titleBanned = status ? 'Block' : 'Unlock';
			this.title_message_create = status ? "We block the category successfully." : "We unlocked the category successfully.";
		},
		banned(){
			$('#modal-banned').modal('hide');
			axios.post('banned-category/'+this.categoryId).then(response=>{
			 	$("#alertCreate").show();
				this.filter();
				this.timeDestroy = setTimeout(()=>{
					$("#alertCreate").hide();
					this.cleanFields();
				}, 4000);
				this.timerAlertShow();
			}).catch(function (error) {
				console.log(error);
			});
			
		},
        destroy(){
			$('#modal-delete').modal('hide');
			axios.delete('categories/'+this.categoryId).then(response=>{
				if (response && response.data.statusCode == 200){
					this.title_message_create= "We remove the category successfully.";
			 		$("#alertCreate").show();
			 		this.filter();
			 		this.timeDestroy = setTimeout(()=>{
			 			$("#alertCreate").hide();
			 			this.cleanFields();
			 		},4000)
			 	}
			 	else{
			 		console.log(response);
			 	}
			 		this.cardGreenChange();
			 		this.cleanFields();
			 }).catch((error)=> {
			 	if (error.response.status == 422) {
			 		this.errors = error.response.data.errors;
			 		this.showErrors();
			 	}else{
			 		console.log(this.errors);
			 	}
			 });
		},
		openModalDestroy(data){
			$('#modal-delete').modal('show');
			this.categoryId= data.id;
			this.category= data.name;
		},
		openModalDestroyModal(){
			$('#modal-category').modal('hide');
			$('#modal-delete').modal('show');
		},
		showAlert(){
			$('#alert').show();
		},
        hideAlert(){
			$('#alert').hide();
			$("#alertCreate").hide();
		},
        timerAlertShow(){
			this.idleSecondsTimer = window.setInterval(this.CheckIdleTime, 1000);
			this.idleSecondsCounter = 0;
		},
        stopTime(){
			if (this.timeDestroy) {
    			clearTimeout(this.timeDestroy);
				clearInterval(this.idleSecondsTimer);
				this.filter();
				this.hideAlert();
				this.cleanFields();
  			}
		},
		CheckIdleTime() {
		    this.idleSecondsCounter++;
			if (this.idleSecondsCounter >= this.IDLE_TIMEOUT) {
				window.clearInterval(this.idleSecondsTimer);
			}
		},
        openModalEdit(data){
				this.createOrEdit= 'edit';
                this.resetErrorMessages();
                this.dataCategory= {
                    name: data.name,
                    description: data.description,
                    status:data.status,
                }
                this.title= 'Edit the category';
                this.categoryId= data.id;
				this.category= data.name;
				this.titleBanned = data.status ? 'Block' : 'Unblock';
                $('#modal-category').modal('show');
        },
		edit(){
			axios.put('categories/'+this.categoryId, this.dataCategory).then(response=>{
			 	if (response && response.data.statusCode == 200){
					$('#modal-category').modal('hide');
					this.title_message_create = "We edit the category information successfully.";
			 		$("#alertCreate").show();
			 		this.formSave=0;
			 		this.filter();
			 		this.timeDestroy = setTimeout(()=>{
			 			$("#alertCreate").hide();
			 			this.cleanFields();
			 		},4000)
			 	}
			 	else{
			 		console.log(response);
			 	}
			 		this.cardGreenChange();
			 		this.cleanFields();
			 }).catch((error)=> {
			 	if (error.response.status == 422) {
			 		this.errors = error.response.data.errors;
			 		this.showErrors();
			 	}else{
			 		console.log(this.errors);
			 	}
			 });
		},
        switchToList(){
			this.listShow=0;
			this.cardShow=1;
		},
		switchToCard(){
			this.cardShow=0;
			this.listShow=1;
		},
        clearFilter(){
			this.removeFilterName();
			this.removeFilterDescription();
		},
		removeFilterName(){
			this.dataCategoryFilter.name ='';
			this.showFilterCategory.name = 0;
			this.filter();
		},
		removeFilterDescription(){
			this.dataCategoryFilter.description ='';
			this.showFilterCategory.description = 0;
			this.filter();
		},
		showFilter(){
			$('#modal-filter').modal('show');
		},
        filter(page=''){
			var urlCategory = 'list-category-filter?page='+page;
			axios.post(urlCategory, this.dataCategoryFilter).then(response=>{
				this.categories = response.data.categories.data;
				this.counter = this.categories.length;
				this.pagination = response.data.pagination;
				$('#modal-filter').modal('hide');
				if(this.dataCategoryFilter.name != ''){
					this.showFilterCategory.name = 1;
					this.textName = this.dataCategoryFilter.name;
				}
				else{
					this.showFilterCategory.name = 0;
					this.textName = '';
				}
                if(this.dataCategoryFilter.description != ''){
					this.showFilterCategory.description = 1;
					this.textDescription = this.dataCategoryFilter.description;
				}
				else{
					this.showFilterCategory.description = 0;
					this.textDescription = '';
				}
			});
		},
        create(){
            this.cleanFields();
			this.createOrEdit= 'save';
			this.title= 'Add category';
			this.formSave=1;
        },
        closeForm(){
			this.formSave = 0;
			this.cleanFields();
		},
		validateAlerts(value){
			if(value==1){
				this.invalid.name=0;
				this.errors.name="";
			}
			if(value==2){
				this.invalid.description=0;
				this.errors.description="";
			}
		},
        cardGreenChange(){
			this.timeDestroy = setTimeout(()=>{
				this.cardGreen = 0;
			},3000)
		},
        save(){
            this.cardGreen='';
			if(this.errores){
				this.showErrors();
				return 0;
			}
			axios.post('categories', this.dataCategory).then(response=>{
			 	if (response && response.data.statusCode == 200){
			 		this.cardGreen=response.data.id;
					this.title_message_create='We add a new category.',
			 		$("#alertCreate").show();
			 		this.formSave=0;
			 		this.filter();
			 		this.timeDestroy = setTimeout(()=>{
			 			$("#alertCreate").hide();
			 			this.cleanFields();
			 		},4000)
			 	}
			 	else{
			 		console.log(response);
			 	}
			 		this.cardGreenChange();
			 		this.cleanFields();
			 }).catch((error)=> {
			 	if (error.response.status == 422) {
			 		this.errors = error.response.data.errors;
			 		this.showErrors();
			 	}else{
			 		console.log(this.errors);
			 	}
			 });
        },
        cleanFields(){
			this.resetErrorMessages();
			this.title='';
			this.categoryId = '';
			this.description = '';
			this.timeDestroy='';
			this.titleBanned= 'Block';
			this.titleBannedAlert= 'Unlock';
			this.show= 'show';
            this.hide= 'hide';
			this.title_message =  '';
			this.createOrEdit = "save";
			this.dataCategory.name='';
			this.dataCategory.description='';
			this.dataCategory.status='';
			this.IDLE_TIMEOUT= 10;
			this.idleSecondsCounter=0;
		},
        resetErrorMessages(){
			for(let inval in this.invalid) {
				this.invalid[inval]=0;
			}
		},
        showErrors(){
			this.resetErrorMessages();
			for(let error in this.errors) {
				switch(error){
					case 'name':
						this.invalid.name = 1;
					break;
					case 'description':
						this.invalid.description = 1;
					break;
				}
			}
		},
        changePage(page){
			this.pagination.current_page = page;
			this.filter(page);
		}
    },
    computed: {
		isActive(){
			return this.pagination.current_page;
		},
		pagesNumber(){
			if(!this.pagination.to){
				return [];
			} 
			var from = this.pagination.current_page - this.offset;
			if(from < 1 ){
				from = 1;
			}
			var to = from + (this.offset * 2);
			if (to >= this.pagination.last_page){
				to = this.pagination.last_page;
			}
			var pageArray = [];
			while(from <= to){
				pageArray.push(from);
				from++;
			}
			return pageArray;
		},
		nameShowError(){
			return this.invalid.name ? this.show : this.hide
		},
		descriptionShowError(){
			return this.invalid.description ? this.show : this.hide
		},
		list(){
			return this.listShow ? '' : this.hide
		},
		card(){
			return this.cardShow ? '' : this.hide
		},
		showNameFilter(){
			return this.showFilterCategory.name ? this.show_filter : this.hide
		},
		showDescriptionFilter(){
			return this.showFilterCategory.description ? this.show_filter : this.hide
		},
	},
    mounted(){
        this.filter();
		this.hideAlert();
    },
}
</script>

<style>
    .show{
        display: block;
    }
    .hide{
        display: none;
    }
	.show-filter{
        display: inline-block;
    }
</style>