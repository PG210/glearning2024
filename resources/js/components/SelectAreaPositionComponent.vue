<template>
<div>
    <select class="form-control" name="areas_id" id="areas_id" v-model="key" @click="mostrarcargos()">
        <option value="" disabled >-- Área --</option>
        <option :value="1" selected>Evolucion</option>
    </select> 
    <!-- v-for="area in areas" :value="area.id" {{ area.name }}-->
    <select class="form-control" name="position_id" id="position_id">
        <option value="" disabled >-- Cargo --</option>
        <option  :value="2" selected>Evolucion</option>
        <!--v-for="position in positions" :value="position.id" {{ position.name }} -->
    </select>
</div>
</template>

<script>
    export default {
        data(){
            return{
                areas: [],
                positions: [],           
                key: "",
            }
        },
        mounted() {
            axios
            .get('https://glearning.com.co/areasregistro')
            .then(response => (this.areas = response.data))
        },
        methods: { 
            mostrarcargos: function(){
                axios
                .get('https://glearning.com.co/positionsregistro/'+this.key)
                .then(response => (this.positions = response.data))                
            }           
        },

    }
</script>

