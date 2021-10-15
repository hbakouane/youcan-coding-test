const { default: axios } = require("axios")

let getCategories = () => {
    axios.get('/categories')
}

export default getCategories