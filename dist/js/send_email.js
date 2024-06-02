document.addEventListener('DOMContentLoaded', function() {
    let form = document.getElementById('contact-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        emailSend();
        clearInput();
    });
});

function emailSend() {
    let data = {
        service_id: 'service_s8v0vlu',
        template_id: 'template_py0w2kv',
        user_id: 'EAOlP_KtZFgh-f39I',
        template_params: {
            'name_contact': document.getElementById('name_contact').value,
            'email_contact': document.getElementById('email_contact').value,
            'texte_contact': document.getElementById('texte_contact').value,
        }
    };

    $.ajax('https://api.emailjs.com/api/v1.0/email/send', {
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json'
    }).done(function() {
        $('#valideEmail').modal('show');
    }).fail(function(error) {
        $('#errorEmail').modal('show');
    });
}

function clearInput(){
    document.getElementById("name_contact").value = "";
    document.getElementById("email_contact").value = "";
    document.getElementById("texte_contact").value = "";
}
