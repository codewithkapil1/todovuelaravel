import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes";

import "bootstrap/dist/css/bootstrap.css";
import bootstrap from "bootstrap/dist/js/bootstrap.js";

// Create a Vue app instance and mount the root component
const app = createApp(App);
app.use(bootstrap);
app.use(router);
// Mount the app instance to the DOM element with id 'app'
app.mount("#app");
