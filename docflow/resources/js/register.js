
$(document).ready(function(){

    debugger
    console.log($('#user_role_select'));
    $('#user_role_select').on('change', function(){
        debugger
        var selectedValue = $(this).val();
        var inputBox = $('#register_form').find('#company_code');
        if(selectedValue == 2) {
            // if(inputBox.length === 0) {
            //     $('#register_form').append('<input type="text" id="company_code" name="company_code" placeholder="Enter value">');
            // }

            var additionalInputContainer = document.getElementById('additional_input');

            var inputElement = document.createElement('input');
            inputElement.setAttribute('type', 'text');
            inputElement.setAttribute('name', 'additional_input_name');
            inputElement.setAttribute('class', 'form-control');

            // Append input element to container
            additionalInputContainer.innerHTML = ''; // Clear existing content
            additionalInputContainer.appendChild(inputElement);


        } else {
            inputBox.remove();
        }
    });
});
