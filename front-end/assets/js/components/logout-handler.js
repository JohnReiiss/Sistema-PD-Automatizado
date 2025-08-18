document.addEventListener("DOMContentLoaded", () => {
  const logoutLink = document.getElementById("logout-link");

  if (logoutLink) {
    logoutLink.addEventListener("click", (e) => {
      e.preventDefault();

      Swal.fire({
        title: "Você tem certeza?",
        text: "Sua sessão atual será encerrada.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, sair!",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          localStorage.removeItem("authToken");
          window.location.href = "login.php";
        }
      });
    });
  }
});
