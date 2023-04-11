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
        answerCheck: string,
        passwordCheck: string,
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
            answerCheck: "",
            passwordCheck: "",
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
        const user = await API.instance.findUser(this.username);
        if (user) {
          const securityQuestion = user.securityQuestions.find(q => q.question === this.securityQuestion);
          if (securityQuestion && securityQuestion.answer === this.answerCheck) {
                this.showResetPasswordForm = true;
          } else {
            this.showResetPasswordForm = false;
            this.messageType = "warning";
            this.messageText = "Sorry, that is not the correct answer to the security question. Try again.";
          }
       } else {
          this.showResetPasswordForm = false;
          this.messageType = "warning";
          this.messageText = "User not found.";
        }
      },

      async resetPassword() {
        const passwordsMatch = this.password === this.passwordCheck;
        if (passwordsMatch) {
          const result = await API.instance.resetPassword(this.username, this.password);
          if (result === "success") {
            this.messageType = "success";
            this.messageText = "Your password has been reset."
            await API.instance.login(this.username, this.password);
            setTimeout(() => {
              this.$router.push({ name: 'Login' });
            }, 4000); 
          
          } else {
            this.messageType = "warning";
            this.messageText = "Could not reset password."
          }
        } else {
          this.messageType = "warning";
          this.messageText = "The passwords you entered do not match. Please try again.";
      }
    },
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
                <CustomButtonComponent titleText="Submit User" text="Next" effect="plain" @click="generateSecurityQuestion"/>
              </div>
            </div>

            <div v-if="!showResetPasswordForm">
              <div v-if="showSecurityForm">
                <div class="secuirty-question">
                  <InputFieldComponent id="securityQuestion" inputType="text" :labelText="`${securityQuestion}`" max-length="200" placeholder="Answer"
                    v-model="answerCheck" :mandatory="true" />
                </div>
                <div class="submit-button">
                  <CustomButtonComponent titleText="Submit Answer" text="Submit" effect="plain" @click="checkSecurityQuestion" />
                </div>
              </div>
            </div>
            
            <div v-if="showResetPasswordForm">
              <div class="new-password">
                <InputFieldComponent id="newpassword" inputType="password" labelText="New Password:" max-length="200" placeholder="New Password"
                  v-model="password" :mandatory="true" />
                <InputFieldComponent id="newPasswordCheck" inputType="password" labelText="Re-enter New Password:" max-length="200" placeholder="New Password"
                  v-model="passwordCheck" :mandatory="true" />
              </div>
              <div class="reset-button">
                <CustomButtonComponent titleText="reset password" text="Reset Password" effect="plain" @click="resetPassword" />
              </div>
              
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

.submit-button {

}
</style>