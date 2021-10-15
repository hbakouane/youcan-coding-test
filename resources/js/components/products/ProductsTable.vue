<template>
    <div>
        <div v-if="products.data">
            <table class="table table-striped rounded border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products.data" :key="index">
                        <td>{{ product.id }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.description }}</td>
                        <td>${{ product.price }}</td>
                        <td>
                            <span v-for="(category, index) in product.categories" :key="index" class="badge bg-secondary text-light">
                                {{ category.name }}
                            </span>
                        </td>
                        <td>
                            <img :src="product.image" class="img-fluid product-img" alt="if this image doesn't show up, then it is because you haven't ran php artisan storage:link or this object was created from the unit testing">
                        </td>
                        <td>
                            <button @click="deleteProduct(product.id)" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :data="products" @pagination-change-page="getProducts"></pagination>
        </div>
        <p v-else class="p-3">No data to show.</p>
    </div>
</template>

<script>
export default {
    props: ['products'],
    methods: {
        getProducts(page = 1) {
            axios.get('/products?page=' + page)
            .then(res => {
                this.products = res.data
            })
            .catch(err => console.log(err.response))
        },
        async deleteProduct(productId) {
            await axios.delete(`/products/${productId}`)
            .then(() => {
                this.$emit('productsUpdated')
            })
            .catch(err => this.$emit('errors', err.response.data.errors))
        }
    }
}
</script>
