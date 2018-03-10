<template>

    <div class="container">
    <form action="#" @submit.prevent="edit ? updateRecipe(rec.id) : createRecipe()">

        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input type="name" v-model = "rec.name" class="form-control" id="nameid" placeholder="Name">
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1">Email address</label>
            <input type="email" class="form-control" v-model="rec.email" id="emailid" placeholder="name@example.com">
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1">Food</label>
            <input type="food" class="form-control" v-model="rec.food" id="foodid" placeholder="e.g. Bolognese">
        </div>


        <div class="form-group">
            <label for="exampleFormControlTextarea1">Recipe</label>
            <textarea class="form-control" id="recipeid" v-model="rec.recipe" rows="3"></textarea>
        </div>

        <div class="form-group">

            <button type="submit" v-show="!edit" class="btn btn-primary mb-2">Submit Recipe</button>
            <button type="submit" v-show="edit" class="btn btn-primary mb-2">Edit Recipe</button>

        </div>





    </form>




        <h1>Recipes</h1>



        <ul class="list-group">
<div  v-for="rec in list">
            <li class="recipies_category" v-if='rec.name=="asd"'  >
                <button @click="showRecipe(rec.id)" class="btn btn-default btn-xs">Edit</button>
            </li>
            </div>
            <li class="list-group-item" v-for="rec in list">
                {{ rec.name }} Email: {{ rec.email}}
                <br><br>
                <strong> {{ rec.food }}</strong>
                <br>
               {{ rec.recipe }}
                <br>
                <button @click="showRecipe(rec.id)" class="btn btn-default btn-xs">Edit</button>
                <button @click="deleteRecipe(rec.id)" class="btn btn-default btn-xs">Delete</button>

            </li>


        </ul>


    </div>

</template>

<script>
    export default {
        data:function(){

            return {

                edit:false,
                list:[],
                rec:{
                    id:'',
                    name:'',
                    email:'',
                    food:'',
                    recipe:''

                },

            }


        },
        mounted: function() {
            console.log('Component mounted.');
            this.fetchRecipeList();
            this.fetchCategoryList();
        },
    methods: {

            imageChanged (e){
                console.log(e.target.files[0])
                var fileReader = new FileReader()

                fileReader.readAsDataUrl(e.target.files[0])
                fileReader.onload = (e) => {
                this.rec.image = e.target.result
                }

                console.log(this.rec)


            },

            fetchRecipeList:function() {
                console.log('Fetching Recipe List');
                axios.get('api/recipes')
                    .then((response) => {
                    console.log(response.data);
                    this.list = response.data;
                }).catch((error)=> {
                    console.log(error);

            });
            },

        fetchCategoryList:function() {
            console.log('Fetching categ List');
            axios.get('api/categories')
                .then((response) => {
                console.log(response.data);
            this.cat_list = response.data;
        }).catch((error)=> {
                console.log(error);

        });
        },

        createCategory: function() {
            console.log('Creating categ');
            let self = this;
            let params = Object.assign({}, self.cat);
            axios.post('api/category/store', params)
                .then (function(){
                    self.cat.title = '';
                    self.fetchCategoryList();
                }).catch(function(error){
                console.log(error);
            });
        },


            createRecipe: function() {
                console.log('Creating recipe');
                let self = this;
                let params = Object.assign({}, self.rec);
                axios.post('api/recipe/store', params)
                    .then (function(){
                        self.rec.name = '';
                        self.rec.email = '';
                        self.rec.food = '';
                        self.rec.recipe = '';
                        self.edit = false;
                        self.fetchRecipeList();
                    }).catch(function(error){
                        console.log(error);
                });
            },

            updateRecipe: function (id) {
                console.log('update');
                let self = this;
                let params = Object.assign({}, self.rec);
                axios.patch('api/recipe/'+id, params)
                    .then(function() {
                        self.rec.name= '';
                        self.rec.email ='';
                        self.rec.food= '';
                        self.rec.recipe ='';
                        self.fetchRecipeList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },

        showRecipe: function(id){
            let self = this;
            axios.get('api/recipe/'+id)
                .then(function(response){
                    self.rec.id = response.data.id;
                    self.rec.name = response.data.name;
                    self.rec.email = response.data.email;
                    self.rec.food = response.data.food;
                    self.rec.recipe = response.data.recipe;
                });
            self.edit = true;
        },
        deleteRecipe: function(id){
            axios.delete('api/contact/'+id)
                .then(function(response){
                    self.fetchRecipeList();
                })
                .catch(function(error){
                    console.log(error);
                });
        }



    }
    }
</script>
