document.addEventListener("DOMContentLoaded", () => {
  const wordsContainer = document.getElementById("words-container"); // Vaste container voor woorden
  const prioritySlots = document.querySelectorAll(".priority");
  let currentWordIndex = 0; // Houd de index bij van huidige woorden
  let words = []; // Array van woorden om dynamisch te laden

  // Laad woorden in de container bij start
  function loadWords() {
    fetch("../PHP/Woorden.ophalen.php") // Endpoint om de woorden op te halen
        .then((response) => response.json())
        .then((data) => {
          words = data; // Laad de woordenlijst
          displayWord(); // Toon het eerste woord
        })
        .catch((error) => {
          console.error("Fout bij ophalen van woorden:", error);
        });
  }

  // Toon het huidige woord in de container
  function displayWord() {
    if (currentWordIndex < words.length) {
      const word = words[currentWordIndex];
      wordsContainer.innerHTML = `<div class="word" draggable="true" data-woord="${word}">
                ${word}
            </div>`;
      setupDragListeners();
    } else {
      wordsContainer.innerHTML = "Geen woorden meer beschikbaar!";
    }
  }

  // Drag & drop event listeners instellen
  function setupDragListeners() {
    const wordElement = wordsContainer.querySelector(".word");
    wordElement.addEventListener("dragstart", handleDragStart);
  }

  function handleDragStart(e) {
    e.dataTransfer.setData("text/plain", e.target.dataset.woord);
  }

  prioritySlots.forEach((slot) => {
    slot.addEventListener("dragover", handleDragOver);
    slot.addEventListener("drop", handleDrop);
  });

  function handleDragOver(e) {
    e.preventDefault();
  }

  function handleDrop(e) {
    e.preventDefault();
    const word = e.dataTransfer.getData("text/plain");
    const category = e.target.dataset.priority;

    // Sla het woord en categorie op in de database
    saveWord(word, category);

    // Laad het volgende woord
    currentWordIndex++;
    displayWord();
  }

  function saveWord(word, category) {
    fetch("../PHP/Waarde.ophalen.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ woord: word, categorie: category }),
    })
        .then((response) => response.text())
        .then((data) => {
          console.log("Opslagresultaat:", data);
        })
        .catch((error) => {
          console.error("Fout bij opslaan:", error);
        });
  }

  // Start door woorden te laden
  loadWords();
});
