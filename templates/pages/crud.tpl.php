<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kutatók CRUD</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #formDiv {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">

    <h2 class="mb-4 text-center">Kutatók kezelése</h2>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" onclick="showAddForm()">Új kutató hozzáadása</button>
    </div>

    <!-- Reszponzív táblázat -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>Név</th>
                    <th>Született</th>
                    <th>Meghalt</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody id="tabla"></tbody>
        </table>
    </div>

    <!-- Form -->
    <div id="formDiv" class="card p-3 mt-4 shadow-sm">
        <h4 id="formTitle">Új kutató</h4>

        <input type="hidden" id="fkod">

        <div class="mb-3">
            <label class="form-label">Név:</label>
            <input type="text" id="nev" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Született (év):</label>
            <input type="number" id="szul" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Meghalt (év):</label>
            <input type="number" id="meghal" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success" onclick="saveData()">Mentés</button>
            <button class="btn btn-secondary" onclick="hideForm()">Mégse</button>
        </div>
    </div>

</div>

<script>
// *** VÉGLEGES, HELYES API ÚTVONAL ***
const API = "/Feltalalokgyak/logicals/crud.php";

// LISTÁZÁS
function loadData() {
    fetch(API + "?action=list")
        .then(r => r.json())
        .then(data => {
            let html = "";
            data.forEach(k => {
                html += `
                    <tr>
                        <td>${k.fkod}</td>
                        <td>${k.nev}</td>
                        <td>${k.szul ?? ""}</td>
                        <td>${k.meghal ?? ""}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editItem(${k.fkod}, '${k.nev}', '${k.szul}', '${k.meghal}')">Szerkesztés</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteItem(${k.fkod})">Törlés</button>
                        </td>
                    </tr>
                `;
            });
            document.getElementById("tabla").innerHTML = html;
        });
}

loadData();

// FORM MEGJELENÍTÉSE
function showAddForm() {
    document.getElementById("formTitle").innerText = "Új kutató hozzáadása";
    document.getElementById("fkod").value = "";
    document.getElementById("nev").value = "";
    document.getElementById("szul").value = "";
    document.getElementById("meghal").value = "";
    document.getElementById("formDiv").style.display = "block";
}

function hideForm() {
    document.getElementById("formDiv").style.display = "none";
}

// SZERKESZTÉS
function editItem(fkod, nev, szul, meghal) {
    document.getElementById("formTitle").innerText = "Kutató szerkesztése";
    document.getElementById("fkod").value = fkod;
    document.getElementById("nev").value = nev;
    document.getElementById("szul").value = szul;
    document.getElementById("meghal").value = meghal;
    document.getElementById("formDiv").style.display = "block";
}

// MENTÉS
function saveData() {
    let fkod = document.getElementById("fkod").value;
    let data = {
        nev: document.getElementById("nev").value,
        szul: document.getElementById("szul").value,
        meghal: document.getElementById("meghal").value
    };

    let action = "add";

    if (fkod !== "") {
        action = "update";
        data.fkod = fkod;
    }

    fetch(API + "?action=" + action, {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(() => {
        hideForm();
        loadData();
    });
}

// TÖRLÉS
function deleteItem(fkod) {
    if (!confirm("Biztos törlöd?")) return;

    fetch(API + "?action=delete&fkod=" + fkod)
        .then(r => r.json())
        .then(() => loadData());
}
</script>

</body>
</html>
