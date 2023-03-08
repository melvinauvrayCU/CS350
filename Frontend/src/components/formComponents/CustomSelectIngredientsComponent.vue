<script lang="ts">
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import type { Ingredient } from "@/model/recipeModel";

export default {
    name: "CustomSelectIngredients",
    props: {
        modelValue: {
            type: Object as () => Ingredient[],
            required: true
        },
        ingredientList: {
            type: Object as () => Ingredient[],
            required: true
        }
    },
    data(): {
        isDropdownOpen: boolean,
        fullItemsList: Ingredient[],
        searchText: string,
    } {
        return {
            isDropdownOpen: false,
            fullItemsList: [],
            searchText: "",
        };
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        filteredList(): Ingredient[] {
            return this.fullItemsList.filter((entry) =>
                entry.name.toLowerCase().includes(this.searchText.toLowerCase())
            );
        },
        onSelectItem(searchItem: Ingredient) {
            let tempModelValue = this.modelValue;
            if (tempModelValue.find(ing => ing.name === searchItem.name)) {
                tempModelValue = tempModelValue.filter(ingr => ingr.name !== searchItem.name);
            } else {
                tempModelValue.push(searchItem)
            }
            this.$emit("update:modelValue", tempModelValue);
            this.closeDropdown();
        },
        enterPressed() {
            if (this.filteredList().length === 0) {
                const newIngredient: Ingredient = { name: this.searchText, quantity: "", unit: "g" };
                let tempModelValue = this.modelValue;
                tempModelValue.push(newIngredient);
                this.fullItemsList.push(newIngredient)
                this.$emit("update:modelValue", tempModelValue);
                this.searchText = "";
                this.closeDropdown();
            }
        }
    },
    created() {
        this.fullItemsList = this.ingredientList;
    },
    components: { InputField }
};
</script>

<template>
    <div class="CustomSelectField" v-click-outside="closeDropdown">
        <label>Ingredients:</label>
        <button @click="toggleDropdown" :class="'noSelection' + (isDropdownOpen ? ' dropdownOpen' : '')">Click to add
            ingredients...</button>
        <transition name="openTransition">
            <div v-if="isDropdownOpen" class="dropdownContainer">
                <InputField id="searchInput" label-text="" placeholder="Type to search for existing ingredients..."
                    v-model="searchText" @keyup.enter="enterPressed" :icon="(filteredList().length === 0) ? 'add' : ''" />
                <div>
                    <div class="dropdownListItems" v-if="filteredList().length !== 0">
                        <transition-group name="listItemTransition">
                            <div class="dropdownItem" v-for="searchItem in filteredList()" :key="searchItem.name"
                                @click="onSelectItem(searchItem)"
                                :class="modelValue.find(ingr => ingr.name === searchItem.name) ? 'selected' : ''">
                                {{ searchItem.name }}
                            </div>
                        </transition-group>
                    </div>
                    <p v-else>No ingredients match your search. Press enter to create a new
                        one.
                    </p>
                </div>

            </div>
        </transition>
        <div class="containerChosenList">
            <div class="chosenItem" v-for="item in modelValue" :key="item.name">
                <p>{{ item.name }}</p>
                <hr>
                <div class="containerQqt">
                    <InputField :id="'qtt' + item.name" labelText="" placeholder="Quantity" inputType="number" min="1"
                        max="50000" :mandatory="true" :inline=true v-model="item.quantity" />

                </div>
                <div class="containerUnit">
                    <InputField :id="'unit' + item.name" labelText="" placeholder="Unit" inputType="select"
                        :options="['kg', 'g', 'mg', 'l', 'ml']" v-model="item.unit" />
                </div>
            </div>
        </div>

    </div>
</template>
<style>
.dropdownContainer .InputFieldComponent #searchInput {
    font-size: 1em !important;
    margin: 0 !important;
    margin: 5px 10px 10px 10px !important;
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
}

.containerQqt {
    width: 130px;
    margin-right: 5px;
}

.containerUnit {
    width: 90px;
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

.dropdownContainer .InputFieldComponent {
    margin: 0;
}

.openTransition-enter-active,
.openTransition-leave-active {
    transition: all 0.4s ease-out;
}

.openTransition-enter-from,
.openTransition-leave-to {
    transform: translateY(-40px);
    opacity: 0;
}

.opacity-enter-active,
.opacity-leave-active {
    transition: all 0.4s ease-out;
}

.opacity-enter-from,
.opacity-leave-to {
    opacity: 0;
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
</style>