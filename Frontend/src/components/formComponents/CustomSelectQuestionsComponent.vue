<script lang="ts">

export default {
    name: "CustomSelectQuestions",
    props: {
        modelValue: {
            type: Object as () => string[],
            required: true
        },
    },
    data() {
        return {
            isDropdownOpen: false,
            securityQuestions: [
                "What is the first name of your best friend in high school?",
                "What is the name of your first pet?",
                "Where did you go the first time you flew on a plane?",
                "What was your high school mascot?",
                "What was the name of your first boyfriend/girlfriend?",
                "What is your mother's maiden name?",
            ],
            selectedQuestions: [] as string[],
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
            this.selectedQuestions = [];
            this.selectedQuestions.push(item);
            this.$emit('input', this.selectedQuestions);
            this.closeDropdown();
        },
    },
};

</script>

<template>
    <div class="CustomSelectField" v-click-outside="closeDropdown">
        <label>Security Questions:</label>
        <button @click="toggleDropdown" :class="'noSelection' + (isDropdownOpen ? ' dropdownOpen' : '')"
        >Click to Select a Security Question...</button>
        <transition name="openTransition">
            <div v-if="isDropdownOpen" class="dropdownContainer">
                <div class="dropdownListItems" >
                        <transition-group name="listItemTransition">
                            <div class="dropdownItem" v-for="item in securityQuestions" :key="item"
                                @click="onSelectItem(item)">
                                {{ item }}
                            </div>
                        </transition-group>
                    </div>
            </div>
        </transition>
        <div class="containerChosenList">
                    <transition-group name="listItemTransition">
                        <div class="chosenItem" v-for="item in selectedQuestions" :key="item">
                            <p @click="onSelectItem(item)">{{ item }}</p>
                            <hr>
                        </div>
                    </transition-group>
                </div>
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
.CustomSelectField {
    margin: 20px 0;
    width: 560px;
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