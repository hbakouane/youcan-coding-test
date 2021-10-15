t<template>
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
                        <products-table :products="products" v-on:errors="getErrorsFromChild()" v-on:productsUpdated="getProducts()" />
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
            image: null
        },
        products: [],
        errors: null
    }),
    methods: {
        getProducts() {
            axios.get('/products')
            .then(res => {
                this.products = res.data
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
                // Clear the formData so that it can be fresh when doing another request
                formData.delete()
            })
            .catch(err => {
                this.errors = err.response.data.errors
            })
        },
        getErrorsFromChild(errors) {
            this.errors = errors
        }
    },
    created() {
        this.getProducts()
    }
}
</script>
