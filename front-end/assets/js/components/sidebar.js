document.addEventListener("DOMContentLoaded", () => {
  function getDataFromToken(token) {
    if (!token) return null;
    try {
      return JSON.parse(atob(token.split(".")[1])).data;
    } catch (e) {
      console.error("Erro ao decodificar o token:", e);
      return null;
    }
  }

  const tokenData = getDataFromToken(localStorage.getItem("authToken"));

  if (tokenData && tokenData.role === "HOKAGE") {
    const hokageMenu = document.getElementById("hokage-menu");
    if (hokageMenu) {
      hokageMenu.style.display = "block";
    }
  }

  const hamburgerMenu = document.getElementById("hamburger-menu");
  const overlay = document.getElementById("overlay");
  const pdaMenu = document.getElementById("pda-menu");

  function toggleSidebar() {
    hamburgerMenu.classList.toggle("is-active");
    document.body.classList.toggle("sidebar-open");
  }

  if (hamburgerMenu) {
    hamburgerMenu.addEventListener("click", toggleSidebar);
  }

  if (overlay) {
    overlay.addEventListener("click", toggleSidebar);
  }

  if (pdaMenu) {
    pdaMenu.addEventListener("click", (e) => {
      const isToggleLink = e.target.closest(".dropdown-toggle");
      if (isToggleLink) {
        e.preventDefault();
        pdaMenu.classList.toggle("active");
      }
    });
  }
});
