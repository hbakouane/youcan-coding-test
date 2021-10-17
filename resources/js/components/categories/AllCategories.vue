<template>
    <div class="container-fluid">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <button @click="addCategory = ! addCategory" class="btn btn-success mb-3">
                        {{ addCategory ? 'Close' : 'Add Category' }}
                    </button>
                    <div class="card my-3" v-if="addCategory">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            <div v-if="loading" class="alert alert-info">
                                <strong>Adding category ...</strong>
                            </div>
                            <div v-if="errors" class="alert alert-danger">
                                <p v-for="(error, index) in errors" :key="index">{{ error[0] }}</p>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input v-model="category.name" class="form-control" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent Category</label>
                                    <select v-model="category.parent" class="form-control" id="parent" required>
                                        <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button @click="submitCategory($event)" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div :class="{ 'col-md-8': addCategory, 'col-md-12': ! addCategory }">
                    <div class="card">
                        <div class="card-header h3 fw-bold">Categories</div>
                        <div class="card-body p-0">
                            <categories-table :categories="categories" v-on:errors="getErrors()" v-on:categoriesUpdated="getCategories()" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        categories: [],
        addCategory: false,
        category: {
            name: null,
            parent: null
        },
        loading: false,
        errors: false
    }),
    methods: {
        getCategories() {
            axios.get('/categories')
            .then(res => {
                this.categories = res.data
            })
            .catch(err => console.log(err.response))
        },
        async submitCategory(e) { 
            e.preventDefault()
            // Reset errors
            this.errors = false
            // Show loading alert
            this.loading = true
            await axios.post('/categories', this.category)
            .then(res => {
                // Refresh categories
                this.getCategories()
                // Reset the category object
                this.category.name, this.category.parent = ''
            })
            .catch(err => {
                // Show errors
                this.errors = err.response.data.errors
                //this.$refs.errorsHolder = `<strong>${err.response.data.errors.name[0]}</strong>`
            })
            .finally(() => this.loading = false)
        },
        getErrors(errors) {
            this.errors = errors
        }
    },
    mounted() {
        // use the method we created for getting categories
        this.getCategories()
    }
}
</script>

<style>

</style>