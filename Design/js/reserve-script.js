// Debug information - Check browser console for these messages
console.log('=== DEBUGGING Vue.js Form ===');
console.log('Vue available:', typeof Vue !== 'undefined');
console.log('Form element found:', document.querySelector('#reservation_second_form') !== null);

// Your Vue instance with debugging
new Vue({
    el: "#reservation_second_form", // Make sure this matches your form ID exactly
    data: {
        selected_car: '',
        full_name: '',
        client_email: '',
        client_phonenumber: '',
        formSubmitted: false // Added this for better validation
    },
    mounted: function() {
        console.log('Vue instance mounted successfully');
        console.log('Initial data:', this.$data);
    },
    methods: {
        checkForm: function(event) {
            console.log('=== FORM SUBMISSION ATTEMPT ===');
            console.log('Current form data:', {
                selected_car: this.selected_car,
                full_name: this.full_name,
                client_email: this.client_email,
                client_phonenumber: this.client_phonenumber
            });

            this.formSubmitted = true;
            
            // Check if all required fields are filled
            if (this.full_name && this.client_email && this.client_phonenumber && this.selected_car) {
                console.log('✅ Form validation PASSED - submitting form');
                return true; // Allow form submission
            }
            
            console.log('❌ Form validation FAILED');
            console.log('Missing fields:', {
                full_name: !this.full_name,
                client_email: !this.client_email,
                client_phonenumber: !this.client_phonenumber,
                selected_car: !this.selected_car
            });
            
            // Set null values for validation display
            if (!this.full_name) {
                this.full_name = null;
                console.log('Set full_name to null for validation display');
            }
            if (!this.client_email) {
                this.client_email = null;
                console.log('Set client_email to null for validation display');
            }
            if (!this.client_phonenumber) {
                this.client_phonenumber = null;
                console.log('Set client_phonenumber to null for validation display');
            }
            if (!this.selected_car) {
                this.selected_car = null;
                console.log('Set selected_car to null for validation display');
            }
            
            event.preventDefault(); // Prevent form submission
            console.log('Form submission prevented');
        }
    },
    watch: {
        // Watch for changes in form fields
        selected_car: function(newVal) {
            console.log('Selected car changed to:', newVal);
        },
        full_name: function(newVal) {
            console.log('Full name changed to:', newVal);
        },
        client_email: function(newVal) {
            console.log('Email changed to:', newVal);
        },
        client_phonenumber: function(newVal) {
            console.log('Phone changed to:', newVal);
        }
    }
});

// Additional debugging for radio buttons
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== CHECKING RADIO BUTTONS ===');
    const radioButtons = document.querySelectorAll('input[name="selected_car"]');
    console.log('Radio buttons found:', radioButtons.length);
    
    if (radioButtons.length === 0) {
        console.error('❌ No radio buttons found! Check your HTML structure.');
    } else {
        console.log('✅ Radio buttons found:', radioButtons.length);
        radioButtons.forEach(function(radio, index) {
            console.log(`Radio ${index + 1}:`, {
                value: radio.value,
                name: radio.name,
                hasVModel: radio.hasAttribute('v-model')
            });
        });
    }
    
    // Check form element
    const form = document.querySelector('#reservation_second_form');
    if (!form) {
        console.error('❌ Form with ID "reservation_second_form" not found!');
    } else {
        console.log('✅ Form element found');
    }
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('❌ JavaScript error detected:', e.error);
    console.error('Error details:', {
        message: e.message,
        filename: e.filename,
        lineno: e.lineno,
        colno: e.colno
    });
});