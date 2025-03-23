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





document.addEventListener("DOMContentLoaded", function () {
  const scrollBox = document.querySelector('.scroll-box');
  const scrollUpBtn = document.getElementById("top");
  const scrollDownBtn = document.getElementById("bottom");
  const scrollAmount = 300;

  function smoothScroll(amount) {
    let start = scrollBox.scrollTop;
    let end = start + amount;
    let step = (end - start) / 10; // Küçük adımlarla geçiş

    let count = 0;
    function animateScroll() {
      if (count < 10) {
        scrollBox.scrollTop += step;
        count++;
        setTimeout(animateScroll, 10); // 10ms bekleyerek kaydır
      }
    }
    animateScroll();
  }

  scrollUpBtn.addEventListener("click", function () {
    if (scrollBox.scrollTop > 0) {
      smoothScroll(-scrollAmount);
    }
  });

  scrollDownBtn.addEventListener("click", function () {
    if (scrollBox.scrollTop + scrollBox.clientHeight < scrollBox.scrollHeight) {
      smoothScroll(scrollAmount);
    }
  });
});
