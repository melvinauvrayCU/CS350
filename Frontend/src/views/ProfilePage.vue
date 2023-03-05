<script lang = "ts">
import { API } from "@/model/apiCalls";

import PageTitle from "@/components/PageTitleComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "ProfilePage",
    components: {
        PageTitle,
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
            return this.username;



        },
        getEmail() {
            this.email = API.instance.getEmail();
            return this.email;

        },

        editProfile() {



        },

        getname() {
            const names: string[] = API.instance.getname();
            this.fname = names[0];
            this.lname = names[1];
            return this.fname + " " + this.lname;

        },
        getbio() {
            this.bio = API.instance.getbio();
            return this.bio;
        }

    },
};



</script>



<template>
    <section>


        <div class="image">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png"
                alt="blank user icon">

        </div>

        <div class="gets">
            <div>
                <PageTitle :text=getname() />
            </div>

            <div id="username">
                <h3>@{{ getUsername() }}</h3>
            </div>

            <div>
                <h3> Email: {{ getEmail() }}</h3>
            </div>

        </div>

        <div id="button">
            <RouterLink to="/editprofile">
                <CustomButton type="neutral" effect='plain' text="Edit Profile" titleText="Edit Profile"
                    @click="editProfile" />
            </RouterLink>
        </div>



        <div class="bio">
            <PageTitle text="Bio:" />
            <p> {{ getbio() }}</p>
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

h4 {
    padding-bottom: 20px
}

#username {
    text-align: center;

}


#button {
    padding-top: 15px;

}




.image img {
    border-radius: 50%;
    width: 50%;
    margin: auto;
    display: block;

}

.bio {
    margin: 5%;
    width: 60%;
    text-align: left;
}

p {
    font-size: 150%;
}
</style>