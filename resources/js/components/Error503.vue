<template>
  <div class="error-404">
    <img :src="opps" alt="Nos encontramos en labores de Mantenimiento">
    <h1>503 - En Mantenimiento</h1>
    <div class="container">
      <h3>
        Nos encontramos en labores de Mantenimiento<br>Volvemos en Breve
      </h3>
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
  name: 'Error503',
  data: () => {
    return {
      opps: '/assets/images/working-3.gif'
    }
  }
}
</script>
