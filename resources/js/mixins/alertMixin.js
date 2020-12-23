export const alertMixin = {
    data() {
        return {
            defaultOptions: {
                success: {
                    layout: 2,
                    timeout: 3000,
                    theme: 'light',
                    iconColor: 'black',
                    messageColor: 'black',
                    position: 'topRight',
                    transitionIn: 'fadeIn',
                    icon: 'fa fa-check',
                },
                error: {
                    layout: 2,
                    timeout: 3000,
                    theme: 'light',
                    iconColor: 'black',
                    messageColor: 'black',
                    position: 'topRight',
                    transitionIn: 'fadeIn',
                    icon: 'fa fa-exclamation-triangle',
                },
            }
        }
    },

    methods: {
        showToast(title, message, type) {
            if(type === 'success'){
                this.$toast.success(message, title, this["defaultOptions"].success);
            }else{
                this.$toast.error(message, title, this["defaultOptions"].error);
            }
        },
    }
}
