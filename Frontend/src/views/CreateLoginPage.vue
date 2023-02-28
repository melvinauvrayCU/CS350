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


<div class ="border">
  <div class="CreateLoginPage">

    <form @submit.prevent>
      <label for="username"></label>

      <input type="text" id="username" placeholder="Username or Email" v-model="username" required>

      <label for="password"></label>

      <input type="password" id="password" placeholder="Password" v-model="password" required>


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
</div>

</template>

<style scoped>
.welcome {
  display: flex;
  justify-content: center;
  /* color: #331832; */
  /* background-color: #694D75; */
  padding: 30px;
  width: 60%;
  margin: 10px auto;
  flex-wrap: nowrap;
}

.CreateLoginPage {
  display: flex;
  justify-content: center;
  border: 1px solid black;
  height: 500px;

}
.border{
  width: 100%xs;
  margin: auto 75px;
}

label {
  color: #1B5299;
}

button {
  /* background-color: var(--color-salmon-test); */
  border-radius: 12px;
  transition-duration: .4s;
  width: 250px;
  height: 50px;
  margin: 0px auto 35px;
  color: var(--color-background);
  font-weight: 600;
  font-size: 15px;
  text-transform: uppercase;
  background-color: var(--color-salmon-test);
  border-radius: 33px;

}
button :hover{
  background-color: var(--color-background);
  color:black;
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);


}

form {
  display: flex;
  flex-direction: column;
  width: 40%;
  background-color: white;
  padding: 30px;
}

form input {
  height: 40px;
  width: 250px;
  margin: 10px auto;
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
