
<?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kutatók CRUD</title>

    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: transparent;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #bcd6ff;
            padding: 10px;
            text-align: center;
            color:black;
        }
        th {
            background-color: #cfe8ff;
            color: black;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.25);
        }

        /* ===== GOMB STÍLUS ===== */
        button {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            transition: 0.2s;
        }

        /* Törlés - piros */
        .delete-btn {
            background-color: #e74c3c;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Szerkesztés - világoskék */
        .edit-btn {
            background-color: #3498db;
        }
        .edit-btn:hover {
            background-color: #2980b9;
        }

        /* Submit gomb (extra, hogy ez is szép legyen) */
        #SubmitBtn {
            background-color: #2ecc71;
        }
        #SubmitBtn:hover {
            background-color: #27ae60;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">Kutatók adatai</h2>

<!-- HOZZÁADÁS FORM -->
<form method="post" action="/Feltalalokgyak/logicals/crudkutato.php" style="width:80%; margin:auto;">
    <h3>Új kutató / Módosítás</h3>
    
    <input type="hidden" id="Fkod" name="fkod" value="">

    <label>Név:</label>
    <input type="text" id="Nev" name="nev" required>

    <label>Született:</label>
    <input type="number" id="Szul" name="szul">

    <label>Meghal:</label>
    <input type="number" id="Meghal" name="meghal">

    <button type="submit" name="add" id="SubmitBtn">Hozzáadás</button>
</form>

<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Név</th>
        <th>Születés</th>
        <th>Halál</th>
        <th>Művelet</th>
    </tr>
    <tbody id="Results"></tbody>
</table>

</body>
</html>

<script>
    const Api = '/Feltalalokgyak/logicals/crudkutato.php'; 
    const NevInput = document.getElementById("Nev");
    const SzulInput = document.getElementById("Szul");
    const MeghalInput = document.getElementById("Meghal");
    const FkodInput = document.getElementById("Fkod");
    const SubmitBtn = document.getElementById("SubmitBtn");

    function CreateFunctions(RecordData) {
        const Cell = document.createElement('td');
        
        // ===== TÖRLÉS GOMB =====
        const Removebtn = document.createElement('button');
        Removebtn.textContent = "Törlés";
        Removebtn.classList.add("delete-btn");
        Removebtn.style.marginRight = "5px";

        Removebtn.addEventListener('click', () => {
            if(confirm("Biztosan törlöd?")) {
                fetch(Api, {
                    method: "DELETE",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: RecordData.fkod })
                })
                .then(res => res.json())
                .then(result => {
                    if(result.Hiba) alert("Hiba: " + result.Hiba);
                    else GetData();
                });
            }
        });

        // ===== SZERKESZTÉS GOMB =====
        const Updatebtn = document.createElement('button');
        Updatebtn.textContent = "Szerkesztés";
        Updatebtn.classList.add("edit-btn");

        Updatebtn.addEventListener('click', () => {
            document.getElementById("Fkod").value = RecordData.fkod;
            document.getElementById("Nev").value = RecordData.nev;
            document.getElementById("Szul").value = RecordData.szul;
            document.getElementById("Meghal").value = RecordData.meghal;

            document.getElementById("SubmitBtn").textContent = "Módosítás mentése";

            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        Cell.appendChild(Removebtn);
        Cell.appendChild(Updatebtn);
        return Cell;
    }

    function GetData() {
        const ResponseArea = document.getElementById('Results');
        ResponseArea.innerHTML = ""; 

        fetch(Api)
        .then(res => res.json())
        .then(data => {
            if (data.Hiba) {
                console.error("Szerver hiba:", data.Hiba);
                return;
            }

            if(data.Kutatok) {
                data.Kutatok.forEach(inventor => {
                    const Row = document.createElement('tr');

                    Row.innerHTML = `
                        <td>${inventor.fkod}</td>
                        <td>${inventor.nev}</td>
                        <td>${inventor.szul}</td>
                        <td>${inventor.meghal}</td>
                    `;

                    Row.appendChild(CreateFunctions(inventor));
                    ResponseArea.appendChild(Row);
                });
            }
        })
        .catch(err => console.error("Hiba a lekérésnél:", err));
    }

    document.addEventListener("DOMContentLoaded", GetData);

    const params = new URLSearchParams(window.location.search);

    //errorok frontend része
    const error = params.get("error");

    if (error) {
        let message = "";

        switch (error) {
            case "nev_hiany":
                message = "A név megadása kötelező!";
                break;

            case "szul_format":
                message = "A születési évnek pontosan 4 számjegyűnek kell lennie!";
                break;

            case "meghal_format":
                message = "A halálozási évnek pontosan 4 számjegyűnek kell lennie!";
                break;

            case "ev_logika":
                message = "A születési év nem lehet nagyobb, mint a halálozási év!";
                break;

            case "adatbazis":
                message = "Adatbázis hiba történt!";
                break;
        }

        if (message !== "") {
            alert(message);

            window.history.replaceState(
                {},
                document.title,
                "/Feltalalokgyak/index.php?crud"
            );
        }
    }
</script>

<?php ?>