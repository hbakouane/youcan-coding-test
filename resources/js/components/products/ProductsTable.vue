<template>
    <div>
        <table v-if="products.length > 0" class="table table-striped rounded border">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="index">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>${{ product.price }}</td>
                    <td>
                        <img :src="product.image" class="img-fluid product-img">
                    </td>
                    <td>
                        <button @click="deleteProduct(product.id)" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p v-else class="p-3">No data to show.</p>
    </div>
</template>

<script>
export default {
    props: ['products'],
    methods: {
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
