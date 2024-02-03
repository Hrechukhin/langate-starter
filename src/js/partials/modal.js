/*
Usage example

<div data-modal="modal">Button</div>

<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2>Modal 1 Content</h2>
    <p>This is the content for Modal 1.</p>
  </div>
</div>

<div class="overlay"></div>

*/

const modals = document.querySelectorAll('.modal');
const menuItems = document.querySelectorAll('.menuItem');

menuItems.forEach(menuItem => {
  menuItem.addEventListener('click', () => {
    const modalId = menuItem.getAttribute('data-modal');
    openModal(modalId);
  });
});

modals.forEach(modal => {
  modal.addEventListener('click', () => {
    const modalId = modal.getAttribute('id');
    closeModal(modalId);
  });

  modal.querySelector('.close-btn').addEventListener('click', (event) => {
    event.stopPropagation();
    const modalId = modal.getAttribute('id');
    closeModal(modalId);
  });
});

function openModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.style.display = 'none';
}
