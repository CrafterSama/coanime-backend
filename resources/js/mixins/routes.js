const routes = {
    methods: {
        /** Routes to navigate in the Web App */
        routes: function (type, slug = null, titleType = null) {
            /** An Article */
            if (type === 'posts') {
                return `/posts/${slug}`
            }
            /** Articles By Categories */
            if (type === 'category') {
                return `/categorias/${slug}`
            }
            /** Articles By Tags */
            if (type === 'tag') {
                return `/tags/${slug}`
            }
            /** A Title */
            if (type === 'title') {
                return `/ecma/titulos/${titleType}/${slug}`
            }
            /** Titles By Types */
            if (type === 'type') {
                return `/ecma/titulos/${slug}`
            }
            /** Titles By Genres */
            if (type === 'genre') {
                return `/ecma/generos/${slug}`
            }
            /** A Magazine */
            if (type === 'magazine') {
                return `/ecma/revistas/${slug}`
            }
            /** A Person */
            if (type === 'people') {
                return `/ecma/personas/${slug}`
            }
            /** A Company */
            if (type === 'company') {
                return `/ecma/empresas/${slug}`
            }
            /** User Profile */
            if (type === 'user') {
                return `/users/profile/${slug}`
            }
        }
    }
}

export default routes
