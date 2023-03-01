<script lang="ts">
export default {
    name: "CustomButton",
    props: {
        text: {
            type: String,
            required: true
        },
        titleText: {
            type: String,
            default: ""
        },
        effect: {
            type: String as () => "empty" | "plain",
            default: "empty"
        },
        type: {
            type: String as () => "neutral" | "success" | "danger",
            default: "neutral"
        },
        icon: {
            type: String as () => "" | "trash" | "add",
            default: "",
        }
    }
};
</script>
<template>
    <div>
        <button @click="$emit('clicked')" :class="effect + ' ' + type + ' ' + icon" :title="titleText">
            {{ text }}
        </button>
    </div>
</template>

<style scoped>
.empty {
    font-size: 1.2em;
    font-family: Arial, Helvetica, sans-serif;
    display: inline-block;
    text-align: center;
    padding: 10px 30px;
    border-radius: 5px;
    position: relative;
    background-color: transparent;
    cursor: pointer;
    z-index: 1;
}

.empty:before {
    -webkit-transition: 0.5s all ease;
    transition: 0.5s all ease;
    position: absolute;
    top: 0;
    left: 50%;
    right: 50%;
    bottom: 0;
    opacity: 0;
    content: "";
    z-index: -1;
}

.empty:hover:before {
    -webkit-transition: 0.5s all ease;
    transition: 0.5s all ease;
    left: 0;
    right: 0;
    opacity: 1;
}


.empty {
    text-decoration: none;
    -webkit-transition: 0.3s all ease;
    transition: 0.3s ease all;
}

/** Color buttons for empty style */
/** Neutral */
.empty.neutral {
    color: var(--color-text);
    border: 2px solid var(--color-text);
}

.empty.neutral::before {
    background-color: var(--color-text);
}

.empty.neutral:hover {
    color: var(--color-background);
}

.empty.neutral:active {
    border-color: var(--color-background);
}

/** success */
.empty.success {
    color: var(--color-text);
    border: 2px solid var(--color-success);
}

.empty.success::before {
    background-color: var(--color-success);
}

.empty.success:hover {
    color: var(--color-text);
}

/** danger */
.empty.danger {
    color: var(--color-text);
    border: 2px solid var(--color-danger);
}

.empty.danger::before {
    background-color: var(--color-danger-light);
}

.empty.danger:hover {
    color: var(--color-danger);
}

/** ----------------- plain style -------------- */
.plain {
    text-align: center;
    display: inline-block;
    position: relative;
    text-decoration: none;
    font-size: 1.2em;
    padding: 10px 45px;
    border-radius: 5px;
    overflow: hidden;
    cursor: pointer;
    outline: none;
}

.plain {
    transition: all 0.2s linear 0s;
}

/** For all icons */
.plain.trash:before,
.plain.add:before {
    font-family: FontAwesome;
    font-weight: 100;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    right: -30px;
    width: 30px;
    height: 100%;
    transition: all 0.2s linear 0s;
    text-align: center;
}

/** For all icons */
.plain.trash:hover,
.plain.add:hover {
    text-indent: -30px;
    padding-right: 45px;
    padding-left: 75px;
}

/** For all icons */
.plain.trash:hover:before,
.plain.add:hover:before {
    right: 0;
    text-indent: 0px;
}

/** Specific to props */
/** Trash icon */
.plain.trash:before {
    content: "\f1f8";
}

/** Add icon */
.plain.add:before {
    content: "\2b";
}

/** Danger colors */
.plain.danger:active {
    border-color: var(--color-danger-light)
}

.plain.danger:before {
    background-color: var(--color-danger-light);
    border: 2px solid var(--color-danger-light);
}

.plain.danger {
    border: 2px solid var(--color-danger);
    background-color: var(--color-danger);
    color: #fff;
}

/** Success colors */
.plain.success:active {
    border-color: var(--color-success-light)
}

.plain.success:before {
    background-color: var(--color-success-light);
    border: 2px solid var(--color-success-light);
}

.plain.success {
    border: 2px solid var(--color-success);
    background-color: var(--color-success);
    color: #fff;
}
</style>