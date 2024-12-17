import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import PlayerChaptersComponent from './components/PlayerChaptersComponent.vue';
import QuizCreationComponent from './components/QuizCreationComponent.vue';
import QuizUpdateComponent from './components/QuizUpdateComponent.vue';
import QuizChallengeComponent from './components/QuizChallengeComponent.vue';
import TiemposComponent from './components/TiemposComponent.vue';
import SelectRegisterComponent from './components/SelectAreaPositionComponent.vue';
import PopupInsigniasComponent from './components/PopupInsigniasComponent.vue';
import SelectRegisterUpdateComponent from './components/SelectAreaPositionEditComponent.vue';

window.onload = function () {
    const app = createApp({});

    // Registrar los componentes
    app.component('example-component', ExampleComponent);
    app.component('playerchapters-component', PlayerChaptersComponent);
    app.component('quizcreation-component', QuizCreationComponent);
    app.component('quizeupdate-component', QuizUpdateComponent);
    app.component('quizchallenge-component', QuizChallengeComponent);
    app.component('tiempos-component', TiemposComponent);
    app.component('selectregister-component', SelectRegisterComponent);
    app.component('popupinsignias-component', PopupInsigniasComponent);
    app.component('selectregisterupdate-component', SelectRegisterUpdateComponent);

    // Montar la aplicación en el elemento con id "app"
    app.mount('#app');
};
