require('./bootstrap');

import { createApp } from 'vue'
import ExampleComponent from "./components/ExampleComponent.vue";

const app = createApp({});

app.component("ExampleComponent", ExampleComponent);

app.mount("#app");

