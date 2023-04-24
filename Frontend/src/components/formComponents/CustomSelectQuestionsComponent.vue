<script lang="ts">

export default {
    name: "CustomSelectQuestions",
    props: {
        id: {
            type: String,
            required: true
        },
        modelValue: {
            type: String,
            required: true
        },
        options: {
            type: Array<string>,
            required: true
        },
        mandatory: {
            type: Boolean,
            default: true,
        },
        labelText: {
            type: String,
            required: true
        },
    },
    data(): {
        isDropdownOpen: boolean,
        securityQuestions: Array<string>,
        securityQuestionsOriginal: Array<string>,
        userSelectedQuestions: string,
        selectedQuestionsIds: number[],
        classError: string,
        lengthCounter: number,
        labelCounterError: string,
        inline: boolean,
    } {
        return {
            isDropdownOpen: false,
            securityQuestions: [],
            securityQuestionsOriginal: [],
            userSelectedQuestions: "",
            selectedQuestionsIds: [],
            classError: "",
            lengthCounter: 0,
            labelCounterError: "",
            inline: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        onSelectItem(item: string) {
            // const selectedQuestion = item;

            // // Check if the selected question is already in the userSelectedQuestions array
            // const selectedIndex = this.userSelectedQuestions.indexOf(selectedQuestion);

            // if (selectedIndex !== -1) {
            //     // If the selected question is already selected, remove it from the selectedQuestionsIds and userSelectedQuestions arrays
            //     this.selectedQuestionsIds.splice(selectedIndex, 1);
            //     this.userSelectedQuestions.splice(selectedIndex, 1);

            //     // Add the previously selected question back to the securityQuestions array
            //     this.securityQuestions.push(selectedQuestion);
            // } else {
            //     // If the selected question is not already selected, add it to the selectedQuestionsIds and userSelectedQuestions arrays
            //     this.userSelectedQuestions.push(selectedQuestion);
            // }

            // // Create a copy of the original securityQuestions array
            // const availableQuestions = [...this.securityQuestionsOriginal];

            // // Remove the selected question from the availableQuestions array
            // const index = availableQuestions.findIndex((q) => q[1] === selectedQuestion);
            // availableQuestions.splice(index, 1);

            // // Update the securityQuestions data property with the new array
            // this.securityQuestions = availableQuestions;

            this.userSelectedQuestions = item;

            // Update the modelValue prop and emit an input event
            this.$emit("update:modelValue", this.userSelectedQuestions);
            this.closeDropdown();

            // // Update the selectedQuestions array
            // this.$emit('update:selectedQuestions', this.userSelectedQuestions);

        }
    }
};

</script>

<template>
    <div class="CustomSelectField" v-click-outside="closeDropdown">
        <label :for="id">{{ labelText }}<span v-if="mandatory && !inline" style="color: red;"> *</span>
            <Transition>
                <span style="color: red;" v-if="classError !== '' && !inline"> - This field is mandatory</span>
            </Transition>
        </label>
        <button @click="toggleDropdown"
            :class="(isDropdownOpen ? ' dropdownOpen' : '') + (userSelectedQuestions !== '' ? ' selected' : ' noSelection')">
            {{ userSelectedQuestions !== '' ?
                userSelectedQuestions : 'Click to Select a Security Question...' }}
        </button>
        <transition name="openTransition">
            <div v-if="isDropdownOpen" class="dropdownContainer">
                <div class="dropdownListItems">
                    <transition-group name="listItemTransition">
                        <div :class="'dropdownItem' + (question === userSelectedQuestions ? ' selectedItem' : '')"
                            v-for="question in options" :key="question" @click="onSelectItem(question)">
                            {{ question }}
                        </div>
                    </transition-group>
                </div>
            </div>
        </transition>
    </div>
</template>

<style>
.dropdownContainer .InputFieldComponent #searchInput {
    font-size: 1em !important;
    margin: 0 !important;
    margin: 0px 10px 10px 10px !important;
}

.containerQqt input,
.containerQqt div,
.containerUnit select,
.containerUnit div {
    margin: 0 !important;
    font-size: 1em !important;
}
</style>

<style scoped>
.selected {
    color: var(--color-text)
}

.CustomSelectField {
    margin: 20px 0;
    width: 100%;
}


.containerChosenList {
    padding: 5px 10px 10px 10px;
}

.chosenItem {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 5px 20px;
}

.chosenItem hr {
    border: 0;
    height: 1px;
    background-color: var(--color-background-light);
    flex: 1;
    margin: 0 10px;
}

.dropdownContainer p {
    font-family: "common";
    margin: 5px 20px 15px 20px;
    color: var(--color-text-light);
}

.listItemTransition-move,
.listItemTransition-enter-active,
.listItemTransition-leave-active {
    transition: all 0.4s ease-out;
}

.listItemTransition-enter-from,
.listItemTransition-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.listItemTransition-leave-active {
    position: absolute;
}

/* Scrollbar */
.dropdownListItems::-webkit-scrollbar {
    width: 12px;
    background-color: var(--color-background-extra-light);
}

.dropdownListItems::-webkit-scrollbar-thumb {
    background-color: var(--color-background-light);
    transition-duration: 0.4s;
}

.dropdownListItems::-webkit-scrollbar-thumb:hover {
    background-color: var(--color-accent-light);
}

.dropdownListItems::-webkit-scrollbar-thumb:active {
    background-color: var(--color-accent);
}

/* end of scrollbar */

.dropdownListItems {
    max-height: 225px;
    overflow-y: auto;
    overflow-x: hidden;
}

.dropdownItem {
    width: 100%;
    font-size: 1em;
    padding: 10px 30px;
    cursor: pointer;
    height: 45px;
    display: flex;
    align-items: center;
    /* transition: background-color .4s ease, color .4s ease; */
}

.selectedItem {
    background-color: var(--color-accent-light);
}

.dropdownItem:hover,
.dropdownItem.selected:hover {
    background-color: var(--color-accent);
    color: var(--color-background);
}

.dropdownItem.selected {
    background-color: var(--color-accent-light);
}


.dropdownContainer {
    border: 1px solid var(--color-text);
    width: 100%;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top: 0;
    position: absolute;
    z-index: 4;
    background-color: var(--color-background);
    box-shadow: rgb(0 0 0 / 10%) 2px 5px 6px 0px;
}

.InputFieldComponent {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin: 20px 0;
}

label {
    font-size: 1.2em;
    color: var(--color-text);
    transition-property: color;
    transition-duration: .4s;
}

button {
    display: block;
    margin-top: 5px;
    border: 1px solid var(--color-background-light);
    transition: border-color 0.4s ease, box-shadow 0.4s ease, border-radius 0.4s ease;
    padding: 10px 20px;
    font-size: 1.2em;
    border-radius: 5px;
    font-family: "common";
    color: var(--color-text);

    box-shadow: inset 0 0 0 0px var(--color-accent);
    overflow: hidden;
    cursor: pointer;

    width: 100%;
    text-align: left;
    background-color: var(--color-background);
}

button:hover {
    border-color: var(--color-black);
}


button.noSelection {
    color: var(--color-text-placeholder);
}

button.dropdownOpen {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom: 0;
    border-color: var(--color-black);
}

.chosenItem:hover {
    border-color: var(--color-black);
}
</style>