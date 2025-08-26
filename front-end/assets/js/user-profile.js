document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("authToken");
  // --- Environment Adaptation Jutsu ---
  let API_BASE_URL;

  if (
    window.location.hostname === "localhost" ||
    window.location.hostname === "127.0.0.1"
  ) {
    // For development environment (local)
    API_BASE_URL = "http://localhost:8000/back-end/api.php";
  } else {
    // For prod environment (production)
    API_BASE_URL = "/MultiHub/PDA-Systen/back-end/api.php";
  }
  // --- End of jutsu ---

  // --- ELEMENTS DOM ---
  const greetingElement = document.getElementById("profile-greeting");
  const userIdInput = document.getElementById("user-id");
  const userInput = document.getElementById("profile-usuario");
  const roleSelect = document.getElementById("profile-role");
  const passwordInput = document.getElementById("profile-senha");
  const saveButton = document.getElementById("save-profile-button");
  const profileForm = document.getElementById("profile-form");

  /**
   * Decodes the JWT token to extract user data.
   * @param {string} token The JWT token.
   * @returns {object|null} User data (id, user, role).
   */
  function getDataFromToken(token) {
    if (!token) return null;
    try {
      return JSON.parse(atob(token.split(".")[1])).data;
    } catch (e) {
      return null;
    }
  }

  function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return "Bom dia";
    if (hour < 18) return "Boa tarde";
    return "Boa noite";
  }

  const actorData = getDataFromToken(token);
  const actorRole = actorData ? actorData.role : null;

  async function loadProfile() {
    try {
      const response = await fetch(`${API_BASE_URL}?action=getMyProfile`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      const data = await response.json();
      if (!response.ok) throw new Error(data.message);

      userIdInput.value = data.ID;
      userInput.value = data.USUARIO;
      roleSelect.value = data.TIPO_ACESSO;

      if (greetingElement) {
        greetingElement.textContent = `${getGreeting()}, ${data.USUARIO}!`;
      }

      if (["ADMINISTRADOR", "HOKAGE"].includes(actorRole)) {
        roleSelect.disabled = false;
        passwordInput.disabled = false;
        saveButton.disabled = false;
      }
    } catch (error) {
      Swal.fire(
        "Erro",
        "Não foi possível carregar os dados do perfil.",
        "error"
      );
    }
  }

  profileForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!["ADMINISTRADOR", "HOKAGE"].includes(actorRole)) {
      Swal.fire(
        "Acesso Negado!",
        "Sua senha ou nível de acesso só podem ser alterados por um administrador. Por favor, abra um chamado para a automação!",
        "error"
      );
      return;
    }

    const dataToUpdate = {
      id: userIdInput.value,
      tipo_acesso: roleSelect.value,
      senha: passwordInput.value,
    };

    try {
      const response = await fetch(
        `${API_BASE_URL}?action=updateProfileByAdmin`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify(dataToUpdate),
        }
      );
      const result = await response.json();
      if (!response.ok) throw new Error(result.message);

      Swal.fire("Sucesso!", "Perfil atualizado com sucesso.", "success");
      passwordInput.value = "";
    } catch (error) {
      Swal.fire("Erro!", error.message, "error");
    }
  });

  loadProfile();
});
