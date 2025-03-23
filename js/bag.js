
window.onload = function() {
  let popup = document.getElementById("popupBox");
  if (popup) {
    popup.style.display = "flex"; // Doğru şekilde görünmesi için
  }
};

// Popup'ı kapatma fonksiyonu
function closePopup() {
  let popup = document.getElementById("popupBox");
  if (popup) {
    popup.style.display = "none";
  }
}
// Seçimleri güncelleyen fonksiyon
function updateSelection(color = null, size = null, modelID = null) {
  // Renk güncelleme
  if (color) {
    document.getElementById("naturel").style.border = "none";
    document.getElementById("black").style.border = "none";
    document.getElementById(color).style.border = "2px solid #000";
    document.getElementById("selectedColor").value = color;
    sessionStorage.setItem("selectedColor", color); // localStorage yerine sessionStorage
  }

  // Boyut güncelleme
  if (size) {
    document.getElementById("large").style.border = "none";
    document.getElementById("small").style.border = "none";
    document.getElementById(size).style.border = "2px solid #000";
    document.getElementById("selectedSize").value = size;
    sessionStorage.setItem("selectedSize", size); // localStorage yerine sessionStorage
  }

  // Model (ürün) güncelleme
  if (modelID) {
    // Tüm model elemanlarından kenarlıkları kaldır
    const models = document.querySelectorAll('.model');
    models.forEach(model => {
      model.style.border = "none";
    });

    // Seçilen modelin kenarlığını ekle
    const selectedModel = document.getElementById(modelID);
    if (selectedModel) {
      selectedModel.style.border = "2px solid #000";
      document.getElementById("selectedID").value = modelID;
      sessionStorage.setItem("selectedID", modelID); // localStorage yerine sessionStorage
    }
  }

  // Seçim tamamlandıktan sonra isteğe bağlı form gönderimini tetikleyebilirsiniz
  document.getElementById("submitSelection").click();
}

window.onload = function() {
  // Daha önce yapılan seçimleri sessionStorage'dan alıyoruz veya varsayılan değerleri belirliyoruz.
  var selectedColor = sessionStorage.getItem("selectedColor") || "naturel";
  var selectedSize = sessionStorage.getItem("selectedSize") || "large";
  var selectedID = sessionStorage.getItem("selectedID");

  // Model seçimi için, eğer daha önce seçim yapılmamışsa ilk modeli seçiyoruz.
  const models = document.querySelectorAll('.model');
  if (!selectedID && models.length > 0) {
    selectedID = models[0].id;
    sessionStorage.setItem("selectedID", selectedID);
  }

  // Renk seçim arayüzünü güncelle
  if (document.getElementById(selectedColor)) {
    document.getElementById("naturel").style.border = "none";
    document.getElementById("black").style.border = "none";
    document.getElementById(selectedColor).style.border = "2px solid #000";
    document.getElementById("selectedColor").value = selectedColor;
  }

  // Boyut seçim arayüzünü güncelle
  if (document.getElementById(selectedSize)) {
    document.getElementById("large").style.border = "none";
    document.getElementById("small").style.border = "none";
    document.getElementById(selectedSize).style.border = "2px solid #000";
    document.getElementById("selectedSize").value = selectedSize;
  }

  // Model seçim arayüzünü güncelle
  if (selectedID && document.getElementById(selectedID)) {
    models.forEach(model => {
      model.style.border = "none";
    });
    document.getElementById(selectedID).style.border = "2px solid #000";
    document.getElementById("selectedID").value = selectedID;
  }


  // Renk butonlarına event listener ekleme
  document.getElementById("naturel").addEventListener("click", function() {
    updateSelection("naturel", null, null);
  });
  document.getElementById("black").addEventListener("click", function() {
    updateSelection("black", null, null);
  });

  // Boyut butonlarına event listener ekleme
  document.getElementById("large").addEventListener("click", function() {
    updateSelection(null, "large", null);
  });
  document.getElementById("small").addEventListener("click", function() {
    updateSelection(null, "small", null);
  });

  // Model görsellerine event listener ekleme
  models.forEach(model => {
    model.addEventListener("click", function() {
      updateSelection(null, null, this.id);
    });
  });

};

window.addEventListener("beforeunload", function() {
  localStorage.setItem("scrollPosition", window.scrollY);
});
 window.addEventListener("beforeunload", function () {
    navigator.sendBeacon('logout.php'); // Kullanıcı çıkınca oturumu kapat
  });
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
      document.getElementById("loader").style.display = "none";
    }, 1300);
  });

  setTimeout(() => {
    document.getElementById("ruj").style.animation = "2s anim infinite";
  }, 0);
  
  setTimeout(() => {
    document.getElementById("book").style.animation = "2s anim infinite";
  }, 500);
  
  setTimeout(() => {
    document.getElementById("baget").style.animation = "2s anim infinite";
  }, 1000);
  
  setTimeout(() => {
    document.getElementById("pencil").style.animation = "2s anim infinite";
  }, 1500);






// Butonu seçiyoruz
const button = document.getElementById("basketbtn");

// Hover olayları için dinleyiciler ekliyoruz
button.addEventListener("mouseenter", () => {
  document.getElementById("basket").style.animation="baskethover 2s alternate forwards";
  document.getElementById("basket").style.left="60%";
});

button.addEventListener("mouseleave", () => {
    document.getElementById("basket").style.animation="basketover 2s alternate forwards";
    document.getElementById("basket").style.left="-25%";
});




  