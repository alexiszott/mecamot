function emailSend(){

    let params = {
        name_contact : document.getElementById('name_contact').value,
        email_contact : document.getElementById('email_contact').value,
        texte_contact : document.getElementById('texte_contact').value,
    }

    emailjs.send('service_s8v0vlu','template_py0w2kv', params).then(
        (response) => {
            alert("Email envoyé.");
        },
        (error) => {
            alert("Une erreur s'est produite. Veuillez réessayer.");
        },
    )
}