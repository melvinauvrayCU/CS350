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
        fname: string|undefined
        lname: string|undefined
        username: string|undefined
        email: string|undefined
        password: string
        bio: string|undefined


    } 
    {
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

        async getUser() {
            var user = await API.instance.getUser();

            this.username = user?.username;
            this.fname = user?.fname;
            this.lname = user?.lname;
            this.bio = user?.bio;
            this.email = user?.email;
            
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
        <div class="bio">
            <PageTitle text="Bio:" />
            <p> {{ bio }}</p>
        </div>



        <div class="security_question">
            <PageTitle text="Securty Question 1:" />
            <p> {{ security_question_1 }}</p>
            <PageTitle text="Answer:"/>
            <p>{{ security_answer_1 }}</p>
        </div>
        <div class="security_question">
            <PageTitle text="Security Question 2:" />
            <p> {{ security_question_2 }}</p>
            <PageTitle text="Answer:"/>
            <p>{{ security_answer_2 }}</p>
        </div>
        <div class="security_question">
            <PageTitle text="Security Question 3:" />
            <p> {{ security_question_3 }}</p>
            <PageTitle text="Answer:" />
            <p>{{ security_answer_3 }}</p>
        </div>




        <div id="button">
            <RouterLink to="/editprofile">
                <CustomButton type="neutral" effect='plain' text="Edit Profile" titleText="Edit Profile" />
            </RouterLink>
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