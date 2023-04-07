
import "../css/intl-tel-input.css"
import "../css/filament-phone.css"
import intlTelInput from "intl-tel-input"

document.addEventListener("alpine:init", () => {
    Alpine.data(
        "phoneInputFormComponent",
        ({options, state}) => {
            return {
                state,

                instance: null,

                options, // intlTelInput options

                cookieUtils: {
                    setCookie(cookieName, cookieValue, expiryDays = null, path = null, domain = null) {
                        let cookieString = `${cookieName}=${cookieValue};`;
                        if (expiryDays) {
                            const expiryDate = new Date();
                            expiryDate.setTime(expiryDate.getTime() + expiryDays * 24 * 60 * 60 * 1000);
                            cookieString += `expires=${expiryDate.toUTCString()};`;
                        }
                        if (path) cookieString += `path=${path};`;
                        if (domain) cookieString += `domain=${domain};`;
                        document.cookie = cookieString;
                    },
                    getCookie(cookieName) {
                        const name = `${cookieName}=`;
                        const cookies = document.cookie.split(';');
                        for (const cookie of cookies) {
                            let c = cookie.trim();
                            if (c?.startsWith(name)) return c.slice(name.length);
                        }
                        return '';
                    },
                    removeCookie(cookieName, path = null, domain = null) {
                        let cookieString = `${cookieName}=;`;
                        const expiryDate = new Date();
                        expiryDate.setTime(expiryDate.getTime() - 30 * 24 * 60 * 60 * 1000);
                        cookieString += `expires=${expiryDate.toUTCString()};`;
                        if (path) cookieString += `path=${path};`;
                        if (domain) cookieString += `domain=${domain};`;
                        document.cookie = cookieString;
                    },
                },

                init() {

                    this.applyGeoIpLookup()

                    this.instance = intlTelInput(this.$el, this.options)

                    if (this.state) {
                        this.instance.setNumber(this.state?.valueOf())
                    }

                    this.listenCountryChange()

                    this.$el.addEventListener("change", this.updateState.bind(this));

                    if(this.options.focusNumberFormat) {
                        this.$el.addEventListener("focus", () => {
                            this.$el.value = this.instance.getNumber(
                                intlTelInputUtils.numberFormat[this.options.focusNumberFormat]
                            )
                        })
                    }

                    this.$watch("state", (value) => {
                        this.$nextTick(() => {
                            if(this.state !== this.getInputFormattedValue()) {
                                this.instance.setNumber(value ?? "")
                            }
                        });
                    });
                },

                listenCountryChange() {
                    this.$el.addEventListener("countrychange", () => {
                        let countryData =
                            this.instance.getSelectedCountryData()

                        if (countryData.iso2) {
                            this.cookieUtils.setCookie(
                                this.IntlTelInputSelectedCountryCookie,
                                countryData.iso2?.toUpperCase()
                            );

                            this.updateState()
                        }
                    });
                },

                getInputFormattedValue() {
                    return this.instance.getNumber(
                        intlTelInputUtils.numberFormat[this.options.inputNumberFormat]
                    )
                },

                updateState() {
                    this.$el.value = this.instance.getNumber(
                        intlTelInputUtils.numberFormat[this.options.displayNumberFormat]
                    )

                    if(this.state !== this.getInputFormattedValue()) {
                        this.state = this.getInputFormattedValue()
                    }
                },

                applyGeoIpLookup() {
                    if(!this.options.geoIPLookup) {
                        this.options.initialCountry = this.options.initialCountry === 'auto' ? this.options.preferredCountries[0]?.toUpperCase() : this.options.initialCountry.toUpperCase()
                        this.options.geoIPLookup = null
                    }
                    this.options.geoIPLookup =
                        function (success, failure) {
                            let country = this.cookieUtils.getCookie(this.IntlTelInputSelectedCountryCookie)
                            if (country) {
                                success(country)
                            } else {
                                fetch("https://ipinfo.io/json")
                                    .then((res) => res.json())
                                    .then((data) => data)
                                    .then((data) => {
                                        let country = data.country?.toUpperCase()
                                        success(country)
                                        this.cookieUtils.setCookie(this.IntlTelInputSelectedCountryCookie, country)
                                    })
                                    .catch((error) => success(this.options.preferredCountries[0]?.toUpperCase()))
                            }

                        }
                }
            };
        }
    );
})
;
