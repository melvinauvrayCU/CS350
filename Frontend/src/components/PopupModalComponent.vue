<script lang = "ts">
import { Recipe } from "@/model/recipeModel";
//import RecipeComponent from "@/components/RecipeComponent.vue"
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";


export default {
    name: "PopupModal",
    components : {
        CustomButton
    },
    props: {
        recipeTest : {
            type: Recipe,
            required: true
        },
    },
    methods: {
        close() {
            this.$emit("close");
        },
        // confirm() {
        //     this.$emit("confirm");
        // },
        // deleteRecipe() {
        //     this.$emit("deleteRecipe");
        // }
    }
};

</script>


<template>
    <div class = "modal-overlay">
        <div class = "modal">
            <div class = "header">
                <h2> Test</h2>
                <p> Are you sure you want to delete </p>
                <div class = "btn-close">
                    <CustomButton type="danger" effect="empty" text="" titleText="Close" @clicked ="close"/>
                </div>
                <!-- <div class = "btn-confirm">
                    <CustomButton type="success" effect="empty" text="" titleText="confirm" @clicked ="confirm"/>

                </div>
                <div class = "btn-delete">
                    <CustomButton type="success" effect="empty" text="" titleText="delete" @clicked ="deleteRecipe"/>

                </div> -->

            </div>

        </div>

    </div>
</template>

<style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
  }
  .modal {
    width: 40%;
    border-radius: 25px;
    background: var(--color-background);
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    padding: 10px;
    position: relative;
    z-index: 3;
  }
.header {
  flex-direction: row;
  justify-content: space-between;
  position: relative;
  background-color: transparent;
  align-items: baseline;
  padding: 5px;
}
  .btn-close {
    position: absolute;
    top: 1px;
    right: 0;
    padding-top: 5px;
    padding-right: 10px;
  }
</style>