  
<script lang="ts">

export default {
    name: "ImageInputField",
    props: {
        id: {
            type: String,
            required: true
        },
        labelText: {
            type: String,
            required: true
        },
        modelValue: {
            type: String,
            default: ""
        },
        mandatory: {
            type: Boolean,
            default: false
        },
        recipeTitle: {
            type: String,
            default: ""
        }
    },
    data(): {
        classError: string,
        imageUrl: string,
        imageName: string
    } {
        return {
            classError: "",
            imageUrl: "",
            imageName: "",
        };
    },
    methods: {
        handleFile(file: any) {
            if (!file.type.startsWith("image/")) {
                return;
            }
            this.imageName = file.name;
            this.imageUrl = URL.createObjectURL(file);
            this.$emit("update:modelValue", this.imageUrl);
        },
        handleDrop(event: any) {
            event.preventDefault();
            const file = event.dataTransfer.files[0];
            this.handleFile(file);
        },
        handleClick() {
            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.onchange = (event: any) => {
                this.handleFile(event.target.files[0]);
            };
            input.click();
        },
        handleFileChange(event: any) {
            this.handleFile(event.target.files[0]);
        }
    },
    created() {
        this.imageUrl = this.modelValue;
        this.imageName = this.recipeTitle ? this.recipeTitle : "";
    },
};
</script>
  
<template>
    <div class="ImageInputField" tabindex="0">
        <label :for="id">{{ labelText }}<span v-if="mandatory" style="color: red;"> *</span>
            <Transition>
                <span style="color: red;" v-if="classError !== ''"> - This field is mandatory</span>
            </Transition>
        </label>
        <div class="image-input-field" @dragover.prevent @drop="handleDrop" @click="handleClick"
            :title="!imageUrl ? 'Click to select an image' : 'Click to change image'">
            <input type="file" ref="fileInput" accept="image/*" style="display: none;" @change="handleFileChange" />
            <div v-if="!imageUrl" class="placeholder">
                <p>Drag and drop an image here, or click to select one</p>
            </div>
            <div v-else class="image-parallax" alt="Selected image" :style="{ backgroundImage: 'url(' + imageUrl + ')' }" />
            <p class="imageUrl" v-if="imageUrl">{{ imageName }}</p>
        </div>
    </div>
</template>

<style scoped>
.image-input-field {
    border: 1px solid var(--color-background-light);
    font-size: 1.2em;
    border-radius: 5px;
    font-family: "common";
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    transition: border .4s ease;
    color: var(--color-text-placeholder);
    width: 100%;
    margin-top: 5px;
    cursor: pointer;
    overflow: hidden;
    position: relative;
}

.imageUrl {
    color: var(--color-background);
    position: absolute;
    padding: 15px 45px;
    background-color: #fa8072;
    font-size: 1em;
    border-radius: 40px;
}

.image-parallax {

    /* Create the parallax scrolling effect */
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;


    height: 100%;
    width: 100%;
}

.ImageInputField:hover .image-input-field {
    border-color: var(--color-black);
}


.ImageInputField:focus .image-input-field {
    animation: shadowOnFocusBlack 0.2s ease forwards;
    border-color: var(--color-black);
}

.placeholder {
    text-align: center;
}

.placeholder p {
    margin: 0;
    -webkit-user-select: none;
    /* Safari */
    -ms-user-select: none;
    /* IE 10 and IE 11 */
    user-select: none;
    /* Standard syntax */
}


label {
    font-size: 1.2em;
    color: var(--color-text);
    transition-property: color;
    transition-duration: .4s;
    font-family: "common";
}

.ImageInputField {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin: 20px 0;
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
</style>