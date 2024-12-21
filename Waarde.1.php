<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<link rel="stylesheet" href="../CSS/Waarde.css">
<body>
<header class="header">
    <div class="header-container">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" style="">
                <li><a class="dropdown-item active" href="Overzicht.php">Overzicht</a></li>
                <li><a class="dropdown-item" href="Waarde.1.php">Waarde</a></li>
                <li><a class="dropdown-item" href="Taken.1.php">Taken</a></li>
                <li><a class="dropdown-item" href="Netwerken.php">Netwerken</a></li>
                <li><a class="dropdown-item" href="Voorkeur.php">Voorkeur</a></li>
                <li><a class="dropdown-item" href="Profielpag.php">Profile</a></li>
                <li><a class="dropdown-item" href="contact.php">Contact</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" >Uitloggen</a></li>
            </ul>
        </div>
        <img src="../Windesheim_logo_Int_RGB-ZG.png" alt="Windesheim logo" class="logo">
        <div class="user-info">
            <img src="https://via.placeholder.com/40" alt="User Icon" class="user-icon" />
            <span>
            <h1><?php include 'header.php'; ?></h1>
            </span>
        </div>
    </div>
</header>

<div class="container">
    <main>
        <center>
            <h1>Waarde</h1>
        </center>
        <br>
        <h3>Het waardenspel</h3>

        <div class="Uitleg">
            <p>Hieronder in het grote blauwe vak zie je aantal eigenschappen. </p>
            <p>Klik op de kaart met de eigenschap naar de sectie waarin jij het passend vindt.</p>
        </div>

        <div id="words-container" class="card-container">
            <div class="card" id="draggable-card" draggable="true" data-word="Ambitieus">Ambitieus</div>
        </div>

        <form id="drop-form">
            <input type="hidden" name="woord" id="woord">
            <input type="hidden" name="categorie" id="categorie">

            <div class="sections">
                <div class="section" data-category="zeer-belangrijk" ondrop="handleDrop(event)" ondragover="allowDrop(event)">Zeer Belangrijk</div>
                <div class="section" data-category="belangrijk" ondrop="handleDrop(event)" ondragover="allowDrop(event)">Belangrijk</div>
                <div class="section" data-category="onbelangrijk" ondrop="handleDrop(event)" ondragover="allowDrop(event)">Onbelangrijk</div>
            </div>
        </form>
        <div id="response-message"></div> <!-- For success/failure messages -->
    </main>
    <a href="Overzicht.php" id="volgende" class="big-button">Opslaan</a></div>

<footer class="footer">
    <p>&copy; 2024 Windesheim. Alle rechten voorbehouden.</p>
</footer>


<script>
    const woorden = [
        "Respect", "Betrouwbaarheid", "Eerlijkheid", "Vrijheid", "Verantwoordelijkheid",
        "Liefde", "Integriteit", "Samenwerking", "Empathie", "Creativiteit",
        "Vastberadenheid", "Zelfontwikkeling", "Authenticiteit", "Gelijkwaardigheid", "Dankbaarheid"
    ];

    let woordIndex = 0; // Start bij het eerste woord in de lijst

    // Update woordkaart
    function updateWord() {
        if (woordIndex < woorden.length) {
            const nextWord = woorden[woordIndex++];
            const card = document.getElementById('draggable-card');
            card.textContent = nextWord;
            card.dataset.word = nextWord;
        } else {
            document.getElementById('draggable-card').textContent = "Je hebt alles gesleept";
        }
    }

    // Functie om de kaart te verplaatsen naar een categorie
    function moveToCategory(category) {
        const card = document.getElementById('draggable-card');
        const word = card.dataset.word;

        // Plaats de kaart in de gekozen categorie
        const targetSection = document.querySelector(`.section[data-category="${category}"]`);
        targetSection.appendChild(card);

        // Vul verborgen velden in voor verzending
        document.getElementById('woord').value = word;
        document.getElementById('categorie').value = category;

        submitForm(); // Verzend formulier
        updateWord(); // Ga naar het volgende woord
    }

    // Verzend het formulier via AJAX
    function submitForm() {
        const formData = new FormData(document.getElementById('drop-form'));

        fetch('Waarde.ophalen.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log("Data opgeslagen:", data);
            })
            .catch(error => {
                console.error("Fout bij opslaan:", error);
            });
    }

    // Event listeners voor categorieën
    document.querySelector('[data-category="zeer-belangrijk"]').addEventListener('click', () => moveToCategory('zeer-belangrijk'));
    document.querySelector('[data-category="belangrijk"]').addEventListener('click', () => moveToCategory('belangrijk'));
    document.querySelector('[data-category="onbelangrijk"]').addEventListener('click', () => moveToCategory('onbelangrijk'));

</script>
</body>
</html>
