<script>

    function stringToSlug(str) {
        str = str.replace(/^\s+|\s+$/g, ""); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "åàáãäâèéëêìíïîòóöôùúüûñç×·_,:;/";
        var to = "aaaaaaeeeeiiiioooouuuuncx-----";

        for (var i = 0, l = from.length; i < l; i++) {
          str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
        }

        str = str
          .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
          .replace(/\s+/g, "-") // collapse whitespace and replace by -
          .replace(/-+/g, "-"); // collapse dashes

        return str
    }

    function videoItemTemplate(src) {
        return (
            `<iframe id="player" class="embed-responsive-item" src="${src}" allowfullscreen="" frameborder="0"></iframe>`
            /* `<div id="player" data-plyr-provider="youtube" data-plyr-embed-id="${src}"></div>` */
        )
    }

    function relatedTemplate(name, type) {
        if (type === 'movie') {
            type = 'pelicula'
        }
        if (type === 'special') {
            type = 'especial'
        }
        if (type === 'novel') {
            type = 'novela-ligera'
        }
        return (
            `<div class="relateds"><a href="/ecma/titulos/${type}/${stringToSlug(name)}">${name} <span class="text-italic">(${type.replace('-', ' ')})</span></a></div>`
        )
    }
    function songsRelatedsTemplate (element) {
        return (
            `<li class="songs-relateds">${element}</li>`
        )
    }

    async function fillRelateds(type, id) {
        const response = await fetch(`https://api.jikan.moe/v3/${type}/${id}`);
        const data = await response.json();
        const $related = document.querySelector('#title-relateds');
        var html = document.implementation.createHTMLDocument();
        var related = relatedTemplate(data.title.toLocaleLowerCase(), data.type.toLocaleLowerCase());
        html.body.innerHTML = related;
        $related.appendChild(html.body.children[0]);
    }

    function searchMALById(type, id) {
        fetch(`https://api.jikan.moe/v3/${type}/${id}`)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log(data);

                const $related = document.querySelector('#title-relateds');
                const $synopsis = document.querySelector('#title-sinopsis');
                const $titleImage = document.querySelector('.sidebar img');
                const $openings = document.querySelector('#title-openings');
                const $endings = document.querySelector('#title-endings');


                if (data.related != null) {
                    for (var i in data.related) {
                        if (data.related.hasOwnProperty(i)) {
                            data.related[i].forEach(element => {
                                fillRelateds(element.type, element.mal_id);
                            });
                        }
                    }
                }
                else {
                    $related.innerHTML = 'No se encontraron Relacionados';
                    //console.log('No se encontraron Relacionados');
                }

                if ( $synopsis.textContent === '') {
                    $synopsis.textContent = data.synopsis;
                }

                if ( $titleImage.attributes.src.value === "/images/no_image.jpg" ) {
                    fetch(`https://api.jikan.moe/v3/${type}/${id}/pictures`)
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(data) {
                            $titleImage.setAttribute('src', data.pictures[0].large);
                            //console.log(data.pictures);
                        })
                        .catch(function(response) {
                            //console.log(response);
                        })
                }
                if(type != 'manga') {
                    if ( $openings.innerHTML === '' ) {
                        if (data.opening_themes.length > 0) {
                            data.opening_themes.forEach( element => {
                                var html = document.implementation.createHTMLDocument();
                                var related = songsRelatedsTemplate(element);
                                html.body.innerHTML = related;
                                $openings.appendChild(html.body.children[0]);
                            })
                        }
                        else {
                            $openings.innerHTML = 'No hay Openings Registrados';
                        }
                        if (data.ending_themes.length > 0) {
                            data.ending_themes.forEach( element => {
                                var html = document.implementation.createHTMLDocument();
                                var related = songsRelatedsTemplate(element);
                                html.body.innerHTML = related;
                                $endings.appendChild(html.body.children[0]);
                            })
                        }
                        else {
                            $endings.innerHTML = 'No hay Endings Registrados';
                        }
                    }
                }
                
                const $trailer = document.querySelector('#title-trailer');
                
                if($trailer !== undefined) {
                    if (data.trailer_url) {
                        var trailerId = data.trailer_url.replace('?enablejsapi=1&wmode=opaque&autoplay=1','?showinfo=0&enablejsapi=1&origin=https://coanime.net');
                        //console.log(trailerId);
                        const trailer = videoItemTemplate(trailerId);
                        $trailer.innerHTML = trailer;
                    }
                    else {
                        $trailer.innerHTML = 'No se Encontro Trailer Relacionado';
                    }
                }
            })
            .catch(function(response) {
                //console.log(response);
            })
    }

    function searchMAL(type) {
        var title = document.querySelector('#title-name').textContent.toLocaleLowerCase();
        fetch(`https://api.jikan.moe/v3/search/${type}?q=${title}&page=1`)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                var { results: results } = data;
                console.log(results);
                searchMALById(type, results[0].mal_id);
            })
            .catch(function(response) {
                console.log(response);
            })
    }

    var type = stringToSlug(document.querySelector('#title-type').textContent.toLocaleLowerCase());

    if (type === 'tv' || type === 'pelicula' || type === 'ona' || type === 'ova' || type === 'especial') {
        type = 'anime';
    }
    else if (type === 'manhua' || type === 'manhwa' || type === 'novela ligera') {
        type = 'manga';
    }

    if ( type === 'anime' || type === 'manga') {
        searchMAL(type);
    }
</script>