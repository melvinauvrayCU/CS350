<script lang="ts">
import type { Step } from "@/model/recipeModel";
import type { PropType } from "vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "StepCreate",
    components: {
        CustomButton
    },
    props: {
        stepObject: {
            type: Object as PropType<Step>,
            required: true
        },
        stepIndex: {
            type: Number,
            required: true
        },
        stepIndexLength: {
            type: Number,
            required: true
        }
    },
    data(): {
        descriptionValue: string
        cooktimeValue: string
        preptimeValue: string
    } {
        return {
            descriptionValue: "",
            cooktimeValue: "",
            preptimeValue: "",
        };
    },
    created() {
        this.descriptionValue = this.stepObject.descriptionValue;
        this.cooktimeValue = this.stepObject.cooktimeValue;
        this.preptimeValue = this.stepObject.preptimeValue;
    }
};
</script>

<template>
    <div class="StepViewComponent">
        <div class="containerTitle">
            <h4>Step {{ stepIndex }}</h4>

        </div>
        <div class="containerContent">
            Description: {{ stepObject.descriptionValue }}


            <div class="stepTimes">
                <div v-if="stepObject.cooktimeValue !== '00:00'"> Cooktime: {{ stepObject.cooktimeValue }}
                </div>
                <div v-if="stepObject.preptimeValue !== '00:00'"> Preptime: {{ stepObject.preptimeValue }}
                </div>
                <div class="containerButtons">
                    <div class="containerButton" v-if="stepObject.cooktimeValue !== '00:00'">
                        <CustomButton type="neutral" effect="plain" icon="timer" text="Start Cooktime"
                            titleText="Start the cooktime timer"
                            @clicked="$emit('startTimer', { 'stepIndex': stepIndex, 'time': stepObject.cooktimeValue, 'cooktime': true })" />
                    </div>
                    <div class="containerButton" v-if="stepObject.preptimeValue !== '00:00'">
                        <CustomButton type="neutral" effect="plain" icon="timer" text="Start Preptime"
                            titleText="Start the preptime timer"
                            @clicked="$emit('startTimer', { 'stepIndex': stepIndex, 'time': stepObject.preptimeValue, 'cooktime': false })" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style>
.containerButton button {
    width: 100%;
    font-size: 0.9em !important;
    padding: 7px 15px !important;
}
</style>

<style scoped>
.containerButton {
    width: 100%;
    flex: 1;
    margin: 5px 15px;
}

.containerButtons {
    display: flex;
    flex-direction: row;
    width: 100%;
}


.StepViewComponent {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    margin-bottom: 30px;
}

.stepTimes {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.containerTitle {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: center;
    align-items: center;
}

.containerTitle h4 {
    font-size: 1.4em;
    font-weight: 600;
    color: var(--color-text);
    font-family: "common";
}

.containerTitle hr {
    border: 0;
    height: 1px;
    background-color: var(--color-background-light);
    flex: 1;
    margin: 0 20px;
}

.containerContent {
    padding: 0 20px;
    width: 53%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
</style>