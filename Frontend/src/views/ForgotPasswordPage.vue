<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import PageTitleComponent from "@/components/PageTitleComponent.vue";
import InputFieldComponent from "@/components/formComponents/InputFieldComponent.vue";
import CustomButtonComponent from "@/components/formComponents/CustomButtonComponent.vue";
import BackgroundIconsComponent from "@/components/BackgroundIconsComponent.vue";

export default {
    name: "ForgotPasswordPage",
    components: {
    MessageComponent,
    PageTitleComponent,
    InputFieldComponent,
    CustomButtonComponent,
    BackgroundIconsComponent
},

    data(): {
        username: string,
        password: string,
        securityQuestion: string,
        securityAnswer: string,
        showSecurityForm: boolean,
        showResetPasswordForm: boolean,
        messageText: string,
        messageType: "success" | "warning",
    } {
        return {
            username: "",
            password: "",
            securityQuestion: "",
            securityAnswer: "",
            showResetPasswordForm: false,
            showSecurityForm: false,
            messageText: "",
            messageType: "success"
        };
    },

    methods: {
      async generateSecurityQuestion() {
        const user = await API.instance.findUser(this.username);
          if (user) {
            const questions = user.securityQuestions.map(q => q.question);
            const randomIndex = Math.floor(Math.random() * questions.length);
            this.securityQuestion = questions[randomIndex];
            this.securityAnswer = user.securityQuestions[randomIndex].answer;
            this.showSecurityForm = true;

          } else {
            this.securityQuestion = "Unable to generate security question.";
          }
      },

      async checkSecurityQuestion() {
        const result = await API.instance.checkQuestion(this.username, this.securityQuestion, this.securityAnswer);
        if (result) {
            this.showResetPasswordForm = true;
        } else {
            this.messageType = "warning";
            this.messageText = "Sorry, that is not the correct answer to the security question.";
        }
      },
        async resetPassword() {
            const result = await API.instance.resetPassword(this.username, this.password);
            if (result === "success") {
                this.messageType = "success";
                this.messageText = "Your password has been reset."
            } else {
                this.messageType = "warning";
                this.messageText = "Could not reset password."
            }
        },
        resetText() {
          this.username = "";
        }
    },
};


</script>

<template>
    <section>
        <PageTitleComponent text="Forgot Password"/>
      <div class="border">
        <div class="ForgotPasswordPage">

            <div v-if="!showSecurityForm">
              <div class="username-input">
                <InputFieldComponent id="username" inputType="text" labelText="Enter Your Username or Email:" max-length="200" placeholder="Username or Email"
                v-model="username" :mandatory="true" />
              </div>
              <div class="next-button">
                <CustomButtonComponent titleText="Submit User" text="Next" effect="plain" @click="generateSecurityQuestion" :resetText="resetText"/>
              </div>
            </div>

            <div v-if="!showResetPasswordForm">
              <div v-if="showSecurityForm">
                <div class="secuirty-question">
                  <InputFieldComponent id="securityQuestion" inputType="text" :labelText="`${securityQuestion}`" max-length="200" placeholder="Answer"
                    v-model="securityAnswer" :mandatory="true" />
                </div>
                <div class="submit-button">
                  <CustomButtonComponent titleText="Submit Answer" text="Submit" effect="plain" @click="checkSecurityQuestion" />
                </div>
              </div>
            </div>
            
            <div v-if="showResetPasswordForm">
                <InputFieldComponent id="new-password" inputType="password" labelText="New Password:" max-length="200" placeholder="New Password"
                    v-model="password" :mandatory="true" />
                <InputFieldComponent id="new-password" inputType="password" labelText="Re-enter New Password:" max-length="200" placeholder="New Password"
                    v-model="password" :mandatory="true" />
                <CustomButtonComponent text="Reset Password" @click="resetPassword" />
            </div>

            
          <div class="login">
            <p>
              <router-link to="login">Login</router-link>
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

.submit-button {

}
</style>