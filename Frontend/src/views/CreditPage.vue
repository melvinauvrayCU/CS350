<script lang="ts">
import { API } from "@/model/apiCalls";
import MessageComponent from "@/components/MessageComponent.vue";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import BackgroundIcons from "@/components/BackgroundIconsComponent.vue";

export default {
    name: "CreateLoginPage",
    components: {
        MessageComponent,
        PageTitle,
        InputField,
        CustomButton,
        BackgroundIcons
    },
};



</script>

<template>
    <section>

        <PageTitle text="Credits" />


        <div class="border">
            <div class="CreateLoginPage">

                <a href="https://www.flaticon.com/free-icons/plus" title="plus icons">Plus icons created by dmitri13 -
                    Flaticon</a>
                <a href="https://www.flaticon.com/free-icons/baking" title="baking icons">Baking icons created by
                    ultimatearm - Flaticon</a>

            </div>
        </div>
        <BackgroundIcons />

    </section>
</template>

<style scoped>
section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 50vh;
    width: 100%;
    flex-direction: column;
}

.CreateLoginPage {
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

.forgot {
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
</style>
