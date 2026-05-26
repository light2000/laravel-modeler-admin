import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { createI18n } from 'vue-i18n'

import ElementPlus from 'element-plus'
import '@/styles/index.scss'
import 'element-plus/dist/index.css'
import 'element-plus/theme-chalk/dark/css-vars.css'

import App from '@/App.vue'
import router from '@/router'
import { defaultLocale, messages } from '@/settings/locale'
import can from '@/directive/can'

const app = createApp(App)

const store = createPinia()
store.use(piniaPluginPersistedstate)
app.use(store)
app.use({
    install: function (app) {
        app.directive('can', can)
    }
})
app.use(router)
app.use(ElementPlus)
app.use(
    createI18n({
        legacy: false,
        locale: defaultLocale,
        messages
    })
)

app.mount('#app')
