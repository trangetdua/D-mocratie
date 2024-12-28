document.querySelector("form").addEventListener("submit", function(event) {
    const codePostal = document.getElementById("code-postal").value;
    const regex = /^[0-9]{5}$/;

    if (!regex.test(codePostal)) {
        alert("Le code postal doit contenir exactement 5 chiffres.");
        event.preventDefault(); 
    }
});
