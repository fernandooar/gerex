document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("modoNoturno");
    btn?.addEventListener("click", () => {
      document.body.classList.toggle("dark-mode");
    });
  });
  