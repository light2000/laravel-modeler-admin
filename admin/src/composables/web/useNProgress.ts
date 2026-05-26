// hooks/web/useNProgress.ts
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

NProgress.configure({
    showSpinner: false,
    trickleSpeed: 200
})

export function useNProgress() {
    return {
        start: () => NProgress.start(),
        done: () => NProgress.done()
    }
}
