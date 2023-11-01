import intlTelInput from 'intl-tel-input'
import "intl-tel-input/build/js/utils"
import 'intl-tel-input/build/css/intlTelInput.css'
import '../../css/imported/filament-phone.css'

export default function phoneInputFormComponent({options, state, inputEl}) {
    return {
        state,

        intlTelInput: null,

        options,

        async init() {
            this.applyGeoIpLookup()

            // Waits for until intlTelInput to be fully loaded
            // Loads the component after a certain time because it
            // causes problems with the elements added to the DOM later. e.g. Repeater
            await this.isLoaded()

            this.intlTelInput = intlTelInput(inputEl, this.options)

            console.info('init')


            if (this.state?.length > 0) {
                this.intlTelInput.setNumber(this.state?.valueOf())
            }

            this.$watch("state", (value) => {
                this.$nextTick(() => {
                    if (this.intlTelInput && value !== this.getInputFormattedValue()) {
                        if (value?.length < 1 || value === 'undefined') {
                            this.intlTelInput.setNumber("")
                        } else {
                            console.info('setNumber', value)
                            this.intlTelInput.setNumber(value);
                        }
                    }
                })
            })


        },

        destroy() {
            console.info('destroy')
            this.intlTelInput.destroy()
            this.intlTelInput = null
        },

        async isLoaded() {
            if (window.intlTelInputUtils) {
                console.info('intlTelInputUtils loaded')
                return true
            } else {
                setTimeout(async () => {
                    console.info('intlTelInputUtils not loaded')
                    await this.isLoaded()
                }, 100)
            }
        },


        focusInput() {
            if (this.options.focusNumberFormat) {
                inputEl.value = this.intlTelInput.getNumber(
                    window.intlTelInputUtils.numberFormat[this.options.focusNumberFormat]
                )
            }
        },

        countryChange() {
            let countryData = this.intlTelInput.getSelectedCountryData()

            if (countryData.iso2) {
                localStorage.setItem('IntlTelInputSelectedCountry', countryData.iso2?.toUpperCase())
                this.updateState()
            }
        },

        getInputFormattedValue() {
            return this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[this.options.inputNumberFormat]
            )
        },

        updateState() {
            inputEl.value = this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[this.options.displayNumberFormat]
            )

            if (this.state !== this.getInputFormattedValue()) {
                this.state = this.getInputFormattedValue()
            }
        },

        applyGeoIpLookup() {
            const country = localStorage.getItem('IntlTelInputSelectedCountry')
            const fallback = country ?? this.options.preferredCountries[0]?.toUpperCase()

            if (!this.options.geoIpLookup) {
                console.info('no geoIpLookup, fallback = ', fallback)
                this.options.initialCountry = this.options.initialCountry === 'auto' ? fallback : this.options.initialCountry.toUpperCase()
                this.options.geoIpLookup = null
            } else {
                if (country) {
                    console.info('country from localStorage', country)
                    this.options.initialCountry = country
                    this.options.geoIpLookup = null
                } else {
                    console.info('country from geoIpLookup')
                    this.options.initialCountry = 'auto' // triggers geoIpLookup callback
                    this.options.geoIpLookup = callback => {
                        fetch('/get-country-code')
                            .then((res) => res.json())
                            .then((data) => {
                                localStorage.setItem('IntlTelInputSelectedCountry', data)
                                callback(data)
                            })
                            .catch((error) => callback(fallback))
                    }
                }
            }
        },
    }
};

