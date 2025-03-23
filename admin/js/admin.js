$(document).ready(function() {
  $("button[name='imagebtn']").click(function() {
      var productId = $(this).attr("id").split('-')[1];
      var checkbox = $("#checkbox-" + productId);

      // Tüm checkbox'ları ve butonlardaki sınırları sıfırla
      $("input[type='checkbox']").prop("checked", false);
      $("button[name='imagebtn'] img").css("border", "none");

      // Seçilen checkbox'ı işaretle ve ilgili butonun sınırını ayarla
      checkbox.prop("checked", true);
      $(this).find("img").css("border", "2px solid black");
  });
});
document.addEventListener('DOMContentLoaded', function() {
var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
myModal.show();
});
document.addEventListener("DOMContentLoaded", function() {
  var scrollPosition = localStorage.getItem("scrollPosition");
  if (scrollPosition !== null) {
    window.scrollTo(0, scrollPosition);
  }
});

// Sayfa yenilenmeden veya kapatılmadan önce mevcut scroll konumunu saklar.
window.addEventListener("beforeunload", function() {
  localStorage.setItem("scrollPosition", window.scrollY);
});

const commentInput = document.getElementById('commenttextNL');
const endInput = document.getElementById('endtextboxNL');
const priceInput = document.getElementById('pricetextboxNL');
const imageInput = document.getElementById('image');
const submitBtn = document.getElementById('submitBtn');

function checkFormValidity() {
  const isCommentFilled = commentInput.value.trim() !== '';
  const isEndFilled = endInput.value.trim() !== '';
  const isPriceFilled = priceInput.value.trim() !== '';
  // Dosya input alanında en az bir dosya seçilmişse files.length > 0 olacaktır.
  const isImageSelected = imageInput.files.length > 0;

  // Tüm alanlar doluysa butonu aktif et, aksi halde disabled bırak.
  submitBtn.disabled = !(isCommentFilled && isEndFilled && isPriceFilled && isImageSelected);
}

// Metin alanları için input eventi, dosya alanı için change eventi ekleniyor.
commentInput.addEventListener('input', checkFormValidity);
endInput.addEventListener('input', checkFormValidity);
priceInput.addEventListener('input', checkFormValidity);
imageInput.addEventListener('change', checkFormValidity);

// Sayfa yüklendiğinde form durumunu kontrol et.
checkFormValidity();




const commentInputNS = document.getElementById('commenttextNS');
const endInputNS = document.getElementById('endtextboxNS');
const priceInputNS = document.getElementById('pricetextboxNS');
const submitBtnNS = document.getElementById('submitBtnNS');
const imageInputNS = document.getElementById('imageNS');

function checkFormValidityNS() {
const isCommentFilledNS = commentInputNS.value.trim() !== '';
const isEndFilledNS = endInputNS.value.trim() !== '';
const isPriceFilledNS = priceInputNS.value.trim() !== '';
const isImageSelectedNS = imageInputNS.files.length > 0;

// Tüm alanlar doluysa butonu aktif et, aksi halde disabled bırak.
submitBtnNS.disabled = !(isCommentFilledNS && isEndFilledNS && isPriceFilledNS && isImageSelectedNS);

}

commentInputNS.addEventListener('input', checkFormValidityNS);
endInputNS.addEventListener('input', checkFormValidityNS);
priceInputNS.addEventListener('input', checkFormValidityNS);
imageInputNS.addEventListener('change', checkFormValidityNS);
checkFormValidityNS();



const commentInputBL = document.getElementById('commenttextBL');
const endInputBL = document.getElementById('endtextboxBL');
const priceInputBL = document.getElementById('pricetextboxBL');
const submitBtnBL = document.getElementById('submitBtnBL');
const imageInputBL = document.getElementById('imageBL');

function checkFormValidityBL() {
const isCommentFilledBL = commentInputBL.value.trim() !== '';
const isEndFilledBL = endInputBL.value.trim() !== '';
const isPriceFilledBL = priceInputBL.value.trim() !== '';
const isImageSelectedBL = imageInputBL.files.length > 0;

// Tüm alanlar doluysa butonu aktif et, aksi halde disabled bırak.
submitBtnBL.disabled = !(isCommentFilledBL && isEndFilledBL && isPriceFilledBL && isImageSelectedBL);

}

commentInputBL.addEventListener('input', checkFormValidityBL);
endInputBL.addEventListener('input', checkFormValidityBL);
priceInputBL.addEventListener('input', checkFormValidityBL);
imageInputBL.addEventListener('change', checkFormValidityBL);
checkFormValidityBL();



const commentInputBS = document.getElementById('commenttextBS');
const endInputBS = document.getElementById('endtextboxBS');
const priceInputBS = document.getElementById('pricetextboxBS');
const submitBtnBS = document.getElementById('submitBtnBS');
const imageInputBS = document.getElementById('imageBS');

function checkFormValidityBS() {
const isCommentFilledBS = commentInputBS.value.trim() !== '';
const isEndFilledBS = endInputBS.value.trim() !== '';
const isPriceFilledBS = priceInputBS.value.trim() !== '';
const isImageSelectedBS = imageInputBS.files.length > 0;

// Tüm alanlar doluysa butonu aktif et, aksi halde disabled bırak.
submitBtnBS.disabled = !(isCommentFilledBS && isEndFilledBS && isPriceFilledBS && isImageSelectedBS);

}

commentInputBS.addEventListener('input', checkFormValidityBS);
endInputBS.addEventListener('input', checkFormValidityBS);
priceInputBS.addEventListener('input', checkFormValidityBS);
imageInputBS.addEventListener('change', checkFormValidityBS);
checkFormValidityBS();



