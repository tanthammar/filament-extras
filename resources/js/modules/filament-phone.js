import intlTelInput from 'intl-tel-input'
import 'intl-tel-input/build/css/intlTelInput.css'
import '../../css/imported/filament-phone.css'

function phoneInputFormComponent({options, state, inputEl}) {
    return {
        state,
        iti: null,
        options,
        isInitialized: false,

        async initWhenVisible() {
            if (this.isInitialized || !inputEl) return
            this.isInitialized = true

            this.applyGeoIpLookup()

            // Add loadUtils - shared across all instances (cached after first load)
            this.options.loadUtils = () => import('intl-tel-input/utils')

            // dropdownContainer: append to body for nested components
            if (this.options.dropdownContainer === 'body') {
                this.options.dropdownContainer = document.body
            }

            this.iti = intlTelInput(inputEl, this.options)

            // Wait for utils to load (returns same promise for all instances)
            await this.iti.promise

            if (this.state?.length > 0) {
                this.iti.setNumber(this.state)
            }

            this.$watch("state", (value) => {
                this.$nextTick(() => {
                    if (this.iti && value !== this.getInputFormattedValue()) {
                        this.iti.setNumber(value?.length > 0 ? value : "")
                    }
                })
            })
        },

        destroy() {
            if (this.iti) {
                this.iti.destroy()
                this.iti = null
                this.isInitialized = false
            }
        },

        focusInput() {
            if (this.options.focusNumberFormat && this.iti) {
                inputEl.value = this.iti.getNumber(
                    intlTelInput.utils.numberFormat[this.options.focusNumberFormat]
                )
            }
        },

        countryChange() {
            if (!this.iti) return
            let countryData = this.iti.getSelectedCountryData()

            if (countryData.iso2) {
                localStorage.setItem('IntlTelInputSelectedCountry', countryData.iso2?.toUpperCase())
                this.updateState()
            }
        },

        getInputFormattedValue() {
            if (!this.iti) return ''
            return this.iti.getNumber(
                intlTelInput.utils.numberFormat[this.options.inputNumberFormat]
            )
        },

        updateState() {
            if (!this.iti) return
            inputEl.value = this.iti.getNumber(
                intlTelInput.utils.numberFormat[this.options.displayNumberFormat]
            )

            if (this.state !== this.getInputFormattedValue()) {
                this.state = this.getInputFormattedValue()
            }
        },

        applyGeoIpLookup() {
            const country = localStorage.getItem('IntlTelInputSelectedCountry')
            const fallback = country ?? this.options.countryOrder[0]?.toUpperCase()

            if (!this.options.geoIpLookup) {
                this.options.initialCountry = this.options.initialCountry === 'auto' ? fallback : this.options.initialCountry.toUpperCase()
                this.options.geoIpLookup = null
            } else {
                if (country) {
                    this.options.initialCountry = country
                    this.options.geoIpLookup = null
                } else {
                    this.options.initialCountry = 'auto' // triggers geoIpLookup callback
                    this.options.geoIpLookup = callback => {
                        fetch('/get-country-code')
                            .then((res) => res.json())
                            .then((data) => {
                                localStorage.setItem('IntlTelInputSelectedCountry', data)
                                callback(data)
                            })
                            .catch(() => callback(fallback))
                    }
                }
            }
        },
    }
}

// Make available globally for x-load-src (async-alpine)
export default phoneInputFormComponent
