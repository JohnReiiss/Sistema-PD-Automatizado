document.addEventListener("DOMContentLoaded", () => {
  const mainContainer = document.getElementById("main-container");
  const showRegisterLink = document.getElementById("show-register");
  const showLoginLink = document.getElementById("show-login");

  const loginForm = document.getElementById("login-form");
  const registerForm = document.getElementById("register-form");

  let API_BASE_URL;

  if (
    window.location.hostname === "localhost" ||
    window.location.hostname === "127.0.0.1"
  ) {
    API_BASE_URL = "http://localhost:8000/back-end/api.php";
  } else {
    API_BASE_URL = "/linhas-de-pendrive/back-end/api.php";
  }

  showRegisterLink.addEventListener("click", () => {
    mainContainer.classList.add("show-register");
  });

  showLoginLink.addEventListener("click", () => {
    mainContainer.classList.remove("show-register");
  });

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const usuario = document.getElementById("login-usuario").value;
    const senha = document.getElementById("login-senha").value;

    try {
      const response = await fetch(`${API_BASE_URL}?action=login`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ usuario, senha }),
      });
      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message);
      }

      Swal.fire({
        icon: "success",
        title: "Login bem-sucedido!",
        text: "Você será redirecionado em breve.",
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true,
      }).then(() => {
        localStorage.setItem("authToken", result.token);
        window.location.href = "index.php";
      });
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: error.message || "Não foi possível conectar ao servidor.",
      });
    }
  });

  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const usuario = document.getElementById("register-usuario").value;
    const senha = document.getElementById("register-senha").value;

    try {
      const response = await fetch(`${API_BASE_URL}?action=register`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ usuario, senha }),
      });
      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message);
      }

      Swal.fire({
        icon: "success",
        title: "Cadastro realizado!",
        text: "Agora você já pode fazer o login.",
      }).then(() => {
        registerForm.reset();
        mainContainer.classList.remove("show-register");
      });
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Erro no Cadastro",
        text: error.message || "Não foi possível conectar ao servidor.",
      });
    }
  });
});
