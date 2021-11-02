<template>

  <div class="butdown">

<form @submit.prevent="submit" enctype="multipart/form-data">


    <b-input-group>

      <b-input-group-prepend>
        <label>
          <img src="/assets/img/attachment.png" class="filebut"><input type="file" style="display: none;"  name="image" id="file" ref="file" @change="submitFile()">
        </label>
      </b-input-group-prepend>

      <b-form-input class="inputsend" type="text" placeholder="Введите текст" v-model="message" rows="1" ref="message" v-on:keyup.ctrl.enter="submit"  autocomplete="off"></b-form-input>


      <b-input-group-prepend>
        <label>
          <input v-if="this.message" class="sendbut" type="image" src="/assets/img/send.png" border="0" alt="Submit">
        </label>
      </b-input-group-prepend>


    </b-input-group>


<!--
      <div>
          <label class="btn btn-primary">
            <i class="fa fa-image">Фаил</i><input type="file" style="display: none;"  name="image" id="file" ref="file" @change="submitFile()">
          </label>

        <textarea class="form-control" v-model="message" rows="1" ref="message" v-on:keyup.ctrl.enter="submit"></textarea>

          <b-button v-else="loading" type="submit" variant="primary">Send</b-button>

        </div>
    -->
    <!--<input type="file" id="file" ref="file" @change="submitFile()"/>-->
      <input type="hidden" v-model="attachfile">
      <!--<input type="file" id="file" ref="file" @change="submitFile()">-->

      <!-- <button @click="submitFile()">Submit</button> -->



</form>

<ListFile @sendfiles="sendfiles"></ListFile>


<!--{{this.filesend}}-->

</div>
</template>

<script>
  import axios from 'axios';
  import ListFile from '../components/ListFile';
  import Spin from '../components/Spin';

    export default {
      components: {
        ListFile,
        Spin
      },

      props: ['myid','myip','myname'],

    data() {
      return {
        message: '',
        answer: '',
        id: '',
        dismissSecs: 7,
        file: '',
        usertext: null,
        listfile: [],
        filesend: '',
        attachfile: '',
        attachfiletmp: ''
      };
    },
    mounted() {



      //console.log(this.$route.params.id);
        },
   methods : {

     sendfiles(get){
       this.filesend = get
       this.attachfile = ''
       //this.attachfiletmp =''

       for (let key in this.filesend) {
         if(this.filesend.hasOwnProperty(key)){
           console.log(`${key} : ${this.filesend[key]['id']}`)
           if(key == 0) {
             this.attachfile = this.filesend[key]['id'];
           } else {
             this.attachfile = this.attachfile + ',' + this.filesend[key]['id'];
           }
         }
       }
       //if(this.attachfile == '') {
      //   this.attachfile = this.attachfiletmp;
       //} else {
        // this.attachfile = this.attachfile + ',' + this.attachfiletmp;
       //}



     },
     submitFile(){

      this.file = this.$refs.file.files[0];


      //axios.post('/postmessage', { message: this.message, to: this.$route.params.id, ug: this.$route.params.ug })
       let formData = new FormData();
       formData.append( 'file', this.file );
       formData.append( 'fromid', this.myid );
       formData.append( 'attach', this.filesend );
       axios.post( '/postfile',
        formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
          }

        ).then(response => {
            console.log('SUCCESS!!');
            this.usertext = response.data

            this.listfile.push({
              id: response.data.id,
              title: this.file.name
            }),
            this.$root.$emit('AddFileList',response.data.filename,response.data.id)


          })
        .catch(error => console.log(error))



      },

      handleFileUpload(){
        this.file = this.$refs.file.files[0];
      },


      async submit(){

      /// остановили setInterval ждем отправки пост и запускаем опять
      this.$emit('clearTimerChat')

      // пишем новое сообщение пока не загрузился чат
      this.$emit('callNewMessPrint',this.$route.params.id,this.message,this.attachfile)
      //this.$refs.message.newMessPrint()

      /// ставим фокус на инпуте
        this.$refs.message.focus()

        if(this.message == ''){
               alert('пусто')
        } else {


          try {

            axios.post('/postmessage', { message: this.message, to: this.$route.params.id, ug: this.$route.params.ug, attach: this.attachfile })
            .then(response => {
                //this.message = '';

                //this.$root.$emit('ChatInPost');

                // очищаем вложения
                this.filesend = ''
                this.attachfile = ''
                this.$root.$emit('ListFileClean')

                //// запускаем таймер после остановки
                this.$emit('startTimerChat')



              //  .catch(error => console.log(error))
              //  .then(response => {


              //  });
                //console.log(response.data)
            })

          } catch(error) {
             console.log(error)
          }
          this.message = ''
          //this.$root.$refs.Chat.loadChat();


      }
    }
   }

  }
</script>

<style scoped>



.inputsend {
  margin :4px;
  outline-offset: 0;
  border: 0;
}
.inputsend:focus  {
 outline: none !important;
}

.sendbut {
  padding-top:5px;
  padding-right:4px;
}
.sendbut:active {
 opacity: .4;
}

.filebut {
  padding-left:3px;
  padding-top:6px;
}
.filebut:active {
  opacity: .4;
}




.butdown {
    background-color: #ffffff;
    width: 100%;
}

.fileu{
  display: inline-block;
  background-color: indigo;
  color: white;
  padding: 0.5rem;
  font-family: sans-serif;
  border-radius: 0.3rem;
  cursor: pointer;
  margin-top: 1rem;
}

</style>
