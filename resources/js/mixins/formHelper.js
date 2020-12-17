/**
 * Form helper mixin. This mixin is usefull if you have server-side validation, you can 
 * use this to manipulate error stacks.
 */

export const formHelper = {
    data() {
        return {
            form : {
                errors : []
            },
        }
    },
    methods : {
        /**
         * Check if given field has error entry in the error stack
         *
         * @param field <string> - field name ie. username
         * @param returnMassage <boolean> - whether to return the error message or not
         *
         * @return <mixed>
         */
        hasError(field, returnMessage = false) {
            if (this.form.errors[field]){
                return returnMessage ? this.form.errors[field][0] : true 
            } else {
                return returnMessage ? null : false 
            }
        },

        /**
         * Reset and ropulates the error stack
         *
         * @param errors <array> - array of key value pair errors
         */
        setErrors(errors) {
            if (!Array.isArray(errors)) return 
                
            this.form.errors = []
            this.form.errors = errors
        },

        /**
         * Clear the error stack
         */
        resetErrors() {
            this.form.errors = []
        },

        /**
         * Add new custom error message to the field
         * param field - field name - bases for the call for hasError()
         * message - error message to display
         */
        addError(field, message) {
            this.form.errors[field] = message
        },

        /**
         * Removes errors based on given field name(s)
         * param fields array - the field to be removed
         */
        removeErrors(fields) {
            let errors = []
            for (let x in this.form.errors) {
                if (fields.includes(x)) continue
                errors[x] = this.form.errors[x]
            }
            this.form.errors = errors
        }
    }
}
