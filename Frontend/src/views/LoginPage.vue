<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import BackgroundIcons from "@/components/BackgroundIconsComponent.vue";

export default {
  name: "CreateLoginPage",
  components: {
    MessageComponent,
    PageTitle,
    InputField,
    CustomButton,
    BackgroundIcons
  },

  data(): {
    username: string,
    password: string,
    messageText: string,
    messageType: "success" | "warning",
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a user has logged in
    return {
      username: "",
      password: "",
      messageText: "",
      messageType: "success"
    };
  },

  methods: {
    login() {
      if (this.username !== "" && this.password !== "") {

        // We do the API call to login the user
        const ifLoggedin = API.instance.login(this.username, this.password);


        // reset forms
        this.username = "";
        this.password = "";

        if (ifLoggedin === true) {

          this.messageType = "success";
          this.messageText = "Welcome back!";

          setTimeout(() => {
            this.$router.push("/");
          }, 1000);
        } else {
          this.messageType = "warning";
          this.messageText = "Username or Password incorrect";
        }
      } else {
        this.messageType = "warning";
        this.messageText = "Please fill all the form";
      }
    }
  },
};



</script>

<template>
  <section>

    <PageTitle text="Welcome to RecipeBuddy !" />


    <div class="border">
      <div class="CreateLoginPage">

        <InputField id="username" inputType="text" labelText="Username:" max-length="200" placeholder="Username or Email"
          v-model="username" :mandatory="true" />

        <InputField id="password" inputType="password" labelText="Password:" max-length="200" placeholder="Password"
          v-model="password" :mandatory="true" />


        <CustomButton titleText="Click to login" text="Login" effect="plain" @click="login" />

        <div class="forgot">
          <p>
            <router-link to="/">Forgot Password?</router-link>
          </p>
        </div>

        <div class="create">
          <p>
            Don't have an account?
            <router-link to="signup">Sign up</router-link>
          </p>
        </div>


      </div>
    </div>
    <MessageComponent :type="messageType" v-model="messageText" />
    <BackgroundIcons />

  </section>
</template>

<style scoped>
section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100px;
  width: 100%;
  flex-direction: column;
}

.CreateLoginPage {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding: 30px 60px;
  width: 100%;
}

.border {
  position: relative;
  width: 40%;
  background: transparent;
  border: 2px solid var(--color-accent);
  border-radius: 20px;
  backdrop-filter: blur(15px);
  display: flex;
  justify-content: center;
  align-items: center;
}

/* .inputbox {
  position: relative;
  margin: 30px 0;
  width: 310px;
  border-bottom: 2px solid var(--color-text);

}

.inputbox label {
  position: absolute;
  top: 50%;
  left: 5px;
  transform: translateY(-50%);
  color: var(--color-text);
  font-size: 1em;
  pointer-events: none;
  transition: .5s;
}

.inputbox input {
  width: 100%;
  height: 50px;
  border: none;
  outline: none;
  font-size: 1em;
  padding: 0 35px 0 5px;
  color: black;
} */

.forgot {
  margin: 20px;
  color: var(--color-text);
  display: flex;
  justify-content: space-between;
  text-align: left;
  width: 100%;
}

.create {
  margin: 20px;
  color: var(--color-text);
  display: flex;
  justify-content: space-between;
  text-align: left;
  width: 100%;
}

/* 
button {
  width: 100%;
  height: 40px;
  border-radius: 40px;
  border: none;
  outline: none;
  cursor: pointer;
  font-size: 1em;
  font-weight: 600;
  background-color: var(--color-salmon-test);
  transition-duration: .4s;

}

button:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
} */
</style>
