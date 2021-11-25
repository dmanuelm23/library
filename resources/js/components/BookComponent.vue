<template>
    <div class="content sm">
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    <ul class="breadcrumbs">
                        <li><a href="/home">Home</a></li>
                        <li>Books</li>
                    </ul>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-12 col-sm-6 col-md-8 col-lg-6">
                    <h1>Books</h1>
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
                                            v-model="dataBook.name"
                                        >
                                        <p class="message" v-for="(e_name, index) in errors.name" :key="index">{{e_name}}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group" :class="{'error':invalid.author}">
                                        <label for="author">Author:</label>
                                        <div class="form-group" >
                                            <input
												type="text"
                                                name="author"
                                                id="author"
                                                class="form-control"
                                                :class="{'form-alert':invalid.author}"
                                                required
                                                @click="validateAlerts(2)"
                                                placeholder="Author"
                                                v-model="dataBook.author">
                                            <p class="message" v-for="(e_author, index) in errors.author" :key="index">{{e_author}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group" :class="{'error':invalid.publication_date}">
                                        <label for="publication_date">Publication date:</label>
                                        <div class="form-control-icono calendario">
                                            <datepicker
                                                name="publication_date"
                                                id="publication_date"
                                                class="form-control v3dp__datepicker"
                                                v-model="dataBook.publication_date"
                                                :class="{'form-alert':invalid.publication_date}"
                                                inputFormat="dd/MM/yyyy"
                                                v-bind:locale="es"
                                                :bootstrap-styling="true"
                                                @click="validateAlerts(3)"
                                            ></datepicker>
                                            <i class="ri-calendar-2-fill"></i>
                                        </div>
                                        <p class="message" v-for="(e_publication_date, index) in errors.publication_date" :key="index">{{e_publication_date}}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group" :class="{'error':invalid.category_id}">
                                        <label for="category_id">Category</label>
                                        <Select2 
                                            @click="validateAlerts(4)"
                                            v-model="dataBook.category_id"
                                            :options="categories"
                                        />
                                        <p class="message" v-for="(e_publication_date, index) in errors.publication_date" :key="index">{{e_publication_date}}</p>
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
                                    <input type="text" name="findName" class="form-control" id="findName" placeholder="Search" v-model="dataBookFilter.name">
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
                                    <button class="button-icon right mr-15" :class="showAuthorFilter">Author: {{textAuthor}} <i class="ri-close-line" @click.prevent="removeFilterAuthor()"></i></button>
                                    <button class="button-icon right mr-15" :class="showPublicationDateFilter">Publication date: {{textPublicationDate}} <i class="ri-close-line" @click.prevent="removeFilterPublicationDate()"></i></button>
                                    <button class="button-icon right mr-15" :class="showCategoryFilter">Category: {{textCategory}} <i class="ri-close-line" @click.prevent="removeFilterCategory()"></i></button>
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
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" v-for="book in books" :key="book.id">
                            <div class="caja xs" :class="{'gris':book.status === 0, 'verde':book.id === cardGreen}">
                                <h4 class="text-and-circle-button">{{book.name}}</h4> 
                                <button v-if="book.status >= 1" class="button-circle hover red align-top float-right" @click="openModalDestroy(book)"><i class="ri-delete-bin-line"></i></button>
								<button v-if="book.status === 0" class="button-circle disabled" data-toggle="tooltip" data-placement="top" title='Book block'><i class="ri-delete-bin-line"></i></button>                                
                                <div class="small">Author</div>
                                <p>{{book.author}}</p>
                                <div class="small">Publication date</div>
                                <p>{{book.publication_date}}</p>
                                <div class="small">Category</div>
                                <p>{{book.category_name}}</p>
								<div class="small">Status</div>
								<p v-if="book.status==0">Locked</p>
                                <p v-if="book.status==1">Available</p>
								<p v-if="book.status==2">Not available</p>
								<div class="small">User</div>
								<p v-for="user in book.books_users" :key="user.id">{{user.name}}</p>
                                <div class="text-right">
                                    <button v-if="book.status >= 1" class="button-circle main mr-7" @click="openModalEdit(book)"><i class="ri-pencil-fill"></i></button>
									<button v-if="book.status === 0" class="button-circle disabled" data-toggle="tooltip" data-placement="top" title='Book block'><i class="ri-pencil-fill"></i></button>
                                    <button class="button-circle main mr-7" @click.prevent="openModalBanned(book)">
                                        <i :class="book.status=== 0  ? 'ri-lock-line' : 'ri-lock-unlock-line'"></i>
                                    </button>
									<button v-if="book.status === 1" class="button-circle main mr-7" @click="openModalBorrow(book)" title='Book available'><i class="ri-contacts-book-2-line"></i></button>
									<button v-if="book.status === 2" class="button-circle disabled" data-toggle="tooltip" data-placement="top" title='Book not available'><i class="ri-contacts-book-2-line"></i></button>

									<button v-if="book.status === 2" class="button-circle main mr-7" @click="openModalReturnBook(book)" title='Return book'><i class="ri-contacts-book-upload-line"></i></button>
                                </div>
                            </div>
                        </div>	
                    </div>
                    <div class="row mb-30" :class="list">	
                        <div class="col-12 mb-15"  v-for="book in books" :key="book.id">
                            <div class="caja sm lista" :class="{'gris':book.status=== 0}">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="small">Name</div>
                                                <p>{{book.name}}</p> 
                                            </td>
                                            <td>
                                                <div class="small">Author</div>
                                                <p>{{book.author}}</p>
                                            </td>
                                            <td>
                                                <div class="small">Publication date</div>
                                                <p>{{book.publication_date}}</p>
                                            </td>
                                            <td>
                                                <div class="small">Category</div>
                                                <p>{{book.category_name}}</p>
                                            </td>
                                            <td class="text-right">
                                                <button class="button-circle main mr-7" @click="openModalEdit(book)"><i class="ri-pencil-fill"></i></button>
                                                <button class="button-circle hover mr-7" @click.prevent="openModalBanned(book)">
                                                    <i :class="book.status=== 0  ? 'ri-lock-line' : 'ri-lock-unlock-line'"></i>
                                                </button>
                                                <button class="button-circle red align-top mb-0" @click="openModalDestroy(book)"><i class="ri-delete-bin-line"></i></button>
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
						<p class="mb-0">{{titleBanned}} book</p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="mb-0"><small>We are going to {{titleBanned}} the book <span class="bold">“{{book}}”</span>. Are you sure you want to do it?</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="banned">{{titleBanned}}</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="modal-book" role="dialog" aria-hidden="true">
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
                                        v-model="dataBook.name"
                                    >
                                    <p class="message" v-for="(e_name, index) in errors.name" :key="index">{{e_name}}</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.author}">
                                    <label for="author">Author:</label>
                                    <div class="form-group" >
                                        <input
                                            type="text"
                                            name="author_edit"
                                            id="author_edit"
                                            class="form-control"
                                            :class="{'form-alert':invalid.author}"
                                            required
                                            placeholder="Author"
                                            @click="validateAlerts(2)"
                                            v-model="dataBook.author">
                                        <p class="message" v-for="(e_author, index) in errors.author" :key="index">{{e_author}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.publication_date}">
                                    <label for="publication_date">Publication date:</label>
                                    <div class="form-control-icono calendario">
                                        <datepicker
                                            name="publication_date_edit"
                                            id="publication_date_edit"
                                            class="form-control v3dp__datepicker"
                                            v-model="dataBook.publication_date"
                                            :class="{'form-alert':invalid.publication_date}"
                                            inputFormat="dd/MM/yyyy"
                                            v-bind:locale="es"
                                            :bootstrap-styling="true"
                                            @click="validateAlerts(3)"
                                        ></datepicker>
                                        <i class="ri-calendar-2-fill"></i>
                                    </div>
                                    <p class="message" v-for="(e_publication_date, index) in errors.publication_date" :key="index">{{e_publication_date}}</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.category_id}">
                                    <label for="category_id">Category</label>
                                    <Select2 
                                        @click="validateAlerts(4)"
                                        v-model="dataBook.category_id"
                                        :options="categories"
                                    />
                                    <p class="message" v-for="(e_publication_date, index) in errors.publication_date" :key="index">{{e_publication_date}}</p>
                                </div>
                            </div>
							<div class="col-12 mt-15" :class="{'text-right':createOrEdit=='save'}">
								<button v-if="createOrEdit=='edit'" type="button" class="button secondary mr-15" @click="openModalDestroyModal()">Delete <i class="ri-delete-bin-line"></i></button>
								<button v-if="createOrEdit=='edit'" type="button" class="button secondary mr-12"  @click.prevent="openModalBannedModal(dataBook.status)">{{titleBanned}}<i class="ri-lock-line"></i></button>
								<button v-if="createOrEdit=='edit'" type="button" class="button main float-right" @click.prevent="edit">Save</button>
							</div>
						</div>	
					</form>
				</div>		
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-filter" role="dialog" aria-hidden="true">
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
									<label for="nameFilter">Search keywords for "Book":</label>
									<input type="text" name="nameFilter" class="form-control" id="nameFilter" placeholder="" v-model="dataBookFilter.name">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="authorFilter">Search keywords for "Author":</label>
									<input type="text" name="authorFilter" class="form-control" id="authorFilter" placeholder="" v-model="dataBookFilter.author">
								</div>
							</div>
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="publicationDateFilter">Publication date:</label>
                                     <div class="form-control-icono calendario">
                                        <datepicker
                                            name="publicationDateFilter"
                                            id="publicationDateFilter"
                                            class="form-control v3dp__datepicker"
                                            v-model="dataBookFilter.publication_date"
                                            inputFormat="dd/MM/yyyy"
                                            v-bind:locale="es"
                                            :bootstrap-styling="true"
                                        ></datepicker>
                                        <i class="ri-calendar-2-fill"></i>
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-md-6">
                                <label for="category_id">Category</label>
                                <Select2 
                                    v-model="dataBookFilter.category_id"
                                    :options="categories"
									@select="mySelectEvent($event)"
                                />
                            </div>
							<div class="col-12 text-right">
								<button type="button" class="button secondary mr-15" @click.prevent="clearFilter">Clean up</button>
								<button type="submit" class="button main" @click.prevent="filter()">Ready</button>
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
						<p class="mb-0"><small>Are you sure to delete the book? <span class="bold">“{{book}}”</span>.</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm mr-15" data-dismiss="modal">Cancel</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="destroy">Delete</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="modal-borrow" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="mb-0">Borrow books</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cleanFields()">
						<span aria-hidden="true">×</span>
					</button>
				</div>	
				<div class="modal-body">
					<form>
                        <div class="row mt-15">
							<div class="col-12 col-md-12">
								<h4>{{book}}/ {{author}}</h4>
							</div>
                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.user_id}">
                                    <label for="user_id">Users</label>
                                    <Select2 
                                        @click="validateAlerts(5)"
                                        v-model="dataBorrow.user_id"
                                        :options="users"
										@select="selectUser($event)"
                                    />
                                    <p class="message" v-for="(e_user_id, index) in errors.user_id" :key="index">{{e_user_id}}</p>
                                </div>
                            </div>
							<div class="col-12 mt-15">
								<button type="button" class="button main float-right" @click.prevent="borrow()">Borrow</button>
							</div>
						</div>	
					</form>
				</div>		
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-return-book" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<p class="mb-0">Return book</p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="mb-0"><small>Return the book <span class="bold">“{{book}}”</span>. </small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="returnBook()">Return book</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment'
import Datepicker from 'vue3-datepicker'
import { es } from 'date-fns/locale'
import { ref } from 'vue'
import Select2 from './Select2';
export default {
    name:"Book",
    components:{
        Datepicker,
        Select2,
    },
    data() {
        return {
            errors:[],
			es:es,
            invalid:{
				'name':0,
                'author':0,
				'publication_date':0,
                'category_id':0,
				'user_id':0,
            },
            dataBookFilter:{
                name:'',
                author:'',
                publication_date:'',
                category_id:'',
            },
            dataBook:{
                name:'',
                author:'',
                publication_date:'',
                category_id:'',
                status:'',
            },
            showFilterBook:{
				name:'',
                author:'',
                publication_date:'',
                category_id:'',
			},
			dataBorrow:{
				user_id:'',
				book_id:'',
			},
            books:[],
			categories:[],
			users:[],
            textName:'',
            textAuthor:'',
            textPublicationDate:'',
            textCategory:'',
            formSave:0,
            createOrEdit:"save",
            title:'',
            bookId:'',
            book:'',
			author:'',
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
			picked : ref(new Date()),
			items:{},
        }
    },
    methods: {
		returnBook()
		{
			$('#modal-return-book').modal('hide');
			axios.post('return-book/'+this.bookId).then(response=>{
				this.title_message_create= "Book successfully returned to the library.";
			 	$("#alertCreate").show();
				this.filter();
				this.cleanFields();
				this.timeDestroy = setTimeout(()=>{
					$("#alertCreate").hide();
				}, 4000);
				this.timerAlertShow();
			}).catch(function (error) {
				console.log(error);
			});
		},
		openModalReturnBook(data)
		{
			$('#modal-return-book').modal('show');
			this.bookId = data.id;
			this.book = data.name;
		},
		selectUser({id, text}){
            let items = {id, text};
			this.dataBorrow.user_id= items.id;
        },
		borrow(){
			$('#modal-borrow').modal('hide');
			axios.post('borrow-book', this.dataBorrow).then(response=>{
				if (response && response.data.statusCode == 200){
					this.title_message_create= "Book borrowed to user successfully.";
			 		$("#alertCreate").show();
			 		this.filter();
					this.cleanFields();
			 		this.timeDestroy = setTimeout(()=>{
			 			$("#alertCreate").hide();
			 		},4000)
			 	}
			 	else{
			 		console.log(response);
			 	}
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
		openModalBorrow(data){
			$('#modal-borrow').modal('show');
			this.dataBorrow.book_id = data.id;
			this.book = data.name;
			this.author = data.author;
		},
		mySelectEvent({id, text}){
            this.items = {id, text};
			this.textCategory= this.items.text;
        },
        openModalBanned(data){
			$('#modal-book').modal('hide');
			$('#modal-banned').modal('show');
			this.bookId = data.id;
			this.book = data.name;
			this.titleBanned = data.status ? 'Block' : 'Unlock';
			this.title_message_create = data.status ? "We block the book successfully." : "We unlocked the book successfully.";
		},
		openModalBannedModal(status){
			$('#modal-book').modal('hide');
			$('#modal-banned').modal('show');
			this.titleBanned = status ? 'Block' : 'Unlock';
			this.title_message_create = status ? "We block the book successfully." : "We unlocked the book successfully.";
		},
		banned(){
			$('#modal-banned').modal('hide');
			axios.post('banned-book/'+this.bookId).then(response=>{
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
			axios.delete('books/'+this.bookId).then(response=>{
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
			this.bookId= data.id;
			this.book= data.name;
		},
		openModalDestroyModal(){
			$('#modal-book').modal('hide');
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
                this.dataBook= {
                    name: data.name,
                    author: data.author,
                    publication_date: ref(new Date(data.publication_date.replace(/-/g, '\/'))),
                    category_id: data.category_id,
                    status:data.status,
                }
                this.title= 'Edit the category';
                this.bookId= data.id;
				this.book= data.name;
				this.titleBanned = data.status ? 'Block' : 'Unblock';
                $('#modal-book').modal('show');
        },
		edit(){
			this.dataBook.publication_date= moment(this.dataBook.publication_date).format(moment.HTML5_FMT.DATE),
			axios.put('books/'+this.bookId, this.dataBook).then(response=>{
			 	if (response && response.data.statusCode == 200){
					$('#modal-book').modal('hide');
					this.title_message_create = "We edit the book information successfully.";
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
			this.removeFilterAuthor();
            this.removeFilterPublicationDate();
            this.removeFilterCategory();
		},
		removeFilterName(){
			this.dataBookFilter.name ='';
			this.showFilterBook.name = 0;
			this.filter();
		},
		removeFilterAuthor(){
			this.dataBookFilter.author ='';
			this.showFilterBook.author = 0;
			this.filter();
		},
        removeFilterPublicationDate(){
			this.dataBookFilter.publication_date ='';
			this.showFilterBook.publication_date = 0;
			this.filter();
		},
        removeFilterCategory(){
			this.dataBookFilter.category_id ='';
			this.showFilterBook.category_id = 0;
			this.filter();
		},
		showFilter(){
			$('#modal-filter').modal('show');
		},
        filter(page=''){
			if(this.dataBookFilter.publication_date!='')
				this.dataBookFilter.publication_date= moment(this.dataBookFilter.publication_date).format(moment.HTML5_FMT.DATE);
			var urlBook = 'list-book-filter?page='+page;
			axios.post(urlBook, this.dataBookFilter).then(response=>{
				console.log(response);
				this.books = response.data.books.data;
				this.categories = response.data.categories;
				this.users = response.data.users;
				this.counter = this.books.length;
				this.pagination = response.data.pagination;
				$('#modal-filter').modal('hide');
				if(this.dataBookFilter.name != ''){
					this.showFilterBook.name = 1;
					this.textName = this.dataBookFilter.name;
				}
				else{
					this.showFilterBook.name = 0;
					this.textName = '';
				}
                if(this.dataBookFilter.author != ''){
					this.showFilterBook.author = 1;
					this.textAuthor = this.dataBookFilter.author;
				}
				else{
					this.showFilterBook.author = 0;
					this.textAuthor = '';
				}
                if(this.dataBookFilter.publication_date != ''){
					this.showFilterBook.publication_date = 1;
					this.textPublicationDate = this.dataBookFilter.publication_date;
				}
				else{
					this.showFilterBook.publication_date = 0;
					this.textPublicationDate = '';
				}

				if(this.dataBookFilter.category_id != ''){
					this.showFilterBook.category_id = 1;
				}
				else{
					this.showFilterBook.category_id = 0;
					this.textCategory = '';
				}

			});
		},
        create(){
            this.cleanFields();
			this.createOrEdit= 'save';
			this.title= 'Add book';
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
				this.invalid.author=0;
				this.errors.author="";
			}
            if(value==3){
				this.invalid.publication_date=0;
				this.errors.publication_date="";
			}
            if(value==4){
				this.invalid.category_id=0;
				this.errors.category_id="";
			}
			if(value==5){
				this.invalid.user_id=0;
				this.errors.user_id="";
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
			this.dataBook.publication_date= moment(this.dataBook.publication_date).format(moment.HTML5_FMT.DATE);
			axios.post('books', this.dataBook).then(response=>{
			 	if (response && response.data.statusCode == 200){
			 		this.cardGreen=response.data.id;
					this.title_message_create='We add a new book.',
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
			this.bookId = '';
			this.book = '';
			this.timeDestroy='';
			this.titleBanned= 'Block';
			this.titleBannedAlert= 'Unlock';
			this.show= 'show';
            this.hide= 'hide';
			this.title_message =  '';
			this.createOrEdit = "save";
			this.dataBook.name='';
			this.dataBook.author='';
            this.dataBook.publication_date='';
            this.dataBook.category_id='';
			this.dataBook.status='';
			this.IDLE_TIMEOUT= 10;
			this.idleSecondsCounter=0;
			this.dataBorrow.user_id = undefined;
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
					case 'author':
						this.invalid.author = 1;
					break;
                    case 'publication_date':
						this.invalid.publication_date = 1;
					break;
                    case 'category_id':
						this.invalid.category_id = 1;
					break;
					case 'user_id':
						this.invalid.user_id = 1;
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
		list(){
			return this.listShow ? '' : this.hide
		},
		card(){
			return this.cardShow ? '' : this.hide
		},
		showNameFilter(){
			return this.showFilterBook.name ? this.show_filter : this.hide
		},
		showAuthorFilter(){
			return this.showFilterBook.author ? this.show_filter : this.hide
		},
        showPublicationDateFilter(){
			return this.showFilterBook.publication_date ? this.show_filter : this.hide
		},
        showCategoryFilter(){
			return this.showFilterBook.category_id ? this.show_filter : this.hide
		},
	},
    mounted(){
        this.filter();
		this.hideAlert();
    },
}
</script>

<style lang="css" scoped>
	.select2-selection__rendered {
        line-height: calc(3rem + 1px) !important;
    }
    .select2-container .select2-selection--single {
        height: calc(3rem + 1px) !important;
    }
    .select2-selection__arrow {
        height: calc(3rem + 1px) !important;
    }
    .show{
        display: block;
    }
    .hide{
        display: none;
    }
	.show-filter{
        display: inline-block;
    }

	 .vw_table{
            max-width: 70vw;
            overflow-y: hidden;
    }
    .pleft0{
        padding-left: 0px;
    }
    .p-datepicker{
        position: 'fixed';
        overflow: 'visible';
        z-index: 1064!important;
    }
    .img-radius{
        border: solid #555 2px;
        display: flex;
        margin: 0 auto;
        border-radius: 50%;
    }
    .v3dp__datepicker{

		--popout-bg-color:var(--vdp-bg-color, #fff);

		--box-shadow:var(--vdp-box-shadow,0 4px 10px 0 rgba(128, 144, 160, 0.1), 0 0 1px 0 #d5d9e0);

		--text-color:var(--vdp-text-color, #000000);

		--border-radius:var(--vdp-border-radius, 3px);

		--heading-size:var(--vdp-heading-size, 2.5em);

		--heading-weight:var(--vdp-heading-weight, bold);

		--heading-hover-color:var(--vdp-heading-hover-color, #eeeeee);

		--arrow-color:var(--vdp-arrow-color, currentColor);

		--elem-color:var(--vdp-elem-color, currentColor);

		--elem-disabled-color:var(--vdp-disabled-color, #d5d9e0);

		--elem-hover-color:var(--vdp-hover-color, #fff);

		--elem-hover-bg-color:var(--vdp-hover-bg-color, #EE7421);

		--elem-selected-color:var(--vdp-selected-color, #fff);

		--elem-selected-bg-color:var(--vdp-selected-bg-color, #EE7421);

		--elem-font-size:var(--vdp-elem-font-size, 0.8em);

		--elem-border-radius:var(--vdp-elem-border-radius, 3px);

		--divider-color:var(--vdp-divider-color, var(--elem-disabled-color));
    }
</style>