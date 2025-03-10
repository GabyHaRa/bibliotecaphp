// Enviar el formulario automáticamente.
document.getElementById("comentario").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("comentarioForm").submit();
    }
});