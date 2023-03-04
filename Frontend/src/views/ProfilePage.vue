<script lang = "ts">
import { API } from "@/model/apiCalls";
//import MessageComponent from "@/components/MessageComponent.vue";
import PageTitle from "@/components/PageTitleComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";

export default {
    name: "ProfilePage",
    components: {
        //MessageComponent,
        PageTitle,
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


    } {
        return {
            fname: "",
            lname: "",
            username: "",
            email: "",
            password: "",
            bio: "",

        };
    },

    methods: {

        getUsername() {
            const username = API.instance.getUsername();
            return username;


        }

    },
};



</script>



<template>
    <section>
        <h1>{{ getUsername() }} </h1>






    </section>
</template>