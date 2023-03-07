<script lang="ts">
import type { Step } from "@/model/recipeModel";
import type { PropType } from "vue";

export default {
    name: "StepCreate",
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
    components: {
    },
    methods: {
        
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
            Description: {{stepObject.descriptionValue}}
            

            <div class="stepTimes">
                Cooktime: {{ stepObject.cooktimeValue }}
                Preptime: {{ stepObject.preptimeValue }}
            </div>
        </div>
    </div>
</template>

<style scoped>
.StepViewComponent {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    margin-bottom: 30px;
}
.stepTimes{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
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
}
</style>