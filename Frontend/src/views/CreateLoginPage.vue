<script lang="ts"> 
import { API } from "@/model/apiCalls";



export default{
    name: "CreateLoginPage",

   data(): {
    username: string,
    password: string,
    loggedin: boolean,
    passerror: string
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a user has logged in
    return {
      username: "",
      password: "",
      loggedin: false,
      passerror: ""
    };
  },

  methods: {
    login(){
        if (this.username !== "" && this.password !== "") {

            // We do the API call to login the user
             var ifLoggedin = API.instance.login(this.username, this.password);

            // reset
            this.username = "";
            this.password = "";
            
           if(ifLoggedin === true){
            this.loggedin = true;
            this.passerror = "";
            }else{
              this.loggedin = false;
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
    <div class="CreateLoginPage">
  
      <form @submit.prevent>
        <label for="username">Username</label>
        
        <input type="text" id="username" v-model="username" required>
  
        <label for="password">Password</label>
        
        <input type="password" id="password" v-model="password" required>
  
        
        <button @click="login">Login</button>
      
        <p v-if="loggedin">Logged In!</p>
        <p v-if="!loggedin"> {{ passerror }}</p>
      </form>
    </div>
  </template>

<style scoped>
.CreateLoginPage {
  display: flex;
  justify-content: center;
  /* background-color: #F1ECCE; */
}
label{
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
</style>
