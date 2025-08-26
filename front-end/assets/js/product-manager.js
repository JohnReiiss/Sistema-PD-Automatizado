document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("authToken");

  let API_BASE_URL;

  if (
    window.location.hostname === "localhost" ||
    window.location.hostname === "127.0.0.1"
  ) {
    API_BASE_URL = "http://localhost:8000/back-end/api.php";
  } else {
    API_BASE_URL = "/linhas-de-pendrive/back-end/api.php";
  }

  const searchForm = document.getElementById("search-form");
  const searchInput = document.getElementById("search-input");
  const editSection = document.getElementById("edit-section");
  const editForm = document.getElementById("edit-form");

  if (searchForm) {
    searchForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const productCode = searchInput.value.trim();
      if (!productCode) return;

      try {
        const response = await fetch(
          `${API_BASE_URL}?action=getProduct&produto=${productCode}`
        );
        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message);
        }

        populateEditForm(result);
        editSection.classList.add("visible");
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Erro na Busca",
          text: error.message || "Produto não encontrado.",
        });
        editSection.classList.remove("visible");
      }
    });
  }

  if (editForm) {
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const productData = {
        produto: document.getElementById("edit-produto-original").value,
        PESO_MIN_MENOR: document.getElementById("edit-peso-min-menor").value,
        PESO_MIN_MAIOR: document.getElementById("edit-peso-min-maior").value,
        PESO_MAX_MENOR: document.getElementById("edit-peso-max-menor").value,
        PESO_MAX_MAIOR: document.getElementById("edit-peso-max-maior").value,
        PESO_START_MENOR: document.getElementById("edit-peso-start-menor")
          .value,
        TAMANHO_FONTE: document.getElementById("edit-tamanho-fonte").value,
        REVISAO: "1",
      };

      try {
        const response = await fetch(`${API_BASE_URL}?action=updateProduct`, {
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
          text: result.message,
        });
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Erro ao Salvar",
          text: error.message || "Não foi possível atualizar o produto.",
        });
      }
    });
  }

  function populateEditForm(data) {
    document.getElementById("edit-produto-original").value = data.PRODUTO;
    document.getElementById("edit-peso-min-menor").value = data.PESO_MIN_MENOR;
    document.getElementById("edit-peso-min-maior").value = data.PESO_MIN_MAIOR;
    document.getElementById("edit-peso-max-menor").value = data.PESO_MAX_MENOR;
    document.getElementById("edit-peso-max-maior").value = data.PESO_MAX_MAIOR;
    document.getElementById("edit-peso-start-menor").value =
      data.PESO_START_MENOR;
    document.getElementById("edit-tamanho-fonte").value = data.TAMANHO_FONTE;
  }
});
