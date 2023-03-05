<script lang = "ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";

export default {
    name: "EditProfile",
    components: {
        MessageComponent,
        InputField,
        CustomButton,
    },

    data(): {
        fname: string
        lname: string
        username: string
        email: string
        password: string
        bio: string
        messageText: string
        messageType: "success" | "warning",


    } {
        return {
            fname: "",
            lname: "",
            username: "",
            email: "",
            password: "",
            bio: "",
            messageText: "",
            messageType: "success"

        };
    },
    mounted() {
        this.getinput();

    },

    methods: {
        done() {
            if (this.fname !== "" && this.lname !== "" && this.username !== "") {
                const temp = API.instance.done(this.fname, this.lname, this.username, this.bio);

                if (temp === true) {
                    this.messageType = "success";
                    this.messageText = "Changes saved";
                    setTimeout(() => {
                        this.$router.push("/profile");
                    }, 1000);


                } else {
                    this.messageType = "warning";
                    this.messageText = "Username already taken";
                }

            } else {
                this.messageType = "warning";
                this.messageText = "Please fill all the form";
            }



        },

        getinput() {
            this.fname = API.instance.getname()[0];
            this.lname = API.instance.getname()[1];
            this.username = API.instance.getUsername();
            this.bio = API.instance.getbio();
        }

    },
};

</script>

<template>
    <section>


        <div class="image">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png"
                alt="blank user icon">

            <div id="change">
                <CustomButton titleText="Change" text="Change" />
            </div>

        </div>


        <div class="inputField">
            <InputField id="fname" inputType="text" labelText="First Name:" max-length="200" placeholder="First Name"
                v-model="fname" :mandatory="true" />
        </div>

        <div class="inputField">
            <InputField id="lname" inputType="text" labelText="Last Name:" max-length="200" placeholder="Last Name"
                v-model="lname" :mandatory="true" />
        </div>

        <div class="inputField">
            <InputField id="username" inputType="text" labelText="Username:" max-length="200" placeholder="Username"
                v-model="username" :mandatory="true" />
        </div>





        <div class="bio">
            <InputField id="bio" labelText="Bio" placeholder="Tell us about yourself!" v-model="bio" :mandatory="false"
                inputType="textarea" initialHeight="100" maxLength="650" />

        </div>

        <CustomButton titleText="Done" text="Done" effect="plain" @click="done" />




        <MessageComponent :type="messageType" v-model="messageText" />

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

h4 {
    padding-bottom: 20px
}

.inputField {
    width: 50%;
}

.bio {
    width: 50%;
}

#change{
    text-align: center;
    padding-top: 15px;
}

.image img {
    border-radius: 50%;
    width: 30%;
    margin: auto;
    display: block;

}
</style>



