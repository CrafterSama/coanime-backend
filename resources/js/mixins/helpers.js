const helpers = {
  methods: {
    /**
     * @method strToSlug
     * @description
     * change a normal string to a slug string
     *
     * @param {string} str - the string to convert
     *
     * */
    strToSlug(str) {
      str = str.replace(/^\s+|\s+$/g, '') // trim
      str = str.toLowerCase()

      // remove accents, swap ñ for n, etc
      var from = 'åàáãäâèéëêìíïîòóöôùúüûñç·_,:;/'
      var to = 'aaaaaaeeeeiiiioooouuuunc-----'

      for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
      }

      str = str
        .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-') // collapse dashes

      return str
    },
    /**
     * @method routes
     * @description
     * Routes to navigate in the Web App
     *
     * @param {string} type - is the type of resource you need to linked
     * @param {string} slug - is the slug of the resource you need to linked
     * @param {string} titleType - is the type of encyclopedia resource you need to linked
     *
     * */
    routes(type, slug = null, titleType = null, image = false) {
      /** An Article */
      if (type === 'posts') return `/posts/${slug}`
      /** Articles By Categories */
      if (type === 'category') return `/categorias/${slug}`
      /** Articles By Tags */
      if (type === 'tag') return `/tags/${slug}`
      /** A Title */
      if (type === 'title') return `/ecma/titulos/${titleType}/${slug}`
      /** A Title from home Daily Schedule */
      if (type === 'fromSchedule') return `/ecma/titulos/${this.strToSlug(titleType)}/${this.strToSlug(slug)}`
      /** Titles By Types */
      if (type === 'type') return `/ecma/titulos/${slug}`
      /** Titles By Genres */
      if (type === 'genre') return `/ecma/generos/${slug}`
      /** A Magazine */
      if (type === 'magazine') return `/ecma/revistas/${slug}`
      /** A Magazine Image */
      if (type === 'magazine-image') {
        if (image) return `https://coanime.net/images/encyclopedia/magazine/${slug}`
        return `/images/encyclopedia/magazine/${slug}`
      }
      /** A Person */
      if (type === 'people') return `/ecma/personas/${slug}`
      /** A Person Image URL */
      if (type === 'people-image') {
        if (image) return `https://coanime.net/images/encyclopedia/people/${slug}`
        return `/images/encyclopedia/people/${slug}`
      }
      /** A Company */
      if (type === 'company') return `/ecma/empresas/${slug}`
      /** User Profile */
      if (type === 'user') return `/users/profile/${slug}`
      /** User Profile Image */
      if (type === 'user-image') return `/images/profiles/${slug}`
    },
    /**
     * @method asset
     * @description
     * return a path to the asset
     *
     * @param {string} resource - is the resource you need to linked
     *
     * */
    asset: (resource) => `${window.location.origin}/assets/${resource}`,
    /**
     * @method defaultImage
     * @description
     * Routes to navigate in the Web App
     *
     * @param {string} string - is the type of resource you need to linked
     *
     * */
    defaultImage: string => string === 'https://cdn.myanimelist.net/img/sp/icon/apple-touch-icon-256.png' ? `${window.location.origin}/assets/images/coanime-logo-default.svg` : string,
    /**
     * @method getSrcSetString
     * @description
     * Routes to navigate in the Web App
     *
     * @param {string} string - is the type of resource you need to linked
     *
     */
    getSrcSetString: string => `${string.replace('1920', '480')} 480w, ${string.replace('1920', '640')} 640w, ${string.replace('1920', '960')} 960w, ${string.replace('1920', '1280')} 1280w, ${string.replace('1920', '1920')} 1920w`
  }
}

export default helpers
