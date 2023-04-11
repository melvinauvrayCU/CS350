<script lang="ts">
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import router from "@/router";

export type timerObject = {
    recipeName: string,
    stepIndex: number,
    time: string,
    cooktime: boolean,
    recipeId: number
}

export default {
    name: "TimerComponent",
    components: {
        CustomButton
    },
    props: {
        modelValue: {
            type: Object as () => timerObject | undefined,
            required: true
        },
    },
    data(): {
        minutes: number,
        seconds: number,
        displaySeconds: string,
        displayMinutes: string,
        timerRef: number,
        blinkingTimerRef: number,
        isTimerRunning: boolean,
        isTimerOver: boolean,
        isBgRed: boolean,
        audio: HTMLAudioElement
    } {
        return {
            minutes: 0,
            seconds: 0,
            displaySeconds: "0",
            displayMinutes: "0",
            timerRef: 0,
            blinkingTimerRef: 0,
            isTimerRunning: false,
            isTimerOver: false,
            isBgRed: false,
            audio: new Audio(),
        }
    },
    methods: {
        hidePopup(event: MouseEvent) {
            event.stopPropagation();
            this.isTimerRunning = false;
            this.isTimerOver = false;
            clearInterval(this.timerRef);
            this.audio.pause();
            this.$emit("update:modelValue", undefined);
        },
        blinkDiv() {
            let count = 0;
            this.isBgRed = true;
            this.blinkingTimerRef = setInterval(() => {
                if (count % 2 === 0) {
                    this.isBgRed = false;
                } else {
                    this.isBgRed = true;
                }
                count++;
                if (count === 8) {
                    clearInterval(this.blinkingTimerRef);
                    this.audio.pause();
                    this.isBgRed = false;
                }
            }, 600);
        },
        timerStop() {
            clearInterval(this.timerRef);
            this.isTimerRunning = false;
            this.isTimerOver = true;
            this.audio.currentTime = 0;
            this.audio.play();
            this.blinkDiv();
        },
        startTimer(time: string): void {
            clearInterval(this.timerRef);
            [this.minutes, this.seconds] = time.split(":").map(Number);
            this.isTimerRunning = true;
            this.timerRef = setInterval(() => {

                if (this.seconds === 0 && this.minutes === 0) {

                    this.timerStop();
                } else if (this.seconds === 0) {
                    this.minutes--;
                    this.seconds = 59;
                } else {
                    this.seconds--;
                }
                this.displaySeconds = this.seconds < 10 ? "0" + this.seconds : this.seconds.toString();
                this.displayMinutes = this.minutes < 10 ? "0" + this.minutes : this.minutes.toString();
            }, 1000);
        },
        toggleTimer(event: MouseEvent) {
            event.stopPropagation();
            if (this.isTimerRunning) {
                clearInterval(this.timerRef);
                this.isTimerRunning = false;
            } else {
                this.isTimerRunning = true;
                this.timerRef = setInterval(() => {
                    if (this.seconds === 0 && this.minutes === 0) {
                        this.timerStop();
                    } else if (this.seconds === 0) {
                        this.minutes--;
                        this.seconds = 59;
                    } else {
                        this.seconds--;
                    }
                    this.displaySeconds = this.seconds < 10 ? "0" + this.seconds : this.seconds.toString();
                    this.displayMinutes = this.minutes < 10 ? "0" + this.minutes : this.minutes.toString();
                }, 1000);
            }
        },
        viewRecipe() {
            if (this.modelValue)
                router.push({ name: "viewRecipe", params: { id: this.modelValue.recipeId } });
        }
    },
    watch: {
        modelValue(newVal: timerObject) {
            if (newVal !== undefined) {
                // updated
                // We reset values
                this.minutes = 0;
                this.seconds = 0;
                this.displaySeconds = "0";
                this.displayMinutes = "0";
                this.isTimerRunning = false;
                this.isTimerOver = false;
                this.isBgRed = false;
                this.audio.pause();
                clearInterval(this.blinkingTimerRef);
                clearInterval(this.timerRef);

                [this.minutes, this.seconds] = newVal.time.split(":").map(Number);
                this.displaySeconds = this.seconds < 10 ? "0" + this.seconds : this.seconds.toString();
                this.displayMinutes = this.minutes < 10 ? "0" + this.minutes : this.minutes.toString();
                this.isTimerRunning = false;
                this.isTimerOver = false;
                this.startTimer(newVal.time);
            }
        }
    },
    created() {
        this.audio = new Audio("http://soundbible.com/mp3/analog-watch-alarm_daniel-simion.mp3");
    }
}
</script>
<template>
    <div v-if="modelValue !== undefined" class="TimerComponent" :class="{ 'redBg': isBgRed }" @click="viewRecipe">
        <h1>{{ modelValue.recipeName }}</h1>
        <h2>Step {{ modelValue.stepIndex }} - {{ modelValue.cooktime ? 'Cook' : 'Preparation' }} time</h2>
        <p :class="{ 'paused': !isTimerRunning, 'over': isTimerOver }">Time remaining: <strong>{{
            `${displayMinutes}:${displaySeconds}`
        }}</strong></p>
        <div class="containerButtons">
            <CustomButton type="neutral" effect="plain" :text="isTimerOver ? 'Close' : 'Stop'"
                :titleText="(isTimerOver ? 'Close' : 'Stop') + ' the timer'" @click="hidePopup" />
            <CustomButton v-if="!isTimerOver" type="neutral" effect="empty" :text="isTimerRunning ? 'Pause' : 'Resume'"
                :titleText="(isTimerRunning ? 'Pause' : 'Resume') + 'the timer'" @click="toggleTimer" />
        </div>
    </div>
</template>
<style>
.containerButtons button {
    width: 100%;
}
</style>
<style scoped>
.containerButtons {
    display: flex;
    flex-direction: row;
    width: 80%;
    margin-top: 20px;
    align-items: center;
    justify-content: center;
}

.containerButtons div {
    flex: 1;
    margin: 0 10px;
}

p {
    transition: color .4s ease;
}

p.paused {
    color: var(--color-danger-light);
}

p.over {
    color: var(--color-danger)
}

.TimerComponent {
    z-index: 999999999;
    position: fixed;
    bottom: 15px;
    right: 15px;
    padding: 30px;
    background-color: var(--color-background);
    border-radius: 5px;
    box-shadow: rgb(0 0 0 / 22%) 0px 2px 8px 0px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 30vw;
    cursor: pointer;
    transition: background-color .8s ease;
}

.redBg {
    background-color: var(--color-danger);
}

.TimerComponent:hover {
    background-color: var(--color-background-extra-light)
}

h1 {
    font-family: "title";
    font-size: 1.5em;
}

h2 {
    font-family: "common";
    font-size: 1.2em;
}

p {
    font-family: "common";
    font-size: 1.2em;
    margin-top: 20px;
}
</style>