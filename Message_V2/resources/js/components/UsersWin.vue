<template>

  <!--
  <div>
    <b-list-group>
      <div v-for="showe in usertext" @click="handleClick">
        <b-list-group-item class="d-flex align-items-center">
          <b-avatar class="mr-3"></b-avatar>
          <span class="mr-auto">
            <router-link v-if="showe.is_group === 1" :to="'/group/' + showe.groups_id" class="active" title='Сообщение всем в группе'><b>{{ showe.name }}</b></router-link>
            <router-link v-else :to="'/user/' + showe.id">
              {{ showe.name }}
          </router-link>
          </span>
          <b-badge v-if="showe.new_mes">{{ showe.new_mes }}</b-badge>
        </b-list-group-item>
      </div>
    </b-list-group>
  </div>
-->

<div v-bind:style="styleObject">

  <div class="list-group">
  <div v-for="showe in usertext" @click="handleClick(showe.id,showe.name,showe.online,showe.last,showe.groups_id)">

      <!-- это для имени пользователя над чатом -->
        <div v-if="showe.id === useridget" v-on="handleClickLoad(showe.id,showe.name,showe.online,showe.last,showe.groups_id)"></div>

      <!-- это для группы над чатом -->

      <div v-if="groupidget === 'group'">
        <div v-if="showe.groups_id === useridget" v-on="handleClickLoad(showe.id,showe.name,showe.online,showe.last,showe.groups_id)"></div>
      </div>

    <router-link v-if="showe.is_group === 1" :to="'/group/' + showe.groups_id" class="list-group-item list-group-item-action active" title='Сообщение всем в группе'>
      <b>{{ showe.name }}</b>
    </router-link>
    <router-link v-else :to="'/user/' + showe.id" class="list-group-item list-group-item-action">

      <b-avatar variant="success" v-if="showe.online === 1"></b-avatar>
      <b-avatar variant="secondary" v-else></b-avatar>
      <!--
      <img v-if="showe.online === 1" src="/assets/img/online.png">
      <img v-else src="/assets/img/offline.png">
    -->
      {{ showe.name }}
      <span v-if="showe.new_mes" class="badge badge-primary badge-pill">{{ showe.new_mes }}</span>


  </router-link>
  </div>
  </div>
  <b-spinner v-if="this.loading" label="Spinning" style="position: absolute;top: 50%;left: 50%;"></b-spinner>
</div>


</template>

<script>
import axios from 'axios';



  export default {

  data() {

    return {
      search: '',
      usertext: null,
      toastCount: 0,
      useridget: parseInt(this.$route.params.id),
      groupidget: this.$route.params.ug,
      loading: true,

      styleObject: {
        opacity: '1.0',
        //'pointer-events' : 'none'
      }
    };
  },
      props: ['myid','myip','myname'],


  mounted() {
    this.loading = true

/// слушаем ответ от чата
    this.$root.$on('hideUsers', () => {
        this.hideUserChatOn()
    })

    this.getusers()

    window.setInterval(() => {
      this.getusers()
    }, 10000)


  },
  methods: {

    getusers(){
      axios
      .get('/getusers?myid='+this.myid)
      .then(response => (
        this.usertext = response.data,
        this.loading = false
      ))
      .catch(error => console.log(error));

    },

    makeToast(name) {
      this.toastCount++
      this.$bvToast.toast(`This is toast number ${this.toastCount}`, {
        title: 'BootstrapVue Toast'+name,
        autoHideDelay: 10000
      })
    },
    hideUserChatOff() {
      this.styleObject.opacity = '0.4',
      this.styleObject.pointerEvents = 'none'
    },
    hideUserChatOn() {
          this.styleObject.opacity = '1.0',
          this.styleObject.pointerEvents = 'visible'
    },
    handleClick (userid,username,useronline,userlast,group) {
      this.$root.$emit('Chat')
      //this.$root.$emit('CleanChat')
      this.$root.$emit('NameUser',userid,username,useronline,userlast,group)
      //this.$root.$emit('ScrollDown')
      this.hideUserChatOff()
      this.useridget = null
    },
    handleClickLoad (userid,username,useronline,userlast,group) {
      this.$root.$emit('NameUser',userid,username,useronline,userlast,group)
    }
  }

}


</script>

<style scoped>

</style>
