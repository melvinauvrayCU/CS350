<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import PageTitleComponent from "@/components/PageTitleComponent.vue";
import InputFieldComponent from "@/components/formComponents/InputFieldComponent.vue";
import CustomButtonComponent from "@/components/formComponents/CustomButtonComponent.vue";
import BackgroundIconsComponent from "@/components/BackgroundIconsComponent.vue";
import CustomSelectQuestionsComponent from "@/components/formComponents/CustomSelectQuestionsComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import router from "@/router";

export default {
  name: "ForgotPasswordPage",
  components: {
    MessageComponent,
    PageTitleComponent,
    InputFieldComponent,
    CustomButtonComponent,
    BackgroundIconsComponent,
    CustomSelectQuestionsComponent,
    InputField
  },

  data(): {
    securityQuestions: string[],
    password: string,
    securityAnswer: string,
    securityQuestion: string,
    messageText: string,
    messageType: "success" | "warning",
  } {
    return {
      securityQuestions: [],
      password: "",
      securityAnswer: "",
      securityQuestion: "",
      messageText: "",
      messageType: "success"
    };
  },
  methods: {
    async resetPassword() {
      if (this.password !== ""
        && this.securityAnswer !== ""
        && this.securityQuestion !== "") {
        const result = await API.instance.changePassword(this.password, this.securityQuestion, this.securityAnswer);
        if (result !== "Password updated successfully") {
          this.messageType = "warning";
          this.messageText = result;
        } else {
          router.push({ name: "home", params: { messageTextParam: result, messageTypeParam: "success" } });
        }

      } else {
        this.messageType = "warning";
        this.messageText = "Please fill all the form";
      }

    },
  },
  async created() {
    this.securityQuestions = await API.instance.getSecurityQuestions();
  },
};


</script>

<template>
  <section>
    <PageTitleComponent text="Edit Password" />
    <div class="border">
      <div class="ForgotPasswordPage">

        <CustomSelectQuestionsComponent id="securityQuestion1" labelText="Select Security Question:"
          :options="securityQuestions" v-model="securityQuestion" :mandatory="true" />

        <InputField id="securityAnswer1" inputType="text" labelText="Answer:" max-length="200" placeholder="Answer"
          v-model="securityAnswer" :mandatory="true" />

        <InputField id="password" inputType="password" labelText="New password:" max-length="200"
          placeholder="Enter your new password" v-model="password" :mandatory="true" />



        <CustomButtonComponent titleText="Change" text="Change" effect="plain" @click="resetPassword" />
      </div>
    </div>
    <MessageComponent :type="messageType" v-model="messageText" />
    <BackgroundIconsComponent />

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

.ForgotPasswordPage {
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

.username-input {
  position: relative;
  width: 180%;
  margin-left: -40%;
}

.next-button {
  display: center;
  align-items: center;
  margin-left: 20%;
}

.secuirty-question {
  width: 550px;
  margin-left: 20px;
  margin-right: 20px;
}

.submit-button {
  margin-left: 25%;
}

.new-password {
  margin-left: -30%;
  margin-right: -30%;
}

.reset-button {
  margin-left: 15px;
}

.login {
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

.submit-button {}
</style>