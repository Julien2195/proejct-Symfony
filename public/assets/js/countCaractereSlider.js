window.addEventListener("DOMContentLoaded", (e) => {
  const updateCounter = (
    input,
    counter,
    maxLengthTitre,
    pourcentLow,
    pourcentMiddle
  ) => {
    const valueLength = input.value.length;
    const caractereRestant = maxLengthTitre - valueLength;

    if (caractereRestant <= pourcentLow) {
      counter.classList.remove("btn-success", "btn-warning");
      counter.classList.add("btn-danger");
    } else if (caractereRestant <= pourcentMiddle) {
      counter.classList.remove("btn-success", "btn-danger");
      counter.classList.add("btn-warning");
    } else {
      counter.classList.remove("btn-danger", "btn-warning");
      counter.classList.add("btn-success");
    }
    if (caractereRestant < 0) return;

    counter.textContent = caractereRestant;
  };

  //Input
  const inputTitre = document.querySelector(".article-titre");
  const inputDescription = document.querySelector(".article-description");

  //Compteur de caractères
  const counterTitre = document.querySelector(".count-titre");
  const counterDescription = document.querySelector(".count-description");

  //MaxLength
  const maxLengthTitre = inputTitre.getAttribute("maxlength");
  const maxLengthDescription = inputDescription.getAttribute("maxlength");

  const pourcentMiddle = maxLengthTitre * 0.6;
  const pourcentLow = maxLengthTitre * 0.25;

  //Compteur Titre
  inputTitre.addEventListener("input", (e) => {
    updateCounter(
      inputTitre,
      counterTitre,
      maxLengthTitre,
      pourcentLow,
      pourcentMiddle
    );
  });

  inputDescription.addEventListener("input", (e) => {
    updateCounter(
      inputDescription,
      counterDescription,
      maxLengthDescription,
      pourcentLow,
      pourcentMiddle
    );
  });
});
