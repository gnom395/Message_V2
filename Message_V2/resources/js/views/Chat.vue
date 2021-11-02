<template>
<div>



<!--
        <div class="upname bg-white border">

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




    <div class="col  border">
      	<div class="userwin"><UsersWin v-bind:myid="this.myid"  v-bind:myip="this.myip" v-bind:myname="this.myname"></UsersWin></div>
    </div>
-->


    <ChatWin :chattextin="chattext" ref="scrollToDownWin"></ChatWin>

    <br>
        <!--  <button @click="scrollToDown">scroll to me</button> -->
    <FormSubmit v-if="this.$route.params.id" :myid="this.myid"  :myip="this.myip" :myname="this.myname"></FormSubmit>


    <WinFiles :idfiles="idfiles"></WinFiles>
</div>


</template>

<script>
import axios from 'axios';
import UsersWin from '../components/UsersWin'
import FormSubmit from '../components/FormSubmit'
import WinFiles from '../components/WinFiles';
import ChatWin from '../components/ChatWin';

  export default {
    components: {
      UsersWin,
      FormSubmit,
      WinFiles,
      ChatWin
    },
      props: ['myid','myip','myname'],
  data() {

    return {
       seen: true,
      chattext: null,
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


    scrollToDown() {
      /// вызываем функцию из дочернего компонента
      this.$refs.scrollToDownWin.scrollToDown()

    //  this.$root.$emit('scrollToDownWin')

    //  const el = this.$el.getElementsByClassName('scroll')[0];
    //  if (el) {
    //    el.scrollIntoView({behavior: "smooth", block: "end"});
      //el.scrollIntoView(false);
    //  }
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
            this.chattext = response.data
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



.userwin {
  overflow-y: scroll;
 //height: 450px; /* Высота блока */
 height: 100%;
 width: 100%;
 padding: 0;
}



</style>
