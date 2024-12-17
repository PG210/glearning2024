<template>
    <div class="panel panel-default" style="margin-top: 5%; margin-bottom: 5%;">
        <div class="panel-heading">Tipo de Reto</div>
        <div class="panel-body">
            <div class="col-md-5">
                <div class="form-group">
                    <select class="form-control" name="challenge_type_id" v-model="key">
                        <option>Seleccione un Tipo Reto</option>                
                        <option v-for="tiposreto in tiposretos" :value="tiposreto.id" :key="tiposreto.id">{{ tiposreto.name }}</option>        
                    </select>        
                </div>
            </div>

            <!-- QUICCESS -->
            <div v-if="key === 1">
                <div class="col-md-3">
                    <div class="form-group">             
                        <label for="encuestas">Encuestas</label>
                        <select class="form-control" name="encuestaelegida">                        
                            <option value="">Seleccione Encuesta</option>
                            <option v-for="encuesta in encuestas" :value="encuesta.id" :key="encuesta.id">{{ encuesta.name }}</option>                    
                        </select>
                        <a href="/quizzes">Ir a: Crear Quizzes</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"> 
                        <label for="time">Tiempo - Minutos</label>
                        <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                    </div>
                </div>
            </div>

            <!-- AHORCADO -->
            <div v-if="key === 2">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Ahorcado">Palabra para ahorcado</label>
                        <input type="text" class="form-control" name="ahorcado" maxlength="10" v-model="palabra">
                    </div>
                </div>               
                <div class="col-md-3">        
                    <div class="form-group">
                        <label for="dificultad">Dificultad</label>
                        <select class="form-control" name="dificultad">
                            <option value="0">Facil</option>
                            <option value="1">Dificil</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"> 
                        <label for="time">Tiempo - Minutos</label>
                        <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                    </div> 
                </div>
            </div>

            <!-- OTRAS OPCIONES (VER VIDEOS, SUBIR FOTOS, LECTURA, ROMPECABEZAS Y SOPA DE LETRAS) -->
               <!-- VER VIDEOS -->
          <div v-if = "key == 5">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="urlvideo">Subir Video</label>
                    <input type="file" class="form-control" name="video" id="video" accept="video/mp4,video/x-m4v,video/*">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" >
                    <label for="dificultad">Dificultad</label>
                    <select class="form-control" name="dificultad">
                        <option value="0">Facil</option>
                        <option value="1">Dificil</option>
                    </select>
                </div>
            </div>  
            <div class="col-md-3">
                <div class="form-group" > 
                    <label for="time">Tiempo - Minutos</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary"> 
                    <div class="panel-heading"> 
                        <h3 class="panel-title">Recomendacion Videos.</h3> 
                    </div> 
                    <div class="panel-body"> Recuerda: La URL del video debe ser la que entrega el sistema de etiquetas de youtube, copiar la URL del navegador no funcionara.</div> 
                </div>
            </div>
           </div>
        <!-- SUBIR FOTOS -->
          <div v-if="key == 6" >
            <div class="col-md-3">
                <div class="form-group" >
                    <label for="dificultad">Dificultad</label>
                    <select class="form-control" name="dificultad">
                        <option value="0">Facil</option>
                        <option value="1">Dificil</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" > 
                    <label for="time">Tiempo - Minutos</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                </div> 
            </div>
          </div>
          <!-- Repetir para cada tipo de reto, usando `v-if` con la clave `key` -->
        
          <!-- LECTURA -->
         <div v-if="key==7" >
            <div class="col-md-3">
                <div class="form-group">
                    <label for="urlvideo">Subir Video</label>
                    <input type="file" class="form-control" name="video" id="video"  accept="video/mp4,video/x-m4v,video/*">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="material">Recursos</label>
                    <input type="file" class="form-control" name="material" id="material" placeholder="Recursos del Reto">
                </div>
            </div>  
            <div class="col-md-3">
                <div class="form-group" >
                    <label for="dificultad">Dificultad</label>
                    <select class="form-control" name="dificultad">
                        <option value="0">Facil</option>
                        <option value="1">Dificil</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group" > 
                    <label for="time">Tiempo - Minutos</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                </div> 
            </div>
        </div>

        <!-- ROMPECABEZAS Y SALIR A HACER -->
        <div v-if="key==4 || key==8" >
            <div class="col-md-3">
                <div class="form-group">
                    <label for="material">Recursos</label>
                    <input type="file" class="form-control" name="material" id="material" placeholder="Recursos del Reto">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" >
                    <label for="dificultad">Dificultad</label>
                    <select class="form-control" name="dificultad">
                        <option value="0">Facil</option>
                        <option value="1">Dificil</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" > 
                    <label for="time">Tiempo - Minutos</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                </div> 
            </div>
        </div>

        <!--- RETO SCORM -->
          <div v-if="key== 9" >
            <div class="col-md-3">
                <div class="form-group">
                    <label for="material">Archivo scorm en zip</label>
                    <input type="file" class="form-control" name="scormarchivo" id="scormarchivo" placeholder="Recursos del Reto" accept=".zip">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Ahorcado">Código al final del reto</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" maxlength="100" v-model="palabra">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" > 
                    <label for="time">Tiempo - Minutos</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                </div> 
                <!---identificar el tipo de reto-->
                <div class="form-group" > 
                    <input type="hidden" class="form-control" name="idtipo" id="idtipo" value="9">
                </div>
                <!---end-->
            </div>
        </div>
        <!-- SOPA DE LETRAS -->
         <div v-if="key === 3" class="margin">   
                <div class="col-md-12">
                    <p>Palabras Actuales: {{ palabra }}</p>               
                </div>
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">NOTA IMPORTANTE.</h3> 
                            </div> 
                            <div class="panel-body"> Recuerda: No ingresar palabras de más de 10 caracteres en modo fácil y palabras de más de 12 caracteres en modo difícil.</div> 
                        </div>
                    </div> 
                    <a type="submit" class="btn btn-success" @click="addQuestion"> + Palabras </a>
                    <div class="row form-row" v-for="(row, index) in rows" :key="index">
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-4">
                                    <input type="text" name="sopaletras[]" class="form-control" maxlength="10" v-model="row.name">
                                </div>
                                <div class="col-xs-1">
                                    <a class="btn btn-danger" @click="deleteRow(index)"> X </a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dificultad">Dificultad</label>
                        <select class="form-control" name="dificultad">
                            <option value="0">Facil</option>
                            <option value="1">Dificil</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"> 
                        <label for="time">Tiempo - Minutos</label>
                        <input type="number" class="form-control" name="time" id="time" min="1" v-model="tiempo">
                    </div> 
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .form-row {
        border:  1px solid #e2e2e2;
        margin:  10px;
        padding: 20px;
        background: #f2f2f2;
    }
</style>

<script>
import axios from 'axios';

export default {
    props: ['tipodereto', 'palabrasparams', 'urlvideo', 'tiemporeto'],
    
    data() {
        return {
            tiposretos: [],
            encuestas: [],
            rows: [
                { select: 1, name: '' }
            ],
            key: "",
            palabra: "",
            selectedOption: "",
            tiempo: 0,
        }
    },
    
    created() {
        this.key = this.tipodereto;
        this.palabra = this.palabrasparams;
        this.tiempo = this.tiemporeto;
    },
    
    mounted() {
        axios
            .get('/retos')
            .then(response => (this.tiposretos = response.data))
            .catch(error => console.error("Error loading challenge types:", error));
        
        axios
            .get('/quizzesdisponible')
            .then(response => (this.encuestas = response.data))
            .catch(error => console.error("Error loading surveys:", error));
    },
    
    methods: {
        addQuestion() {
            this.rows.push({ select: 1, name: '' });
        },
        
        deleteRow(index) {
            this.rows.splice(index, 1);
        },
    }
}
</script>
