document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("authToken");
  const API_BASE_URL = "http://localhost:8000/back-end/api.php";
  const deleteForm = document.getElementById("delete-form");

  if (deleteForm) {
    deleteForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const productCode = document.getElementById("delete-produto").value;

      Swal.fire({
        title: "Você tem certeza?",
        text: `Você está prestes a excluir o produto "${productCode}". Esta ação é irreversível!`,
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
              `${API_BASE_URL}?action=deleteProduct`,
              {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({ produto: productCode }),
              }
            );

            const resData = await response.json();
            if (!response.ok) throw new Error(resData.message);

            Swal.fire("Excluído!", resData.message, "success").then(() =>
              deleteForm.reset()
            );
          } catch (error) {
            Swal.fire("Erro!", error.message, "error");
          }
        }
      });
    });
  }
});
