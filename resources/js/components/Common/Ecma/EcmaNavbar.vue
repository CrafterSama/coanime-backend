<template>
  <div class="ecma-navigation">
    <div class="container">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a :class="{'nav-link active': section === 'titulos', 'nav-link': section !== 'titulos'}" href="/ecma/titulos">
            Titulos
          </a>
        </li>
        <li class="nav-item">
          <a :class="{'nav-link active': section === 'personas', 'nav-link': section !== 'personas'}" href="/ecma/personas">
            Personas
          </a>
        </li>
        <li class="nav-item">
          <a :class="{'nav-link active': section === 'revistas', 'nav-link': section !== 'revistas'}" href="/ecma/revistas">
            Revistas
          </a>
        </li>
        <li class="nav-item">
          <a :class="{'nav-link active': section === 'empresas', 'nav-link': section !== 'empresas'}" href="/ecma/empresas">
            Empresas
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  /**
   * @param {string} section
   */
  name: 'EcmaNavbar',
  props: {
    section: {
      type: String,
      default: ''
    }
  }
}
</script>
