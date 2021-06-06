<template>
  <footer class="footer">
    <div class="footer__content">
      <div class="content__items">
        <div class="items__others-links col-6">
          <p class="d-flex justify-content-around">
            <span>Síguenos</span>
            <a href="https://www.facebook.com/Coanime/"><img :src="asset('images/facebook-white.svg')" class="" alt=""></a>

            <a href="https://twitter.com/coanime/"><img :src="asset('images/twitter-white.svg')" class="" alt=""></a>

            <a href="https://www.instagram.com/coanimenet/"><img :src="asset('images/instagram-white.svg')" class="" alt=""></a>
          </p>
        </div>
        <div class="items__copyright col-12">
          <p>
            &copy; 2007{{ ' - ' }}
            {{ thisYear }}
            Coanime. Todos los derechos reservados
          </p>
          <!-- <p class="footer-links">
            <a href="/page/terminos-de-uso-y-aviso-legal">Términos de uso y Aviso Legal</a>
            | <a href="/page/politica-de-privacidad">Politica de Privacidad</a>
          </p> -->
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { helpers } from '../../../mixins'
export default {
  name: 'CommonFooter',
  mixins: [helpers],
  data: function () {
    return {
      thisYear: new Date().getFullYear()
    }
  }
}
</script>
