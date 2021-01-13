<template>
  <div class="error-404">
    <img :src="opps" alt="Opps Contenido no Encontrado">
    <h1>404</h1>
    <div class="container">
      <h3>El Contenido que estas buscando no existe o no esta guardado aun en nuestra Base de Datos</h3>
      <hr>
      <p>
        Regresa al
        <a href="/">Inicio</a>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Error404',
  data: () => {
    return {
      opps: '/assets/images/error-404.svg'
    }
  }
}
</script>
