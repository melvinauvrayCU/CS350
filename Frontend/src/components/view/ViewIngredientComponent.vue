<script lang="ts">
import { Ingredient } from "@/model/recipeModel";
import { Conversion, Unit } from "@/model/PantryModels";

export default {
    name: "ViewIngredient",
    props: {
        ingredient: {
            type: Ingredient,
            required: true
        },
        conversion: {
            type: Conversion,
            required: true
        },
        units: {
            type: Array<Unit>,
            required: true
        },
        feeding: {
            type: Number,
            required: true
        }
    },
    data(): {
        search: string;
        unitTo: string;
        people: number;

        quantity: number;
        unit: string;
    } {
        return {
            people: 1,
            search: "",
            unitTo: "",

            quantity: 0,
            unit: ""
        };
    },
    methods: {
        checkUnit(unit: Unit) {
            return (unit.name == this.ingredient.unit);
        },
        getUnit(unit: Unit) {
            return (unit.name == this.search);
        },
        correctUnit() {
            const ingredientUnit: Array<Unit> = this.units.filter(this.checkUnit); 
            var conversionUnit: string = "";
            if ((this.ingredient.unit !== "")) {
                if (ingredientUnit[0].type === "W" && this.conversion.unitWeight !== "") this.unitTo = conversionUnit = this.conversion.unitWeight;
                else if (ingredientUnit[0].type === "V" && this.conversion.unitVolume !== "") this.unitTo = conversionUnit = this.conversion.unitVolume;
                else conversionUnit = this.ingredient.unit;
            }
            this.unit = conversionUnit;
        },
        changeQuantity() {
            var convertUnitMultiple: number = 1;

            if (this.conversion.people < 1) this.people = this.feeding;
            else {this.people = this.conversion.people; console.log("people set");}

            if (this.unitTo !== "") {
                this.search = this.ingredient.unit;
                const ingredientUnitFrom: Unit = this.units.filter(this.getUnit)[0];
                
                this.search = this.unitTo;
                const ingredientUnitTo: Unit = this.units.filter(this.getUnit)[0];

                convertUnitMultiple = ingredientUnitFrom.convertToSt * ingredientUnitTo.convertFromSt;
            }
            this.quantity = (this.ingredient.quantity * convertUnitMultiple * this.people) / this.feeding;
        }
    },
    created() {
        this.correctUnit();
        console.log("correct unit: " + this.unit);

        this.changeQuantity();
        console.log("correct quantity: " + this.quantity);
    }
};
</script>

<template>
<div class="ViewIngredientComponent">

    <p>●</p>

    <p>{{ ingredient.name }}</p>

    <p>{{ (Math.round(quantity * 100) / 100) }}</p>

    <p>{{ unit }}</p>

</div>
</template>

<style scoped>

.ViewIngredientComponent {
display: flex;
flex-direction: row;
border-radius: 25px;
margin: 10px;
padding: 2px;
}

p {
    padding: 4px;
    font-size: medium;
    font-size: 1.2em;
    font-weight: 500;
    font-family: "common";
}
</style>