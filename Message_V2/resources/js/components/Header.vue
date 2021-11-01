<template>
<div>

  <b-navbar toggleable="lg" type="dark" variant="dark">
     <b-navbar-brand href="#">NavBar</b-navbar-brand>

     <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

     <b-collapse id="nav-collapse" is-nav>

       <ul class="navbar-nav mr-auto">
         <li class="nav-item" v-for="link in links">
           <router-link :to="link.href" class="nav-link">{{ link.title }}</router-link>
             </li>
           </ul>


       <!-- Right aligned nav items -->

         <!--
         <b-nav-form>
           <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
           <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
         </b-nav-form>


         <b-nav-item-dropdown right>

           <template #button-content>
             <em>User</em>
           </template>
           <b-dropdown-item href="#">Profile</b-dropdown-item>
           <b-dropdown-item href="#">Sign Out</b-dropdown-item>
         </b-nav-item-dropdown>
          -->

     </b-collapse>
   </b-navbar>

</div>

<!--
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">

    <router-link :to="'./'" class="navbar-brand">Сообщения</router-link>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item" v-for="link in links">
        <router-link :to="link.href" class="nav-link">{{ link.title }}</router-link>
          </li>
        </ul>
        </div>

        <span class="navbar-text">
  Navbar text with an inline element
</span>
</nav>
-->

</template>

<script>


    export default {

      props: ['myip','myip','myname'],

        data() {
            return {
                links: [
                  {
                      title: "Главная",
                      href: "/"
                  },
                    {
                        title: "Сменить имя",
                        href: "/changename"
                    },
                    {
                        title: "Список поль",
                        href: "/userslist"
                    },
                    {
                        title: "Новый",
                        href: "/chat2"
                    }
                ]
            }
        },
      methods : {

        //alert(this.title);

        }
    }
</script>

<style scoped>
</style>
