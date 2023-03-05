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
        <button @click="$emit('clicked')" :class="effect + ' ' + type + ((icon !== '') ? ' icon ' + icon : '')"
            :title="titleText">
            {{ text }}
        </button>
    </div>
</template>

<style scoped>
.empty {
    font-size: 1.2em;
    font-family: "common";
    display: inline-block;
    text-align: center;
    padding: 10px 45px;
    position: relative;
    background-color: var(--color-background);
    cursor: pointer;
    z-index: 1;
    text-decoration: none;
    -webkit-transition: 0.3s all ease;
    transition: 0.3s ease all;
    border-radius: 40px;
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
    border-radius: 40px;
}

.empty:hover:before {
    -webkit-transition: 0.5s all ease;
    transition: 0.5s all ease;
    left: 0;
    right: 0;
    opacity: 1;
}


/** Color buttons for empty style */
/** Neutral */
.empty.neutral {
    color: var(--color-accent);
    border: 2px solid var(--color-accent);
}

.empty.neutral::before {
    background-color: var(--color-accent-light);
}

.empty.neutral:hover {
    color: var(--color-background);
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
    color: var(--color-background);
}

/** danger */
.empty.danger {
    color: var(--color-text);
    border: 2px solid var(--color-danger);
}

.empty.danger::before {
    background-color: var(--color-danger);
}

.empty.danger:hover {
    color: var(--color-background);
}

/** ----------------- plain style -------------- */
.plain {
    text-align: center;
    display: inline-block;
    position: relative;
    text-decoration: none;
    font-size: 1.2em;
    font-family: "common";
    padding: 10px 45px;
    border-radius: 40px;
    overflow: hidden;
    cursor: pointer;
    outline: none;
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

.plain.danger:before {
    background-color: var(--color-danger-light);
    border: 2px solid var(--color-danger-light);
}

.plain.danger {
    border: 2px solid var(--color-danger);
    background-color: var(--color-danger);
    color: #fff;
}

.plain.danger:not(.icon):hover {
    background-color: var(--color-danger-light)
}

/** Success colors */

.plain.success:before {
    background-color: var(--color-success-light);
    border: 2px solid var(--color-success-light);
}

.plain.success {
    border: 2px solid var(--color-success);
    background-color: var(--color-success);
    color: #fff;
}

.plain.success:not(.icon):hover {
    background-color: var(--color-success-light)
}

/** Neutral colors */

.plain.neutral:before {
    background-color: var(--color-accent-light);
    border: 2px solid var(--color-accent-light);
}

.plain.neutral {
    border: 2px solid var(--color-accent);
    background-color: var(--color-accent);
    color: #fff;
}

.plain.neutral:not(.icon):hover {
    background-color: var(--color-accent-light)
}

/** Commons */
button:active {
    border-color: transparent !important;
}
</style>