<template>
<div>

  <div class="row">
    <div class="col border">
    <!--  <spin v-if="loadingchat" class="loading"></spin>-->
    </div>
        <div class="col-md-8 upname bg-white border">


        <!--  {{ this.userid }} -->
      <div v-if="this.$route.params.id">
        <div v-if="this.group">
          <p class="font-weight-bold">
            <b-avatar variant="primary" text="Гр" class="my-1"></b-avatar>
            {{ this.username }} (группа)
          </p>
        </div>
        <div v-else>
          <p class="font-weight-bold">
            <b-avatar variant="success" v-if="this.useronline === 1" class="my-1"></b-avatar>
            <b-avatar variant="secondary" class="my-1" v-else></b-avatar>
                     {{ this.username }}  {{ this.userlast }} {{ this.group }}
          </p>
        </div>
      </div>

        </div>

        <div class="w-100"></div>


    <div class="col  border">
      	<div class="userwin"><UsersWin v-bind:myid="this.myid"  v-bind:myip="this.myip" v-bind:myname="this.myname"></UsersWin></div>
    </div>

    <div class="col-md-8 chatwin  border d-sm-none d-md-block" v-if="seen" id="hide">



      <div class="scroll">
        <div v-if="this.showchat">
            <div v-for="showe in usertext" class="currency">
              <div class="container sendmes border" v-if="showe.mymes === 1">
                <div class="row">
                  <div class="col">{{ showe.message }}<br>

                    <div v-if="showe.attach != 0"><b-button  @click="showModalFile(showe.attach)">Вложенные файлы</b-button></div>

                  </div>
                  <div class="w-100"></div>
                  <div class="col text-right">
                    <small> {{ showe.date }} </small>
                    <img v-if="showe.read === 1" src="/assets/img/read1.png" title="Прочитано">
                    <img v-else src="/assets/img/read2.png" title="Не прочитано">
                  </div>
                </div>
              </div>

              <div class="container readmes border" v-else>
                <div class="row">
                  <div class="col">{{ showe.message }}<br></div>
                  <div class="w-100"></div>
                  <div class="col text-right">
                    <small> {{ showe.date }} </small>
                  </div>
                </div>
              </div>

           </div>
             </div>
           <div v-else class="currency">
            <!-- <b-alert show variant="info"> &#128072; &#128587 Надо выбрать из списка контакт</b-alert> -->
            <div v-if="this.$route.params.id">
              <b-spinner label="Spinning" style="position: absolute;top: 50%;left: 50%;"></b-spinner>
            </div>
            <div v-else><br><br><b-alert show variant="info">	&#128072;	 Надо выбрать контакт </b-alert></div>
           </div>
         </div>


<br>

    </div>
</div>

<br>
          <button @click="scrollToDown">scroll to me</button>
    <FormSubmit v-if="this.$route.params.id" v-bind:myid="this.myid"  v-bind:myip="this.myip" v-bind:myname="this.myname"></FormSubmit>

    <div id="app" v-on:click="seen = !seen" class="control">
        <p>click app</p>
    </div>

              <WinFiles :idfiles="idfiles"></WinFiles>

</div>

</template>

<script>
import axios from 'axios';
import UsersWin from '../components/UsersWin'
import FormSubmit from '../components/FormSubmit'
import WinFiles from '../components/WinFiles';


  export default {
    components: {
      UsersWin,
      FormSubmit,
      WinFiles
    },
      props: ['myid','myip','myname'],
  data() {

    return {
       seen: true,
      usertext: null,
      id: null,
      dataread: null,
      sf: null,
    //  loadingchat: true,
      username: null,
      useronline: null,
      userid: null,
      userlast: null,
      group: null,
      showchat: false,
      idfiles: ''


      //obj: this.$route.params.id,
      //objold: obj
    };
  },
  methods : {

    showModalFile(idfiles) {
      this.$root.$emit('bv::show::modal', 'modal-1', '#btnShow', idfiles)
      this.idfiles = idfiles
    },

    scrollToDown() {

      const el = this.$el.getElementsByClassName('scroll')[0];
      if (el) {
        el.scrollIntoView({behavior: "smooth", block: "end"});
      //el.scrollIntoView(false);
      }
    },
    oldChat(res){

      if(this.sf != res) {
        /// если id поменялся
        this.scrollToDown()
        alert(this.sf +' '+ res)
      }

      this.sf = res

    },
    loadChat(getparam){

      if(typeof(this.$route.params.id) !== 'undefined' ) {

      //alert('/getmessage?ug' + this.$route.params.ug + '&to=' + this.$route.params.id);
        axios
          .get('/getmessage?ug' + this.$route.params.ug + '&to=' + this.$route.params.id)
          .then(response => (
            this.usertext = response.data
            //this.oldChat(response.data[0].id)
          ))
          .catch(error => console.log(error))
          //.finally(() => (
          .then(response => (
          //  if(response.data.status){
                this.showchat = true,
                this.$root.$emit('hideUsers')
          //  }
        ));
      }

      if(getparam == true) {
        window.setTimeout(() => {
                this.scrollToDown()
        }, 1000)
      //  alert(getparam)
      }
    }
  },
    mounted() {

      //if(typeof(this.$route.params.id) !== 'undefined' ) {
      //  this.loadUserInfo();
      //}


      this.$root.$on('Chat', () => {
          this.loadChat(true)
          //this.loadUserInfo();
          this.usertext = '',
          this.showchat = false
      }),
      this.$root.$on('ChatInPost', () => {
          this.loadChat(true);

        // window.setTimeout(() => {
        //          this.scrollToDown()
        //  }, 1000)
          //this.usertext = '',
          //this.showchat = false
      }),
    //  this.$root.$on('CleanChat', () => {
    //      this.cleanChatLoad();
    //  }),
      this.$root.$on('NameUser', (userid,username,useronline,userlast,group) => {
          this.userid = userid,
          this.username = username,
          this.useronline = useronline,
          this.userlast = userlast
          this.group = group
      }),

      window.setInterval(() => {
              this.loadChat(false);
      }, 10000)

      this.loadChat(true);


    }

  }
</script>

<style scoped>


.chatwin {
overflow-y: scroll;
 height: 450px; /* Высота блока */
position: relative;
text-align:left;
}


.userwin {
  overflow-y: scroll;
 height: 450px; /* Высота блока */

}



.sendmes {
  max-width:450px;
  min-width: 300px;
  background-color: #3490dc;
  border-radius: 5px 5px 0 5px;
  right: 0;
  //display: inline-block;
  margin: 3px;
  padding: 3px;
  color: #ffffff;
  display: block; /* смещает только блоки */
  margin-left: auto;
   font-size: 16px;

}
.readmes {
  max-width: 450px;
  min-width: 300px;
  background-color: #f8f9fa;
  border-radius: 0 5px 5px 5px;
  border-radius: 5px;
  margin: 3px;
  padding: 3px;
  position: relative;
  display: inline-block;
  font-size: 16px;

}
.upname {
   height: 48px; /* Высота блока */
}

</style>
