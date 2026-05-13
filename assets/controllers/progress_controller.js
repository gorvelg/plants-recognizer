import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['container', 'bar']

    interval = null
    progress = 0

    connect() {
        this.hideProgress()

        this.onTurboFrameLoad = this.onTurboFrameLoad.bind(this)
        document.addEventListener('turbo:frame-load', this.onTurboFrameLoad)
    }

    disconnect() {
        document.removeEventListener('turbo:frame-load', this.onTurboFrameLoad)
        this.clearProgress()
    }

    start() {
        if (!this.hasContainerTarget || !this.hasBarTarget) {
            return
        }

        this.clearProgress()
        this.progress = 0

        this.containerTarget.hidden = false
        this.barTarget.style.width = '0%'

        this.interval = setInterval(() => {
            if (this.progress < 90) {
                this.progress += Math.random() * 10

                if (this.progress > 90) {
                    this.progress = 90
                }

                this.barTarget.style.width = `${this.progress}%`
            }
        }, 180)
    }

    onTurboFrameLoad(event) {
        if (event.target.id !== 'plant-recognition') {
            return
        }

        this.finish()
    }

    finish() {
        if (!this.hasContainerTarget || !this.hasBarTarget) {
            return
        }

        this.clearProgress()
        this.progress = 100
        this.barTarget.style.width = '100%'

        setTimeout(() => {
            this.hideProgress()
        }, 300)
    }

    hideProgress() {
        if (!this.hasContainerTarget || !this.hasBarTarget) {
            return
        }

        this.containerTarget.hidden = true
        this.barTarget.style.width = '0%'
        this.progress = 0
    }

    clearProgress() {
        if (this.interval) {
            clearInterval(this.interval)
            this.interval = null
        }
    }
}
