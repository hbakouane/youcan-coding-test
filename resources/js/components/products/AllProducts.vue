<template>
    <div>
        <div class="container-fluid">
            <div class="container">
                <button @click="addProduct = ! addProduct" class="btn btn-success mb-3">
                    {{ addProduct ? 'Close' : 'Add Product' }}
                </button>
                <div v-if="! addProduct" class="card">
                    <div class="card-header d-flex w-100">
                        <div>
                            <p class="h2 fw-bold">Products</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Filter by category</label>
                            <select v-model="filterCategory">
                                <option v-for="(category, index) in categories" :key="index">{{ category.name }}</option>
                            </select>
                            <a v-if="reset" @click="resetProducts()" class="btn text-danger">Reset</a>
                        </div>
                        <products-table :products="filtredProducts.length > 0 ? filtredProducts : products" v-on:errors="getErrorsFromChild()" v-on:productsUpdated="getProducts(page)" />
                    </div>
                </div>
                <div v-else class="card">
                    <div class="card-header h2 fw-bold">Add a Product</div>
                    <div class="card-body">
                        <div v-if="errors" class="alert alert-danger">
                            <p v-for="(error, index) in errors" :key="index">{{ error[0] }}</p>
                        </div>
                        <form enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="product.name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input v-model="product.description" id="description" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input v-model="product.price" type="number" step="0.1" id="price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input ref="file" @change="handleFileUpload($event)" type="file" accept="image/*" id="image" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="categories">Categories</label>
                                <select class="form-control" v-model="product.category_id" multiple>
                                    <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button @click="submitProduct($event)" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        addProduct: false,
        product: {
            name: '',
            description: '',
            price: '',
            image: null,
            category_id: []
        },
        products: [],
        immortalProducts: [],
        errors: null,
        categories: [],
        filterCategory: null,
        reset: false,
        filtredProducts: { data: [] }
    }),
    watch: {
        async filterCategory() {
            await this.getProducts()
            // Show the reset button
            this.reset = true
            this.products.data = this.immortalProducts.data
            let filtredProducts = []
            // Filter products by a category
            this.products.data.forEach(product => {
                product.categories.forEach(category => {
                    if (category.name == this.filterCategory) {
                        filtredProducts.push(product)
                    }
                });
            })
            this.products.data = filtredProducts
        }
    },
    methods: {
        async getProducts() {
            await axios.get('/products')
            .then(res => {
                this.products = res.data
                this.immortalProducts = res.data
            })
            .catch(err => console.log(err.response))
        },
        getCategories() {
            axios.get('/categories')
            .then(res => {
                this.categories = res.data
            })
            .catch(err => console.log(err.response))
        },
        handleFileUpload(e) {
            this.product.image = this.$refs.file.files[0];
        },
        submitProduct(e) {
            e.preventDefault()
            let formData = new FormData()
            formData.append('image', this.product.image)
            formData.append('name', this.product.name)
            formData.append('description', this.product.description)
            formData.append('price', this.product.price)
            formData.append('category_id', this.product.category_id)
            axios.post('/products', formData)
            .then(() => {
                // Clear the errors after a successful request
                this.errors = null
                // Refresh the products
                this.getProducts()
                // Hide add product form
                this.addProduct = false
                // Reset the product object value
                this.product.name = null
                this.product.description = null
                this.product.price = null
                this.product.image = null
                this.product.category_id = []
                // Clear the formData so that it can be fresh when doing another request
                formData.delete()
            })
            .catch(err => {
                this.errors = err.response.data.errors
            })
        },
        getErrorsFromChild(errors) {
            this.errors = errors
        },
        resetProducts() {
            this.getProducts()
        }
    },
    created() {
        this.getProducts()
        this.getCategories()
    }
}
</script>
