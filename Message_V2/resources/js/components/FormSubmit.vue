<template>
<div>



<form @submit.prevent="submit" enctype="multipart/form-data">

  <div>
    <b-input-group>

      <b-input-group-prepend>
        <label class="btn btn-primary">
          Фаил<input type="file" style="display: none;"  name="image" id="file" ref="file" @change="submitFile()">
        </label>
      </b-input-group-prepend>

      <b-form-input type="text" v-model="message" rows="1" ref="message" v-on:keyup.ctrl.enter="submit"  autocomplete="off"></b-form-input>

      <b-input-group-prepend>
        <label>
          <spin v-if="loading"></spin>
          <button class="btn btn-primary" v-else="loading" type="submit" variant="outline-primary">Send</button>
        </label>
      </b-input-group-prepend>


    </b-input-group>
  </div>

<button class="btn btn-primary" @click="requestPermission">Send</button>

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



<b-alert
  :show="dismissCountDown"
  dismissible
  variant="danger"
  @dismissed="dismissCountDown=0"
  @dismiss-count-down="countDownChanged">
  Надо ввести сообщение &#128532;
</b-alert>
<hr>
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
        loading: false,
        message: '',
        answer: '',
        id: '',
        dismissSecs: 7,
        dismissCountDown: 0,
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
      this.loading = true;

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
            this.loading = false

          })
        .catch(error => console.log(error))



      },

      handleFileUpload(){
        this.file = this.$refs.file.files[0];
      },

     countDownChanged(dismissCountDown) {
       this.dismissCountDown = dismissCountDown
     },
    /// showAlert() {
      // if(this.message == ''){
    //            this.dismissCountDown = this.dismissSecs
    ///   }
     //},
      async submit(){

        this.$refs.message.focus()

        if(this.message == ''){
               this.dismissCountDown = this.dismissSecs
        } else {

          this.loading = true;

          try {

            axios.post('/postmessage', { message: this.message, to: this.$route.params.id, ug: this.$route.params.ug, attach: this.attachfile })
            .then(response => {
                this.message = '';
                this.loading = false;
                this.$root.$emit('ChatInPost');


                // очищаем вложения

                this.filesend = ''
                this.attachfile = ''


                this.$root.$emit('ListFileClean')

              //  .catch(error => console.log(error))
              //  .then(response => {
                this.dismissCountDown = 0

              //  });
                //console.log(response.data)
            })

          } catch(error) {
             console.log(error)
          }
          //this.$root.$refs.Chat.loadChat();


      }
    },
    requestPermission() {
  return new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
      // Поддержка устаревшей версии с функцией обратного вызова.
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  })
  .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('Permission not granted.');
    }
  });
}
   }

  }
</script>

<style scoped>

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
