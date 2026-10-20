const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');
const adminOpen = document.getElementById('adminOpen');
const adminClose = document.getElementById('adminClose');
const adminModal = document.getElementById('adminModal');
const adminForm = document.getElementById('adminForm');
const loginMessage = document.getElementById('loginMessage');

document.getElementById('year').textContent = new Date().getFullYear();

menuToggle.addEventListener('click', () => {
  const isOpen = navMenu.classList.toggle('open');
  menuToggle.setAttribute('aria-expanded', String(isOpen));
  menuToggle.textContent = isOpen ? '×' : '☰';
});

navMenu.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    navMenu.classList.remove('open');
    menuToggle.setAttribute('aria-expanded', 'false');
    menuToggle.textContent = '☰';
  });
});

function openAdminModal() {
  adminModal.classList.add('open');
  adminModal.setAttribute('aria-hidden', 'false');
  loginMessage.textContent = '';
  document.body.style.overflow = 'hidden';
  setTimeout(() => document.getElementById('adminUser').focus(), 50);
}
function closeAdminModal() {
  adminModal.classList.remove('open');
  adminModal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
  adminOpen.focus();
}
adminOpen.addEventListener('click', openAdminModal);
adminClose.addEventListener('click', closeAdminModal);
adminModal.addEventListener('click', event => {
  if (event.target === adminModal) closeAdminModal();
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && adminModal.classList.contains('open')) closeAdminModal();
});

adminForm.addEventListener('submit', event => {
  event.preventDefault();
  // Front-end demo only. Do not validate real credentials in browser-side JavaScript.
  loginMessage.textContent = 'Form demo siap. Hubungkan ke backend/API untuk memverifikasi akun admin.';
  loginMessage.style.color = '#9a7025';
});
