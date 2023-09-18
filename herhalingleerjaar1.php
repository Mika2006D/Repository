<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>

body {
    background-color: #60A7A5;
}
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.card {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px;
    width: 300px; 
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 30px;
}

.card p {
    margin: 0;
}


<style>
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.card {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px;
    width: calc(33.33% - 20px); 
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 30px;
}

.card p {
    margin: 0;
}

@media (max-width: 767px) {
    .card-container {
        flex-direction: column; 
    }

    .card {
        width: 100%; 
    }
}
</style>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studenten";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$order_by_lastname = isset($_GET['order_by_lastname']) ? true : false;


if ($order_by_lastname) {
    $stmt = $conn->prepare("SELECT id, naam, email, telefoonnummer FROM studentenlijst ORDER BY SUBSTRING_INDEX(naam, ' ', -1)");
} else {
    $stmt = $conn->prepare("SELECT id, naam, email, telefoonnummer FROM studentenlijst");
}


$stmt->execute();


$result = $stmt->get_result();


if ($result->num_rows > 0) {
    echo '<div class="search-container">';
    echo '<input type="text" id="search-input" placeholder="Search for a student">';
    echo '</div>';

    echo '<div class="card-container">';

   
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card" data-id="' . $row["id"] . '">';
        echo "<p><strong>ID:</strong> " . $row["id"] . "</p>";
        echo "<p><strong>Name:</strong> " . $row["naam"] . "</p>";
        echo '<div class="details">';
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Phone:</strong> " . $row["telefoonnummer"] . "</p>";
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
} else {
    echo "No records found.";
}


$conn->close();
?>


<div id="details-container">
    <div id="details-content">
      
    </div>
</div>

<style>
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.card {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px;
    width: calc(33.33% - 20px); 
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.card p {
    margin: 0;
}

.details {
    display: none;
}



@media (max-width: 767px) {
    .card-container {
        flex-direction: column; 
    }

    .card {
        width: 100%;
    }
}

.search-container {
    text-align: center;
    margin-bottom: 20px;
}

#search-input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
}
</style>
<script>

const cardContainer = document.querySelector('.card-container');
const detailsContainer = document.getElementById('details-container');
const detailsContent = document.getElementById('details-content');
const searchInput = document.getElementById('search-input');

cardContainer.addEventListener('click', (event) => {
    const card = event.target.closest('.card');
    if (!card) return; 

    const details = card.querySelector('.details');
    if (details) {
        details.style.display = details.style.display === 'none' ? 'block' : 'none';
    }
});

document.addEventListener('click', (event) => {
    if (!detailsContainer.contains(event.target)) {
        detailsContainer.style.display = 'none';
    }
});

searchInput.addEventListener('input', () => {
    const searchQuery = searchInput.value.toLowerCase();
    const cards = document.querySelectorAll('.card');

    cards.forEach((card) => {
        const name = card.querySelector('p:nth-child(2)').textContent.toLowerCase();
        if (name.includes(searchQuery)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
document.getElementById("order-button").addEventListener("click", function () {
    // Reload the page with the ordering parameter
    window.location.href = "your-php-script.php?order_by_lastname=1";
});
</script>
</body>
</html>
