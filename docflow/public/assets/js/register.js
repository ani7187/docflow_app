
$(document).ready(function(){

    debugger
    $('#user_role_select').on('change', function(){
        debugger
        var selectedValue = $(this).val();
        var inputBox = $('#register_form').find('#company_code');
        if(selectedValue == 3) {
            // if(inputBox.length === 0) {
            //     $('#register_form').append('<input type="text" id="company_code" name="company_code" placeholder="Enter value">');
            // }

            var passwordConfirmationInput = createEmployeeConfirmationInput();
            var container = document.getElementById('employee-confirm-div');
            container.appendChild(passwordConfirmationInput);
        } else {
            inputBox.remove();
        }
    });


    function createEmployeeConfirmationInput() {
        // Create the row element
        var row = document.createElement('div');
        row.classList.add('row', 'mb-3');

        // Create the label element
        var label = document.createElement('label');
        label.setAttribute('for', 'employee-confirm');
        label.classList.add('col-md-4', 'col-form-label', 'text-md-end');
        label.textContent = "Կազմզկերպության կոդը";

        // Create the input element
        var input = document.createElement('input');
        input.setAttribute('id', 'confirm-employee');
        input.setAttribute('type', 'text');
        input.classList.add('form-control');
        input.setAttribute('name', 'code');
        input.setAttribute('required', '');

        // Create the column element for the input
        var inputColumn = document.createElement('div');
        inputColumn.classList.add('col-md-6');

        // Append the input to the column element
        inputColumn.appendChild(input);

        // Append the label and input column to the row element
        row.appendChild(label);
        row.appendChild(inputColumn);

        // Return the row element
        return row;
    }
});
