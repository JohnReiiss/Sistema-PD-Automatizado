document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("authToken");
  const API_BASE_URL = "http://localhost:8000/back-end/api.php";

  const registerForm = document.getElementById("register-form");

  if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const productData = {
        produto: document.getElementById("reg-produto").value,
        PESO_MIN_MENOR: document.getElementById("reg-peso-min-menor").value,
        PESO_MIN_MAIOR: document.getElementById("reg-peso-min-maior").value,
        PESO_MAX_MENOR: document.getElementById("reg-peso-max-menor").value,
        PESO_MAX_MAIOR: document.getElementById("reg-peso-max-maior").value,
        PESO_START_MENOR: document.getElementById("reg-peso-start-menor").value,
        TAMANHO_FONTE: document.getElementById("reg-tamanho-fonte").value,
        REVISAO: "1",
      };

      try {
        const response = await fetch(`${API_BASE_URL}?action=createProduct`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify(productData),
        });

        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message);
        }

        Swal.fire({
          icon: "success",
          title: "Sucesso!",
          text: "Produto cadastrado com sucesso!",
        }).then(() => {
          registerForm.reset();
          window.location.href = "index.php";
        });
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Operação não permitida",
          text: error.message,
        });
      }
    });
  }
});
