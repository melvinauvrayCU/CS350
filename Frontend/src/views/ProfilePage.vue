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

        getUser() {
            var user = API.instance.getUser();

            this.username = user.username;
            this.fname = user.fname;
            this.lname = user.lname;
            this.bio = user.bio;
            this.email = user.email;
        }

    },
};



</script>



<template>
    <section>
        {{ getUser() }}


        <div class="image">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png"
                alt="blank user icon">

        </div>


        <div class="gets">
            <div class="gets">
                
                <PageTitle :text=fname />
                <PageTitle :text=lname />
            </div>

            <div class="gets">
                
                <h3>@{{ username }}</h3>
            </div>

            <div id="email">
                <h3 id="emailname"> Email: </h3>
                <h3>{{ email }}</h3>
            </div>

        </div>

        <div id="button">
            <RouterLink to="/editprofile">
                <CustomButton type="neutral" effect='plain' text="Edit Profile" titleText="Edit Profile" />
            </RouterLink>
        </div>



        <div class="bio">
            <PageTitle text="Bio:" />
            <p> {{ bio }}</p>
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

.gets {
    text-align: center;
}


#button {
    padding-top: 15px;

}

#email {
    margin-top: 10px;
}

#emailname {
    font-weight: bold;
    padding-top: 5%;
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

.bio p {
    font-size: 150%;
}

.gets h1 {
    text-align: center;
    margin: 10px 5px 0 5px;
    display: inline-block;

}
</style>