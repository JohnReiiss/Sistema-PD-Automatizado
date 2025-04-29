document.addEventListener("DOMContentLoaded", function () {
  const anoSpan = document.getElementById("ano-atual");
  const anoAtual = new Date().getFullYear();
  if (anoSpan) {
    anoSpan.textContent = anoAtual;
  }
});
