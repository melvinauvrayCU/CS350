<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";



export default {
  name: "CreateLoginPage",
  components: {
    MessageComponent
  },

  data(): {
    username: string,
    password: string,
    loggedin: boolean,
    passerror: string,
    messageType: "success" | "warning",
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a user has logged in
    return {
      username: "",
      password: "",
      loggedin: false,
      passerror: "",
      messageType: "success"
    };
  },

  methods: {
    login() {
      if (this.username !== "" && this.password !== "") {

        // We do the API call to login the user
        var ifLoggedin = API.instance.login(this.username, this.password);


        // reset forms
        this.username = "";
        this.password = "";

        if (ifLoggedin === true) {
          this.loggedin = true;
          this.messageType = "success";
          this.passerror = "Welcome back!";
        } else {
          this.loggedin = false;
          this.messageType = "warning";
          this.passerror = "Username or Password incorrect";
        }


        //     setTimeout(() => {
        //     this.loggedin = false;
        // }, 2000);



      }
    }
  },
};



</script>

<template>
  <div class="welcome">
    <h2>Welcome to Recipe Buddy</h2>
  </div>



  <div class="CreateLoginPage">

    <form @submit.prevent>
      <label for="username">Username or email</label>

      <input type="text" id="username" v-model="username" required>

      <label for="password">Password</label>

      <input type="password" id="password" v-model="password" required>


      <button @click="login">Login</button>


      <p class="forgot_password">
        <router-link to="/">Forgot Password?</router-link>
      </p>

      <p class="create_account">
        Don't have an account?
        <router-link to="signup">Sign up</router-link>
      </p>


      <!-- <p v-if="loggedin">{{ passerror }}!</p> -->
      <!-- <p v-if="!loggedin"> {{ passerror }}</p> -->
      <MessageComponent v-if="passerror !== ''" :type="messageType" :message="passerror" />
    </form>
  </div>
</template>

<style scoped>
.welcome {
  display: flex;
  justify-content: center;
  color: #331832;
  background-color: #694D75;
  padding: 30px;
  width: 40%;
  margin: 10px auto;
  flex-wrap: nowrap;
}

.CreateLoginPage {
  display: flex;
  justify-content: center;
  /* background-color: #F1ECCE; */
}

label {
  color: #1B5299;
}

button {
  background-color: #694D75;
  color: #331832;
}

/* input#username  {
  background-color: #F1ECCE 
}

input#password {
  background-color: #F1ECCE;
} */

form {
  display: flex;
  flex-direction: column;
  width: 40%;
  background-color: #9FC2CC;
  padding: 30px;
}

form input {
  margin-bottom: 15px;
}

.create_account {
  text-align: center;
  margin: 10px;
}

.forgot_password {
  text-align: center;
  margin-top: 10px;
}
</style>
