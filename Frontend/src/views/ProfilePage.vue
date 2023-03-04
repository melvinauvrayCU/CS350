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
            this.username = API.instance.getUsername();
            console.log(this.password);
            return this.username;



        }

    },
};



</script>



<template>
    <section>
        <div id="test">
            <PageTitle :text=getUsername() />
        </div>
        <h1>asdf</h1>

        <div class="picture">


        </div>




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

h1 {
    text-align: center;
}

#test {
    text-align: center;
}
</style>