/**
 * @link https://www.freecodecamp.org/news/migrate-from-vue2-to-vue3-with-example-project/
 */

//var path = require("path");


import { createApp } from 'vue';

//import Videojs                              from '../../../../Modules/Theme/resources/js/components/videoplayer/Videojs.vue';
//import ExampleComponent                     from '../../../../Modules/Theme/resources/js/components/ExampleComponent';
//import Noui                                 from '../../../../Modules/Theme/resources/js/components/slider/Noui.vue';
import Map from './components/map/Map5.vue';

const app = createApp({
    data() {
        return {
            count: 0
        }
    }
});


//app.component('videoplayer-component', Videojs);
//app.component('v-example', ExampleComponent);
//app.component('v-slider', Noui);
app.component('v-map', Map);

app.mount('#app');
