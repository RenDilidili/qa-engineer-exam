<template>
    <div class="container">
        <h2 class="row justify-content ml-2 mb-4">Add Product</h2>
        <div class="row justify-content-center">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <b-alert v-if="success"
                                :show="dismissCountDown"
                                dismissible
                                variant="success"
                                @dismissed="dismissCountDown=0"
                                @dismiss-count-down="countDownChanged"
                                ><h4>Product Added!</h4>
                            </b-alert>
                        </div>
                        <form @submit.prevent="submitFormOne">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model.trim="$v.name.$model" :class="{'is-invalid':$v.name.$error && !success, 'is-valid':!$v.name.$invalid }" id="name" placeholder="Product name">
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.name.required && !success">Product name is required</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="category">Category</label>
                                    <select class="form-control"  v-model.trim="$v.category.$model" :class="{'is-invalid':$v.category.$error && !success, 'is-valid':!$v.category.$invalid}" id="category" >
                                    <option disabled selected>-Product Category-</option>
                                    <option v-for="(product) in products" :key="product.id">{{product}}</option>
                                    </select>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.category.required && !success">Select a product category</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control"  v-model.trim="$v.description.$model" :class="{'is-invalid':$v.description.$error && !success, 'is-valid':!$v.description.$invalid}" id="description" rows="3" placeholder="Describe the product.." maxlength="250"></textarea>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.description.required && !success">Description cannot be empty</span>
                                </div>
                            </div>
                               <button type="submit" v-if="!stepOneStatus" class="btn btn-primary">Next</button>
                        </form >
                        <form v-if="stepOneStatus ==true" @submit.prevent="submitFormTwo">
                                <div class="form-group">
                                    <label for="image">Upload an image</label>
                                    <input type="file"  v-on:change="onFileChange" class="form-control-file" id="image" accept="image/*" :class="{'is-invalid':!image && !success, 'is-valid':image !==''}" multiple>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">
                                        <span v-if="!image && !success">No image uploaded</span>
                                    </div>
                                </div>
                                <div v-if="image" class="form-group">
                                     <img :src="image" />
                                </div>
                            <button type="submit" v-if="stepOneStatus && !stepTwoStatus" class="btn btn-primary">Next</button>
                        </form>
                        <form v-if="stepTwoStatus ==true" @submit.prevent="submitLastForm">
                            <div class="form-group">
                                <b-col class="my-1" sm="5">
                                    <b-row sm="5">
                                        <b-form-datepicker v-model="date" :class="{'is-invalid':!date && !success, 'is-valid':date}"></b-form-datepicker>
                                    </b-row>
                                </b-col>
                                <b-col class="my-1" sm="5">
                                  <b-row sm="3">
                                        <b-form-timepicker v-model="time" locale="en" :class="{'is-invalid':!time && !success, 'is-valid':time}"></b-form-timepicker>
                                    </b-row>
                                </b-col>
                                <b-col class="invalid-feedback"> <span v-if="!date || !time">Date and Time is required</span></b-col>
                            </div>
                            <button type="submit" v-if="stepTwoStatus" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, minLength, maxLength, between } from 'vuelidate/lib/validators'
import axios from 'axios'
    export default {
        name:'CreateComponent',
        data: function(){
            return{
                products: {},
                name: '',
                category: '',
                description: '',
                date: '',
                time: '',
                datetime: '',
                image:[],
                stepOneStatus: false,
                stepTwoStatus: false,
                finalStepStatus: false,
                imageErr:false,
                success:'',
                dismissSecs: 5,
                dismissCountDown: 0
            }
        },
        validations: {
            name:{
                required
            },
            category:{
                required
            },
            description:{
                required
            }
        },
        mounted() {
                this.getResults();
        },

        methods: {
        // Our method to GET results from a Laravel endpoint
            addProduct(){
                axios.post('product',{
                    name : this.name,
                    category : this.category,
                    description : this.description,
                    datetime : this.datetime,
                }).then(
                    res=>{
                        location.replace('http://127.0.0.1:8000/list'),
                        this.productList()
                        // this.name= ' ',
                        // this.category= ' ',
                        // this.description= ' ',
                        // this.datetime= ' ',
                        // this.date=' ',
                        // this.time=' ',
                        // this.image ='',
                        // this.stepOneStatus=false,
                        // this.stepTwoStatus=false,
                        // this.finalStepStatus=false,
                        // this.success = res.data,
                        // this.showAlert()
                    }) .catch(error => {
                            console.log(error.response)
                    });
            },
            getResults() {
                axios.get('api/category')
                    .then(response => {
                        this.products = response.data;
                    });
            },
            submitFormOne(){
                this.$v.$touch()
                if(this.$v.$invalid){
                    this.stepOneStatus =false
                }else{
                    this.stepOneStatus =true
                }
            },
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            showAlert() {
                this.dismissCountDown = this.dismissSecs
            },
             submitFormTwo(){
                this.$v.$touch()
                if(!this.$v.$invalid){
                    if(!this.image||this.image==''){
                         this.stepTwoStatus =false;
                         this.imageErr=true
                    }else{
                        this.stepTwoStatus =true
                        this.imageErr=false
                    }
                }
            },
             submitLastForm(){
                this.$v.$touch()
                if(!this.$v.$invalid){
                    if(this.date=='' || this.time==''){
                        this.finalStepStatus =false;
                        this.datetimeErr=true
                    }else{
                        this.datetime= this.date +' '+ this.time
                        this.finalStepStatus =true
                        this.datetimeErr=false
                        this.addProduct();
                    }
                }
             },
             onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

        }
    }
</script>
<style>
img {
  width: 30%;
  margin: auto;
  display: block;
  margin-bottom: 10px;
}
</style>

