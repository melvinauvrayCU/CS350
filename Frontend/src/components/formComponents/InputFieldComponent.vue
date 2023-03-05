<script lang="ts">

export default {
    name: "InputField",
    props: {
        id: {
            type: String,
            required: true
        },
        labelText: {
            type: String,
            required: true
        },
        inputType: {
            type: String as () => "text" | "number" | "textarea" | "time" | "password" | "email" | "select",
            default: "text"
        },
        modelValue: {
            type: [String, Number],
            default: ""
        },
        placeholder: {
            type: String,
            default: ""
        },
        classList: {
            type: String,
            default: ""
        },
        mandatory: {
            type: Boolean,
            default: false
        },
        min: {
            type: String,
            default: ""
        },
        max: {
            type: String,
            default: ""
        },
        initialHeight: {
            type: String,
            default: "80"
        },
        maxLength: {
            type: String,
            default: ""
        },
        options: {
            type: Array<string>,
            default: []
        }
    },
    data(): {
        classError: string,
        lengthCounter: number,
        labelCounterError: string,
    } {
        return {
            classError: "",
            lengthCounter: 0,
            labelCounterError: "",
        };
    },
    methods: {
        onInput(event: any) {
            this.$emit("update:modelValue", event.target.value);

            // Changing color of borders if input is empty and mandatory
            if (event.target.value === "" && this.mandatory) {
                this.classError = "errorBorder";
            } else {
                this.classError = "";
            }

            // Updating the counter if there is a max length
            if (this.maxLength !== "") {
                this.lengthCounter = event.target.value.length;

                if (event.target.value.length > (parseInt(this.maxLength) * 0.95)) {
                    this.labelCounterError = "labelCounterError";
                } else {
                    this.labelCounterError = "";
                }
            }

            if (this.inputType === "textarea") {
                event.target.style.height = "auto";
                event.target.style.height = `${event.target.scrollHeight}px`;
            }


        }
    },
    created() {
        this.lengthCounter = 0;
        if (typeof this.modelValue === "string") {
            this.lengthCounter = this.modelValue.length;
        }
    },
};
</script>
<template>
    <div class="InputFieldComponent">
        <label :for="id">{{ labelText }}<span v-if="mandatory" style="color: red;"> *</span>
            <Transition>
                <span style="color: red;" v-if="classError !== ''"> - This field is mandatory</span>
            </Transition>
        </label>

        <select v-if="inputType == 'select'" :id="id" @input="onInput" :value="modelValue" :class="classList + classError"
        :placeholder="placeholder">
            <option v-for="option in options" :key="option">
            {{ option }}
          </option>
        </select>

        <input v-else-if="inputType !== 'textarea'" :type="inputType" :value="modelValue" @input="onInput"
            :placeholder="placeholder" :class="classList + classError" :min="min" :max="max" :id="id" />


        <textarea v-else :id="id" :value="modelValue" @input="onInput" :class="classList + classError"
            :placeholder="placeholder" :style="{
                minHeight: initialHeight + 'px',
            }" :maxlength="maxLength"></textarea>

        <div>
            <Transition>
                <label :class="'counterLabel ' + labelCounterError" v-show="maxLength !== '' && lengthCounter > 0">{{
                    lengthCounter +
                    " / " + maxLength
                }}</label>
            </Transition>

        </div>
    </div>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
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

label.counterLabel.labelCounterError {
    color: var(--color-danger)
}

label.counterLabel {
    font-size: 1em;
    color: var(--color-text-light);
    margin-top: 2px;
    position: absolute;
}

select,
input,
textarea {
    display: block;
    margin-top: 5px;
    border: 1px solid var(--color-background-light);
    transition: border-color 0.4s ease, box-shadow 0.4s ease;
    padding: 10px 20px;
    font-size: 1.2em;
    border-radius: 5px;
    font-family: "common";
    color: var(--color-text);

    box-shadow: inset 0 0 0 0px var(--color-accent);
    overflow: hidden;
}

textarea {
    resize: none;
}

input.errorBorder,
textarea.errorBorder {
    border-color: var(--color-danger-light);
}

select.errorBorder:focus,
select.errorBorder:hover,
input.errorBorder:hover,
input.errorBorder:focus,
textarea.errorBorder:hover,
textarea.errorBorder:focus {
    border-color: var(--color-danger);
}

select:hover,
select:focus,
input:hover,
input:focus,
textarea:hover,
textarea:focus {
    border-color: var(--color-black);
    outline: 0;
}

select:focus,
input:focus,
textarea:focus {
    animation: shadowOnFocusBlack 0.2s ease forwards;
}

select.errorBorder:focus,
input.errorBorder:focus,
textarea.errorBorder:focus {
    animation: shadowOnFocusRed 0.2s ease forwards;
}


@keyframes shadowOnFocusBlack {
    0% {
        box-shadow: inset 0 0 0 0px var(--color-text);
    }

    50% {
        box-shadow: inset 0 0 0 .2px var(--color-text);
    }

    100% {
        box-shadow: inset 0 0 0 .4px var(--color-text);
    }
}

@keyframes shadowOnFocusRed {
    0% {
        box-shadow: inset 0 0 0 0px var(--color-danger);
    }

    50% {
        box-shadow: inset 0 0 0 .2px var(--color-danger);
    }

    100% {
        box-shadow: inset 0 0 0 .4px var(--color-danger);
    }
}
</style>