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
    async login() {
      if (this.username !== "" && this.password !== "") {

        // We do the API call to login the user
        const ifLoggedin = await API.instance.login(this.username, this.password);


        // reset forms
        this.password = "";

        if (ifLoggedin === true) {

          this.$router.push({ name: "home", params: { messageTextParam: "Welcome back!", messageTypeParam: "success" } });

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

        <InputField id="username" inputType="text" labelText="Email:" max-length="200" placeholder="Email"
          v-model="username" :mandatory="true" />

        <InputField id="password" inputType="password" labelText="Password:" max-length="200" placeholder="Password"
          v-model="password" :mandatory="true" />


        <CustomButton titleText="Click to login" text="Login" effect="plain" @click="login" />

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
  margin-top: 30px;
}

.forgot {
  margin: 20px;
  color: var(--color-text);
  display: flex;
  justify-content: space-between;
  text-align: left;
  width: 100%;
}

.create {
  margin: 30px 0 0 0;
  color: var(--color-text);
  display: flex;
  justify-content: space-between;
  text-align: left;
  width: 100%;
  font-family: "common";
}

.create a {
  color: var(--color-accent);
  transition: color .4s ease;
}

.create a:hover {
  color: var(--color-accent-light)
}

.create a:active {
  color: var(--color-text)
}
</style>
