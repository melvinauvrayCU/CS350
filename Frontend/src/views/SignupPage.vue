<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButtonComponent from "@/components/formComponents/CustomButtonComponent.vue";
import BackgroundIcons from "@/components/BackgroundIconsComponent.vue";
import CustomSelectQuestionsComponent from "@/components/formComponents/CustomSelectQuestionsComponent.vue";

export default {
  name: "CreateSignupPage",
  components: {
    MessageComponent,
    PageTitle,
    InputField,
    BackgroundIcons,
    CustomSelectQuestionsComponent,
    CustomButtonComponent,
  },
  data(): {
    email: string,
    username: string,
    password: string,
    passwordCheck: string,
    messageText: string,
    securityQuestions: string[],
    messageType: "success" | "warning",
    security_answer_1:string,
    security_answer_2:string,
    security_answer_3:string,
    security_question_1:string,
    security_question_2:string,
    security_question_3:string,
    selectedQuestions:[]|void,

  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a user has logged in
    return {
      username:"",
      password: "",
      passwordCheck: "",
      email: "",
      messageText: "",
      messageType: "success",
      security_answer_1: "",
      security_answer_2: "",
      security_answer_3: "",
      security_question_1: "",
      security_question_2: "",
      security_question_3: "",
      selectedQuestions:[],
      securityQuestions: [
        "What is the first name of your best friend in high school?",
        "What is the name of your first pet?",
        "Where did you go the first time you flew on a plane?",
        "What was your high school mascot?",
        "What was the name of your first boyfriend/girlfriend?",
        "What is your mother's maiden name?",
      ]
    };
  },
  methods: {
    //method to signup as a user
    async signup() {
      if (this.username !== "" && this.password !== "" && this.email !== "" && this.security_answer_1 !== "" && this.security_answer_2 !== "" && this.security_answer_3 !== "" && this.security_question_1 !== "" && this.security_question_2 !== "" && this.security_question_3 !== "") {
          if (this.password === this.passwordCheck) {
              //API call to signup a user
              var signedUp = API.instance.signup(this.email, this.username, this.password, this.security_answer_1, this.security_answer_2, this.security_answer_3, this.security_question_1, this.security_question_2, this.security_question_3);

              //reset forms
              this.username = "";
              this.password = "";
              this.email = "";
              this.security_answer_1="";
              this.security_answer_2="";
              this.security_answer_3="";

              if (await signedUp === false) {
              this.messageText = "Username or Email already in use";
              this.messageType = "warning";
          } else {
              this.$router.push({ name: "home", params: { messageTextParam: "Welcome!", messageTypeParam: "success" } });
            }
        } else {
          this.messageText = "Passwords do not match";
          this.messageType = "warning";
        }
      } else {
        this.messageType = "warning";
        this.messageText = "Please fill all of the form";
      }
    },
    checkPasswords() {
        if (this.password !== '' && this.password !== this.passwordCheck) {
          this.messageText = 'Passwords do not match';
          this.messageType = 'warning';
        } else {
          this.messageText = '';
          this.messageType = 'success';
        }
      },
      async getQuestions(){
      this.selectedQuestions = await API.instance.getSecurityQuestions();
      },
  },
  computed: {
      availableSecurityQuestions() {
        return this.securityQuestions.filter((question) => {
        return !this.selectedQuestions.includes(question);});
      }
  },
  async mounted(){
    await this.getQuestions()
  },
  watch: {
    passwordCheck() {
      this.checkPasswords();
    }, 
  },  
}


</script>



<template>
  <section>
    <PageTitle text="Welcome to RecipeBuddy !" />

    <div class="border">
      <div class="CreateSignupPage">

          <InputField id="email" inputType="email" labelText="Email:" max-length="200" placeholder="Email" v-model="email"
          :mandatory="true" />

          <InputField id="username" inputType="text" labelText="Username:" max-length="200" placeholder="Username"
          v-model="username" :mandatory="true" />

          <InputField id="password" inputType="password" labelText="Password:" max-length="200" placeholder="Password"
          v-model="password" :mandatory="true"/>

          <InputField id="checkPassword" inputType="password" labelText="Re-Enter Password:" max-length="200" placeholder="Password"
          v-model="passwordCheck" :mandatory="true" />

          <CustomSelectQuestionsComponent id="securityQuestion1" labelText="Select Security Question:" :options="availableSecurityQuestions"
            :modelValue="security_question_1" :mandatory="true" :selected-questions="selectedQuestions"/>


          <InputField id="securityAnswer1" inputType="text" labelText="Answer:" max-length="200" placeholder="Answer"
          v-model="security_answer_1" :mandatory="true" />

          <CustomSelectQuestionsComponent id="securityQuestion2" labelText="Select Security Question:" :options="availableSecurityQuestions"
            :modelValue="security_question_2" :mandatory="true" :selected-questions="selectedQuestions" />

          <InputField id="securityAnswer1" inputType="text" labelText="Answer:" max-length="200" placeholder="Answer"
          v-model="security_answer_2" :mandatory="true" />

          <CustomSelectQuestionsComponent id="securityQuestion3" labelText="Select Security Question:" :options="availableSecurityQuestions"
            :modelValue="security_question_3" :mandatory="true" :selected-questions="selectedQuestions" />

          <InputField id="securityAnswer1" inputType="text" labelText="Answer:" max-length="200" placeholder="Answer"
          v-model="security_answer_3" :mandatory="true" />

          <CustomButtonComponent titleText="Submit" text="Submit" effect="plain" @click="signup"/>

        <div class="login">
          <p>
            Already have an account?
            <router-link to="login">Login</router-link>
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

.CreateSignupPage {
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
  margin-top: 15px;
  color: var(--color-text);
  display: flex;
  justify-content: space-between;
}



.button {
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

.button:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
}
</style>