<script lang="ts">
import { API } from "@/model/apiCalls";

export default{
    name: "CreateSignupPage",

   data(): {
    email: string,
    username: string,
    password: string,
    passerror: string
    signedup: boolean

   }{
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a user has logged in
    return {
      username: "",
      password: "",
      email: "",
      passerror: "",
      signedup: false
    };
  },
  methods: {
    //method to signup as a user
    signup(){
      if(this.username !== "" && this.password !== "" && this.email !== ""){

        //API call to signup a user
        var signedUp = API.instance.signup(this.email, this.username, this.password);

        //reset forms
        this.username = "";
        this.password = "";
        this.email = "";

        if(signedUp === false)
        {
          this.signedup = false;
          this.passerror = "Username or Email already in use";
        }else{
          this.signedup = true;
          this.passerror = "Welcome!"
        }

      }
    }

  },
};
    
    
    
    
    

</script>



<template>
    <div class="CreateSignupPage">
  
      <form @submit.prevent>
        <label for="email">Email</label>
        
        <input type="text" id="email" v-model="email" required>

        <label for="username">Username</label>
        
        <input type="text" id="username" v-model="username" required>
  
        <label for="password">Password</label>
        
        <input type="password" id="password" v-model="password" required>
  
        
        <button @click="signup">Signup</button>

        <p class = "login"> 
          Already have an account?
          <router-link to ="login">Login</router-link>
        </p>
      
        <p v-if="signedup">{{passerror}}</p>
        <p v-if="!signedup"> {{ passerror }}</p>
      </form>
    </div>
  </template>


<style scoped>
    .CreateSignupPage {
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
    .login{
      text-align: center;
      margin-top: 15px;
    }
    </style>
    

