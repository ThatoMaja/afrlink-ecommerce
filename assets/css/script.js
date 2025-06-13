document.addEventListener("DOMContentLoaded", () => {
  const menuIcon = document.getElementById("menu-icon");
  const navbar = document.getElementById("navbar");

  if (!menuIcon || !navbar) return;

  // Toggle open
  menuIcon.addEventListener("click", () => {
    navbar.style.right = "0";
  });

  // Close icon inside menu
  const closeBtn = document.createElement("i");
  closeBtn.classList.add("fas", "fa-times");
  closeBtn.style.position = "absolute";
  closeBtn.style.top = "20px";
  closeBtn.style.right = "20px";
  closeBtn.style.cursor = "pointer";
  closeBtn.style.fontSize = "24px";
  closeBtn.style.color = "#1a1a1a";
  closeBtn.setAttribute("id", "menu-close");


  navbar.prepend(closeBtn);

  // Toggle close
  closeBtn.addEventListener("click", () => {
    navbar.style.right = "-300px";
  });
});



