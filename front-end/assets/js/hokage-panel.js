document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("authToken");

  let API_BASE_URL;

  if (
    window.location.hostname === "localhost" ||
    window.location.hostname === "127.0.0.1"
  ) {
    API_BASE_URL = "http://localhost:8000/back-end/api.php";
  } else {
    API_BASE_URL = "/MultiHub/PDA-Systen/back-end/api.php";
  }

  /**
   * Helper function to decode the token and get the user data.
   * @param {string} token The localStorage JWT token.
   * @returns {object|null} User data (id, user, role).
   */
  function getDataFromToken(token) {
    if (!token) return null;
    try {
      return JSON.parse(atob(token.split(".")[1])).data;
    } catch (e) {
      console.error("Erro ao decodificar o token:", e);
      return null;
    }
  }

  // --- ROUTE PROTECTION ---
  const currentUser = getDataFromToken(token);
  if (!currentUser || currentUser.role !== "HOKAGE") {
    Swal.fire({
      icon: "error",
      title: "Acesso Negado",
      text: "Você não tem permissão para acessar esta página.",
      allowOutsideClick: false,
    }).then(() => {
      window.location.href = "index.php";
    });
    return;
  }

  // --- DOM SELECTORS ---
  const totalUsersSpan = document.getElementById("total-users");
  const userSelect = document.getElementById("select-user");
  let allUsers = []; // stores user data in memory

  // Tabs
  const tabLinks = document.querySelectorAll(".tab-link");
  const tabContents = document.querySelectorAll(".tab-content");

  // Forms and Buttons
  const createUserForm = document.getElementById("create-user-form");
  const editUserForm = document.getElementById("edit-user-form");
  const deleteUserButton = document.getElementById("delete-user-button");

  // --- TABS LOGIC ---
  tabLinks.forEach((link) => {
    link.addEventListener("click", () => {
      tabLinks.forEach((item) => item.classList.remove("active"));
      tabContents.forEach((item) => item.classList.remove("active"));
      link.classList.add("active");
      document.getElementById(link.dataset.tab).classList.add("active");
    });
  });

  // --- MAIN FUNCTIONS ---

  //User finder in the API.
  async function loadUsers() {
    try {
      const response = await fetch(`${API_BASE_URL}?action=getAllUsers`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      const users = await response.json();
      if (!response.ok) throw new Error(users.message);

      allUsers = users;
      totalUsersSpan.textContent = users.length;

      userSelect.innerHTML =
        '<option value="">-- Selecione um usuário para editar ou excluir --</option>';
      users.forEach((user) => {
        const option = document.createElement("option");
        option.value = user.ID;
        option.textContent = `${user.USUARIO} (${user.TIPO_ACESSO})`;
        userSelect.appendChild(option);
      });
    } catch (error) {
      Swal.fire(
        "Erro!",
        `Não foi possível carregar os usuários: ${error.message}`,
        "error"
      );
    }
  }

  // --- EVENT LISTENERS ---

  userSelect.addEventListener("change", () => {
    const selectedId = userSelect.value;
    const selectedUser = allUsers.find((user) => user.ID == selectedId);
    if (selectedUser) {
      document.getElementById("edit-user-name").value = selectedUser.USUARIO;
      document.getElementById("edit-user-role").value =
        selectedUser.TIPO_ACESSO;
      document.getElementById("edit-user-password").value = "";
    } else {
      editUserForm.reset();
    }
  });

  createUserForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const data = {
      usuario: document.getElementById("new-user-name").value,
      senha: document.getElementById("new-user-password").value,
      tipo_acesso: document.getElementById("new-user-role").value,
    };

    try {
      const response = await fetch(
        `${API_BASE_URL}?action=createUserByHokage`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify(data),
        }
      );
      const result = await response.json();
      if (!response.ok) throw new Error(result.message);

      Swal.fire("Sucesso!", result.message, "success");
      createUserForm.reset();
      loadUsers();
    } catch (error) {
      Swal.fire("Erro!", error.message, "error");
    }
  });

  editUserForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const userId = userSelect.value;
    if (!userId) {
      Swal.fire(
        "Atenção!",
        "Por favor, selecione um usuário para editar.",
        "warning"
      );
      return;
    }

    const data = {
      id: userId,
      usuario: document.getElementById("edit-user-name").value,
      senha: document.getElementById("edit-user-password").value,
      tipo_acesso: document.getElementById("edit-user-role").value,
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
          body: JSON.stringify(data),
        }
      );
      const result = await response.json();
      if (!response.ok) throw new Error(result.message);

      Swal.fire("Sucesso!", result.message, "success");
      editUserForm.reset();
      loadUsers();
    } catch (error) {
      Swal.fire("Erro!", error.message, "error");
    }
  });

  deleteUserButton.addEventListener("click", async () => {
    const userId = userSelect.value;
    const selectedUser = allUsers.find((user) => user.ID == userId);
    if (!userId || !selectedUser) {
      Swal.fire(
        "Atenção!",
        "Por favor, selecione um usuário para excluir.",
        "warning"
      );
      return;
    }

    Swal.fire({
      title: "Você tem certeza?",
      text: `Você está prestes a excluir o usuário "${selectedUser.USUARIO}". Esta ação é irreversível!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Sim, excluir!",
      cancelButtonText: "Cancelar",
    }).then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await fetch(
            `${API_BASE_URL}?action=deleteUserByHokage`,
            {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
              },
              body: JSON.stringify({ id: userId }),
            }
          );
          const resData = await response.json();
          if (!response.ok) throw new Error(resData.message);

          Swal.fire("Excluído!", resData.message, "success");
          editUserForm.reset();
          loadUsers(); // Update the list
        } catch (error) {
          Swal.fire("Erro!", error.message, "error");
        }
      }
    });
  });

  loadUsers();
});
