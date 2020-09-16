<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Cadastro de enquete</div>

          <div class="card-body">
            <div class="form-group">
              <label for="titulo">Titulo</label>
              <input type="text" v-model="titulo" class="form-control" placeholder aria-describedby="helpId" />
            </div>
            <div class="form-group">
              <label for="opcoes">Opções</label>
              <input type="text" v-model="opcoes" class="form-control" placeholder aria-describedby="helpId" />
            </div>
            <div class="form-group">
              <label for="duracao">Duração</label>
              <input type="text" v-model="duracao" class="form-control" placeholder aria-describedby="helpId" />
            </div>
            <button type="submit" @click.prevent="store" class="btn btn-primary">Gravar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            titulo: '',
            opcoes: '',
            duracao: ''

        }
    },
  mounted() {
    console.log("Component mounted.");
  },
  methods : {
      store(){
          axios.post('poll', {
              titulo: this.titulo,
              opcoes: this.opcoes,
              duracao: this.duracao
          })
          .then(response => console.log(response));
      }
  }
};
</script>
