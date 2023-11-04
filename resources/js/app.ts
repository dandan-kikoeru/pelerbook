import { createApp, h } from "vue";
import { Head, Link, createInertiaApp } from "@inertiajs/vue3";
import type { DefineComponent } from "vue";
import Layout from "./Shared/Layout.vue";

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob<DefineComponent>("./Pages/**/*.vue", {
      eager: true,
    });
    let page = pages[`./Pages/${name}.vue`];
    if (page.default.layout === undefined) {
      page.default.layout = Layout;
    }
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("Link", Link)
      .component("Head", Head)
      .mount(el);
  },
  progress: {
    color: "#3b82f6",
  },
});
