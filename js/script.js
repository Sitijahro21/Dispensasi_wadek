function validateForm(event) {
    event.preventDefault(); // Mencegah form untuk langsung disubmit
    document.getElementById("confirmationModal").style.display = "block";
    return false; // Menghentikan pengiriman form
}

function closeModal() {
    document.getElementById("confirmationModal").style.display = "none";
}

function confirmSubmit() {
    document.getElementById("confirmationModal").style.display = "none";
    document.querySelector("form").submit(); // Mengirim form ke server
}
