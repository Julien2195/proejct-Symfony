window.addEventListener("DOMContentLoaded", (event) => {
  const slider = document.querySelector(".slider");
  fetch("https://localhost:8000/admin/API/slider")
    .then((response) => response.json())
    .then((data) => {
      const nbrSlide = data.length;
      //Affichage des images
      for (let i = 0; i < data.length; i++) {
        const img = document.createElement("img");

        if (i === 0) {
          img.classList.add("active");
        }
        img.src = "/images/" + data[i].image;
        img.alt = data[i].titre;
        slider.append(img);
      }

      let count = 0;

      //Creation des boutons radio
      for (let i = 0; i < data.length; i++) {
        const btn = document.createElement("label");

        btn.setAttribute("for", "btn");
        btn.classList.add("btn-radio");
        if (i != 0) {
          btn.classList.add("margin");
        }
        slider.append(btn);
        btnClick();
      }

      function btnAutomatic() {
        const btns = document.querySelectorAll(".btn-radio");
        btns.forEach((btn, index) => {
          if (index === count) {
            btn.classList.add("btn-active");
          } else {
            btn.classList.remove("btn-active");
          }
        });
      }
      function btnClick() {
        const btns = document.querySelectorAll(".btn-radio");
        btns.forEach((btn, index) => {
          btn.addEventListener("click", () => {
            items[count].classList.remove("active");
            count = index;
            items[count].classList.add("active");
            btnAutomatic();
            updateInfoBanniere();
          });
        });
      }
      btnAutomatic();
      //Ajout des informations sur la bannière
      const banniere = document.querySelector(".banniere");
      const infoBanniere = document.querySelector(".infos-banniere");

      for (let i = 0; i < data.length; i++) {
        const h3 = document.createElement("h3");
        const p = document.createElement("p");

        h3.innerHTML = data[i].titre;
        p.innerHTML = data[i].description;

        infoBanniere.appendChild(h3);
        infoBanniere.appendChild(p);
      }

      const items = document.querySelectorAll(".slider img");
      const suivant = document.querySelector(".right");
      const precedent = document.querySelector(".left");

      setInterval(slideSuivante, 10000);
      suivant.addEventListener("click", slideSuivante);

      function updateInfoBanniere() {
        infoBanniere.innerHTML = "";

        const h3 = document.createElement("h3");
        const p = document.createElement("p");

        h3.innerHTML = data[count].titre;
        p.innerHTML = data[count].description;

        infoBanniere.appendChild(h3);
        infoBanniere.appendChild(p);
      }
      updateInfoBanniere();

      function slidePrecedente() {
        items[count].classList.remove("active");
        if (count > 0) {
          count--;
        } else {
          count = nbrSlide - 1;
        }
        items[count].classList.add("active");
        btnAutomatic();
        updateInfoBanniere();
      }
      precedent.addEventListener("click", slidePrecedente);

      function slideSuivante() {
        items[count].classList.remove("active");
        if (count < nbrSlide - 1) {
          count++;
        } else {
          count = 0;
        }
        btnAutomatic();
        items[count].classList.add("active");
        updateInfoBanniere();
      }
    });
});
