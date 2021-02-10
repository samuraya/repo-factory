new Vue({
    el: '#contact_form', // id of the 'app'
    data: {
        name: '',   // data for the name on the form
        phone:'',   // data for the phone on the form
        message:'', // data for the message on the form
        maxLength: 140, // maximum length of the form message
        errorMessage: '',// message to show the user if there is an error
        serverErrorMessage :false,
        result: false,
        selected: 'default',
        options: [
            {name:'default', text: 'Mysql По умолчанию'},
            {name:'mysql_two', text: 'Mysql Вторая база данных'},
            {name: 'filesystem', text: 'Файлсистема'}

        ]

    },
    methods: { // all the actions our app can do
        isValidName: function () { // TODO what if name is just spaces?
            var valid = this.name.length > 0;
            console.log('checking for a valid name: ' + valid);
            return valid;
        },
        isValidPhone: function () { // 
            var valid = this.phone == parseInt(this.phone, 10);
            console.log('checking for a valid phone: ' + valid);
            return valid;
        },
        isValidMessage: function () { // what if message is just spaces?
            var valid = (this.message.length > 0) &&
                (this.message.length < this.maxLength);
            console.log('checking for a valid message: ' + valid);
            return valid;
        },
        checkMessage: function () {
            
        },
        submitForm: function () {
            this.resetVariables();
            var that = this;
            if (! this.isValidName()) {
                this.errorMessage = 'Please include your name.';
                return false;
            } else {
                this.errorMessage = '';
            }
            console.log('submitting message...');
            console.log(this.selected)            

            axios.post(scheme+'://'+baseUrl+'/store', {
                name: this.name,
                phone: this.phone,
                message: this.message,
                repo: this.selected
              })
              .then(function (response) {
                that.result = response.data['result'];
                console.log(response);
              })
              .catch(function (error) {
                console.log(error.response);
                console.log(that.serverErrorMessage);
                that.serverErrorMessage = error.response.data;
            });
        },
        resetVariables: function() {
            this.serverErrorMessage = false;
            this.result = false;        
        }
    }
});