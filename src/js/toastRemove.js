window.showToast = function (message, type = "info") {
  const toast = document.createElement("div");
  toast.className = `toast ${type}`;
  toast.innerHTML = `
      ${message}
      <div class="progress-bar"></div>
    `;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 5000);
};
