<!-- COMPILARE TEMA CON NPM RUN WATCH COSI' OGNI VOLTA CHE SALVI RICOMPILA IL TEMA DA SOLO -->
<!-- NEL TEMA CHE STAI USANDO (IN QUESTO CASO ITALIA10) IN Resources/js bisogna importare in myvue3.js i file che servono di vue -->
<!-- con la parola chiave "import", e poi bisogna anche aggiungere il componente al progetto con app.component('v-nomeComponente',Componente); -->
<template>
  <section>
    <div>
      <h1>Esempi in Vue</h1>
    </div>
    <div>
      <table>
        <tr>
          <td>
            <!--presa dei dati senza scambio con la pagina -->
            <x-filament-forms::field-wrapper.label
              ><strong
                >Dati passati da vue al campo, SENZA INVIO di dati</strong
              ></label
            >
          </td>
          <td>
            <input :value="test" type="text" />
          </td>
        </tr>
        <tr>
          <td>
            <!-- sincronizzazione diretta di dati tra parti della pagina con v-model -->
            <x-filament-forms::field-wrapper.label
              ><strong
                >Sincronizzazione bi-direzionale dei dati CON v-model.</strong
              ></label
            >
          </td>
          <td>
            <input v-model="test" type="text" data-value="{{test}}" />
          </td>
        </tr>
        <tr>
          <td>
            <x-filament-forms::field-wrapper.label
              ><strong
                >Sincronizzazione di dati con INVIO SENZA v-model e CON
                metodo</strong
              ></label
            >
          </td>
          <td>
            <!-- invio parametri al metodo SENZA v-model -->
            <input :value="test" @keyup.enter="setTest($event)" type="text" />
          </td>
        </tr>
        <tr>
          <td>
            <x-filament-forms::field-wrapper.label
              ><strong
                >Sincronizzazione bi-direzionale CON TASTO INVIO dei dati usando
                v-model e metodo ASSIEME</strong
              ></label
            >
          </td>
          <td>
            <!-- invio parametri al metodo CON v-model -->
            <input
              v-model="test"
              @keyup.enter="addTestAfterEnter()"
              data-value="{{test}}"
            />
          </td>
        </tr>
      </table>
    </div>

    <div>
      <h3>
        <span>Testo normale: </span><span>{{ test }}</span>
      </h3>
    </div>
    <div>
      <h3>
        <span>Testo dopo aver cliccato invio nel quarto input: </span
        ><span>{{ testAfterEnter }}</span>
      </h3>
    </div>
  </section>
</template>

<script>

export default {
  name: "Map3",

  components: {},

  props: {
    test: String,
    testAfterEnter: String,
  },

  data() {
    return {
      test: "1",
      testAfterEnter: "ANCORA NIENTE. MODIFICA CAMPO 4 E CLICCA INVIO",
    };
  },
  computed() {},
  created() {},
  mounted() {},

  methods: {
    addTestAfterEnter: function () {
      this.testAfterEnter = this.test;
    },
    setTest: function (e) {
      //console.log(e.target.value);
      this.test = e.target.value;
    },
  },
};
</script>

<style scoped  lang="scss">
/*@import "~leaflet.extra-markers.min.css";*/
</style>
