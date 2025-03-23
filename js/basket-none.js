// script.js
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.getElementById("loader").style.display = "none";
  }, 2000);
});


setTimeout(() => {
  document.getElementById("ruj").style.animation = "2s anim infinite";
}, 100);

setTimeout(() => {
  document.getElementById("book").style.animation = "2s anim infinite";
}, 500);

setTimeout(() => {
  document.getElementById("baget").style.animation = "2s anim infinite";
}, 1000);

setTimeout(() => {
  document.getElementById("pencil").style.animation = "2s anim infinite";
}, 1500);

const button = document.getElementById("lookbtn");

// Hover olayları için dinleyiciler ekliyoruz
button.addEventListener("mouseenter", () => {
  document.getElementById("eyes").style.display="none";
  document.getElementById("face").style.display="inline";
});

button.addEventListener("mouseleave", () => {
    document.getElementById("face").style.display="none";
    document.getElementById("eyes").style.display="inline";
});
