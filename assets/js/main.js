document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll('a[href^="#"]');
  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("href").substring(1);
      const targetElement = document.getElementById(targetId);
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop,
          behavior: "smooth"
        });
      }
    });
  });
});
async function loadImageAsync(img) {
  return new Promise((resolve, reject) => {
    const src = img.getAttribute("data-src");
    const imageElement = new Image();
    imageElement.onload = () => {
      img.setAttribute("src", src);
      img.classList.add("fade-in");
      resolve();
    };
    imageElement.onerror = () => {
      reject(new Error("Failed to load image"));
    };
    imageElement.src = src;
  });
}
async function lazyLoad(target) {
  const io = new IntersectionObserver(async (entries, observer) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        const img = entry.target;
        await loadImageAsync(img);
        observer.unobserve(img);
      }
    }
  });
  io.observe(target);
}
const lazyImages = document.querySelectorAll(".lazy");
lazyImages.forEach(lazyLoad);
document.addEventListener("DOMContentLoaded", function() {
  const accordionItems = document.querySelectorAll(".accordion-item");
  accordionItems.forEach((item, index) => {
    const header = item.querySelector(".accordion-header");
    const content = item.querySelector(".accordion-content");
    header.addEventListener("click", function() {
      accordionItems.forEach((otherItem) => {
        if (otherItem !== item) {
          otherItem.classList.remove("active");
          otherItem.querySelector(".accordion-content").style.display = "none";
        }
      });
      item.classList.toggle("active");
      content.style.display = item.classList.contains("active") ? "block" : "none";
    });
  });
});
const modals = document.querySelectorAll(".modal");
const menuItems = document.querySelectorAll(".menuItem");
menuItems.forEach((menuItem) => {
  menuItem.addEventListener("click", () => {
    const modalId = menuItem.getAttribute("data-modal");
    openModal(modalId);
  });
});
modals.forEach((modal) => {
  modal.addEventListener("click", () => {
    const modalId = modal.getAttribute("id");
    closeModal(modalId);
  });
  modal.querySelector(".close-btn").addEventListener("click", (event) => {
    event.stopPropagation();
    const modalId = modal.getAttribute("id");
    closeModal(modalId);
  });
});
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.style.display = "flex";
}
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.style.display = "none";
}
//# sourceMappingURL=main.js.map
