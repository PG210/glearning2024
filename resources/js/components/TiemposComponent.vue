<template>
    <div>
        <input type="hidden" name="" id="startinput" v-model="startTime">
        <input type="hidden" name="" id="endinput" v-model="finalTime">
        <input type="hidden" name="" id="diferencia" v-model="diff">     

        <div style="text-align:center;">            
            <h1 id="time" style="color:#7b0404">{{ formattedTime }}</h1>
            <h4>TIENES: {{ tiempoasignado }} Minutos para completar el Reto</h4>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: {
        tiempoasignado: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            finalTime: null,
            startTime: null,
            diff: '',
            remainingTime: null, // Para almacenar el tiempo restante
        };
    },
    computed: {
        formattedTime() {
            const minutes = Math.floor(this.remainingTime / 60);
            const seconds = this.remainingTime % 60;
            return `${minutes < 10 ? "0" : ""}${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
        }
    },
    mounted() {
        this.startTime = moment().format('YYYY-MM-DD HH:mm:ss');
        this.remainingTime = this.tiempoasignado * 60; // Convertir minutos a segundos

        // Inicia los intervalos para actualizar el tiempo restante
        this.timerInterval = setInterval(this.updateTimer, 1000);
    },
    beforeDestroy() {
        // Limpia el intervalo para evitar fugas de memoria
        clearInterval(this.timerInterval);
    },
    methods: {
        updateTimer() {
            if (this.remainingTime > 0) {
                this.remainingTime -= 1;
            } else {
                this.handleGameOver();
            }

            this.finalTime = moment().format('YYYY-MM-DD HH:mm:ss');
            const a = moment(this.startTime);
            const b = moment(this.finalTime);
            this.diff = b.diff(a, 'minutes');
        },
        handleGameOver() {
            clearInterval(this.timerInterval); // Detén el intervalo
            window.location.href = "/gameover";
            console.log("GAME OVER");
        }
    }
};
</script>
