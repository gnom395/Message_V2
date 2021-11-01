<template>
<div>

    <div class="chatwin">

      <div class="scroll" ref="cha">

            <div v-for="messdat in chattextin" class="currency">
              <div class="container sendmes" v-if="messdat.mymes === 1">
                <div class="row">
                  <div class="col">{{ messdat.message }}<br>

                    <div v-if="messdat.attach != 0"><b-button  @click="showModalFile(messdat.attach)">Вложенные файлы</b-button></div>

                  </div>
                  <div class="w-100"></div>
                  <div class="col text-right">
                    <small> {{ messdat.date }} </small>
                    <img v-if="messdat.read === 1" src="/assets/img/read1.png" title="Прочитано">
                    <img v-else src="/assets/img/read2.png" title="Не прочитано">
                  </div>
                </div>
              </div>

              <div class="container readmes" v-else>
                <div class="row">
                  <div class="col">{{ messdat.message }}<br></div>
                  <div class="w-100"></div>
                  <div class="col text-right">
                    <small> {{ messdat.date }} </small>
                  </div>
                </div>
              </div>

           </div>


         </div>


<br>


</div>

</div>


</template>

<script>

  export default {

    data() {
      return {
      //chattextin: ''
    }},

      props: ['chattextin'],

  methods : {
    scrollToDown() {
      //alert('ddd')
      const objDiv = this.$refs.cha
      objDiv.scrollTop = objDiv.scrollHeight
    }
  },


  }
</script>

<style scoped>

.scroll {
overflow-y: scroll;
height: 400px;
overflow-x: hidden;
}

.chatwin {

height: 400px; /* Высота блока */
width: 100%;
position: relative;
text-align:left;
height: 100%;
}



.sendmes {
  max-width:300px;
  min-width: 200px;
  background-color: #3490dc;
  color: #ffffff;
  border-radius: 5px 5px 0 5px;
  right: 0;
  //display: inline-block;
  margin: 3px;
  padding: 3px;

  display: block; /* смещает только блоки */
  margin-left: auto;
   font-size: 16px;

}
.readmes {
  max-width: 300px;
  min-width: 200px;
  background-color: #ffffff;
  border-radius: 0 5px 5px 5px;
  border-radius: 5px;
  margin: 3px;
  padding: 3px;
  position: relative;
  display: inline-block;
  font-size: 16px;
}

</style>
