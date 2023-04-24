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
        fname: string | undefined
        lname: string | undefined
        username: string | undefined
        email: string | undefined
        password: string
        bio: string | undefined
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
        async updateProfile() {
            if (this.fname !== ""
                && this.lname !== ""
                && this.username !== ""
                && this.bio !== ""
                && this.fname && this.lname && this.username && this.bio) {
                const temp = await API.instance.updateProfile(this.fname, this.lname, this.username, this.bio);

                if (temp === true) {
                    this.messageType = "success";
                    this.messageText = "Changes saved";
                    this.$router.push("/profile");
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
            var user = API.instance.getUser();

            this.username = user?.username;
            this.fname = user?.fname;
            this.lname = user?.lname;
            this.bio = user?.bio;


        },


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


        <CustomButton titleText="Done" text="Done" effect="plain" @click="updateProfile" />




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

#change {
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



