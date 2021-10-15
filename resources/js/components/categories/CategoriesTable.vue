<template>
    <div>
        <table v-if="categories.length > 0" class="table table-striped rounded border">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category name</th>
                    <th scope="col">Parent</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categories" :key="index">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td>{{ getParentName(category.parent) }}</td>
                    <td>
                        <button @click="deleteCategory(category.id)" class="btn btn-danger">
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
    props: ['categories'],
    methods: {
        getParentName(parentId) {
            let category = this.categories.filter(category => category.id == parentId)
            return category[0] ? category[0].name : ''
        },
        async deleteCategory(categoryId) {
            await axios.delete(`/categories/${categoryId}`)
            .then(() => this.$emit('categoriesUpdated'))
            .catch(err => this.$emit('errors', err.response.data.errors))
        }
    }
}
</script>

<style>

</style>