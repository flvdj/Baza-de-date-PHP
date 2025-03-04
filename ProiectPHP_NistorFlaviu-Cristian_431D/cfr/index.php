<?php
// Conexiune la baza de date
$db_server = "localhost";
$db_user = "root";
$db_pass = "12345678";
$db_name = "cfr";

$pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);

// Funcție pentru afișarea datelor dintr-o tabelă
function fetchTable($pdo, $table) {
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Funcție pentru adăugare, actualizare și ștergere
function executeQuery($pdo, $query, $params) {
    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}




// Handlere pentru cererile POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // BranchCFR
    if (isset($_POST['add_branch'])) {
        $phone = $_POST['phone'];
        if (!ctype_digit($phone)) {
            echo "<script>alert('Error: Phone must contain only numbers.');</script>";
            exit;
        }
        $query = "INSERT INTO branchcfr (name, city, address, phone, site) VALUES (?, ?, ?, ?, ?)";
        executeQuery($pdo, $query, [$_POST['name'], $_POST['city'], $_POST['address'], $_POST['phone'], $_POST['site']]);
    }

    if (isset($_POST['update_branch'])) {
        $phone = $_POST['phone'];
        if (!ctype_digit($phone)) {
            echo "<script>alert('Error: Phone must contain only numbers.');</script>";
            exit;
        }
        $query = "UPDATE branchcfr SET name = ?, city = ?, address = ?, phone = ?, site = ? WHERE idbranchcfr = ?";
        executeQuery($pdo, $query, [$_POST['name'], $_POST['city'], $_POST['address'], $_POST['phone'], $_POST['site'], $_POST['idbranchcfr']]);
    }

    if (isset($_POST['delete_branch'])) {
        $query = "DELETE FROM branchcfr WHERE idbranchcfr = ?";
        executeQuery($pdo, $query, [$_POST['idbranchcfr']]);
    }

    // Travellers
    if (isset($_POST['add_traveller'])) {
        $cnp = $_POST['cnp'];
        if (!ctype_digit($cnp)) {
            echo "<script>alert('Error: CNP must contain only numbers.');</script>";
            exit;
        }
        $phonenumber = $_POST['phonenumber'];
        if (!ctype_digit($phonenumber)) {
            echo "<script>alert('Error: Phone must contain only numbers.');</script>";
            exit;
        }
        $query = "INSERT INTO travellers (name, surname, cnp, phonenumber, city) VALUES (?, ?, ?, ?, ?)";
        executeQuery($pdo, $query, [$_POST['name'], $_POST['surname'], $_POST['cnp'], $_POST['phonenumber'], $_POST['city']]);
    }

    if (isset($_POST['update_traveller'])) {
        $cnp = $_POST['cnp'];
        if (!ctype_digit($cnp)) {
            echo "<script>alert('Error: CNP must contain only numbers.');</script>";
            exit;
        }
        $phonenumber = $_POST['phonenumber'];
        if (!ctype_digit($phonenumber)) {
            echo "<script>alert('Error: Phone must contain only numbers.');</script>";
            exit;
        }
        $query = "UPDATE travellers SET name = ?, surname = ?, cnp = ?, phonenumber = ?, city =? WHERE id_travellers = ?";
        executeQuery($pdo, $query, [$_POST['name'], $_POST['surname'], $_POST['cnp'], $_POST['phonenumber'], $_POST['city'], $_POST['id_travellers']]);
    }

    if (isset($_POST['delete_traveller'])) {
        $query = "DELETE FROM travellers WHERE id_travellers = ?";
        executeQuery($pdo, $query, [$_POST['id_travellers']]);
    }
    // Journey
    if (isset($_POST['add_journey'])) {
        $hour = $_POST['hour'];
        if (!ctype_digit($hour)) {
            echo "<script>alert('Error: Hour must contain only numbers.');</script>";
            exit;
        }
        $clasa = $_POST['clasa'];
        if (!ctype_digit($clasa)) {
            echo "<script>alert('Error: Class must contain only numbers.');</script>";
            exit;
        }
        $query = "INSERT INTO journey (date, hour, ticket, clasa, start, destination, idbranchcfr, id_travellers) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        executeQuery($pdo, $query, [
            $_POST['date'], $_POST['hour'], $_POST['ticket'], $_POST['clasa'], $_POST['start'], 
            $_POST['destination'], $_POST['idbranchcfr'], $_POST['id_travellers']
        ]);
    }

    if (isset($_POST['update_journey'])) {
        $hour = $_POST['hour'];
        if (!ctype_digit($hour)) {
            echo "<script>alert('Error: Hour must contain only numbers.');</script>";
            exit;
        }
        $clasa = $_POST['clasa'];
        if (!ctype_digit($clasa)) {
            echo "<script>alert('Error: Class must contain only numbers.');</script>";
            exit;
        }
        $query = "UPDATE journey SET date = ?, hour = ?, ticket = ?, clasa = ?, start = ?, destination = ?, idbranchcfr = ?, id_travellers = ? WHERE idjourney = ?";
        executeQuery($pdo, $query, [
            $_POST['date'], $_POST['hour'], $_POST['ticket'], $_POST['clasa'], $_POST['start'], 
            $_POST['destination'], $_POST['idbranchcfr'], $_POST['id_travellers'], $_POST['idjourney']
        ]);
    }

    if (isset($_POST['delete_journey'])) {
        $query = "DELETE FROM journey WHERE idjourney = ?";
        executeQuery($pdo, $query, [$_POST['idjourney']]);
    }


    // Redirect pentru a preveni re-submit-ul la refresh
    if (isset($_POST['add_branch']) || isset($_POST['update_branch']) || isset($_POST['delete_branch'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=branchcfr");
    } elseif (isset($_POST['add_traveller']) || isset($_POST['update_traveller']) || isset($_POST['delete_traveller'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=travellers");
    } elseif(isset($_POST['add_journey']) || isset($_POST['update_journey']) || isset($_POST['delete_journey'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=journey");
    exit;
    }
}



// Determină ce pagină să afișeze
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travellers CFR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgb(248, 202, 202), rgb(0, 0, 0));
            color: #fff;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        h1 {
            color: rgb(14, 1, 253);
            margin-bottom: 40px;
        }
        .btn-vibrant {
            background-color: #6c63ff;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 18px;
            margin: 10px;
        }
        .btn-vibrant:hover {
            background-color: #5a54d4;
        }
        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: #fff;
            color: #333;
            margin: 20px;
        }
    </style>
</head>
<body>
    <?php if ($page === 'home'): ?>
        <!-- Interfața principală -->
        <h1>Travellers CFR</h1>
        <div>
            <a href="?page=travellers" class="btn btn-vibrant">Travellers</a>
            <a href="?page=journey" class="btn btn-vibrant">Journey</a>
            <a href="?page=branchcfr" class="btn btn-vibrant">BranchCFR</a>
        </div>
    <?php elseif ($page === 'branchcfr'): ?>
        <!-- Interfața BranchCFR -->
        <div class="container mt-5">
            <h1 class="text-center mb-4" style="color:rgb(14, 1, 253);">BranchCFR Management</h1>
            <div class="text-center mb-4">
    <a href="index.php" class="btn btn-vibrant">Home</a>
</div>

            <div class="table-responsive">
                <h3 class="text-secondary">BranchCFR</h3>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Site</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $branches = fetchTable($pdo, 'branchcfr');
                    foreach ($branches as $branch): ?>
                        <tr>
                            <td><?= $branch['idbranchcfr'] ?></td>
                            <td><?= $branch['name'] ?></td>
                            <td><?= $branch['city'] ?></td>
                            <td><?= $branch['address'] ?></td>
                            <td><?= $branch['phone'] ?></td>
                            <td><?= $branch['site'] ?></td>
                            <td>
                                <!-- Form pentru ștergere -->
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="idbranchcfr" value="<?= $branch['idbranchcfr'] ?>">
                                    <button type="submit" name="delete_branch" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <!-- Form pentru actualizare -->
                                <button class="btn btn-warning btn-sm" onclick="populateUpdateForm(<?= htmlspecialchars(json_encode($branch)) ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3 class="text-secondary">Add a new Branch</h3>
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col">
                            <input type="text" name="city" class="form-control" placeholder="City" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="address" class="form-control" placeholder="Address" required>
                        </div>
                        <div class="col">
                            <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="site" class="form-control" placeholder="Site" required>
                        </div>
                    </div>
                    <button type="submit" name="add_branch" class="btn btn-vibrant">Add</button>
                </form>
            </div>
            <div class="card p-4 mt-4" id="update-form" style="display: none;">
    <h3 class="text-secondary">Update Branch</h3>
    <form method="POST">
        <input type="hidden" name="idbranchcfr" id="update-id">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="name" id="update-name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col">
                <input type="text" name="city" id="update-city" class="form-control" placeholder="City" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="address" id="update-address" class="form-control" placeholder="Address" required>
            </div>
            <div class="col">
                <input type="text" name="phone" id="update-phone" class="form-control" placeholder="Phone" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="site" id="update-site" class="form-control" placeholder="Site" required>
            </div>
        </div>
        <button type="submit" name="update_branch" class="btn btn-vibrant">Update</button>
    </form>
</div>

        </div>

        <script>
            function populateUpdateForm(branch) {
                document.getElementById('update-id').value = branch.idbranchcfr;
                document.getElementById('update-name').value = branch.name;
                document.getElementById('update-city').value = branch.city;
                document.getElementById('update-address').value = branch.address;
                document.getElementById('update-phone').value = branch.phone;
                document.getElementById('update-site').value = branch.site;
                document.getElementById('update-form').style.display = 'block';
            }
        </script>
        <script>
    function populateUpdateForm(branch) {
        // Populează câmpurile formularului de actualizare
        document.getElementById('update-id').value = branch.idbranchcfr;
        document.getElementById('update-name').value = branch.name;
        document.getElementById('update-city').value = branch.city;
        document.getElementById('update-address').value = branch.address;
        document.getElementById('update-phone').value = branch.phone;
        document.getElementById('update-site').value = branch.site;

        // Afișează formularul de actualizare
        document.getElementById('update-form').style.display = 'block';

        // Derulează pagina la formularul de actualizare
        document.getElementById('update-form').scrollIntoView({ behavior: 'smooth' });
    }
</script>

    
    <?php elseif ($page === 'travellers'): ?>
    <!-- Interfața Travellers -->
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color:rgb(253, 110, 14);">Travellers Management</h1>
        
        <!-- Tabelul Travellers -->
        <div class="table-responsive">
            <h3 class="text-secondary">Travellers</h3>
            <div class="text-center mb-4">
    <a href="index.php" class="btn btn-vibrant">Home</a>
</div>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>CNP</th>
                        <th>Phone Number</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $travellers = fetchTable($pdo, 'travellers');
                foreach ($travellers as $traveller): ?>
                    <tr>
                        <td><?= $traveller['id_travellers'] ?></td>
                        <td><?= $traveller['name'] ?></td>
                        <td><?= $traveller['surname'] ?></td>
                        <td><?= $traveller['cnp'] ?></td>
                        <td><?= $traveller['phonenumber'] ?></td>
                        <td><?= $traveller['city'] ?></td>
                        <td>
                            <!-- Formular pentru ștergere -->
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="id_travellers" value="<?= $traveller['id_travellers'] ?>">
                                <button type="submit" name="delete_traveller" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <!-- Buton pentru actualizare -->
                            <button class="btn btn-warning btn-sm" onclick="populateTravellerUpdateForm(<?= htmlspecialchars(json_encode($traveller)) ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formular pentru adăugare Travellers -->
        <div class="card">
            <h3 class="text-secondary">Add a new Traveller</h3>
            <form method="POST">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col">
                        <input type="text" name="surname" class="form-control" placeholder="Surname" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="cnp" class="form-control" placeholder="CNP" required
                        >
                    </div>
                    <div class="col">
                        <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number" required
                        >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="city" class="form-control" placeholder="City" required>
                    </div>
                </div>
                <button type="submit" name="add_traveller" class="btn btn-vibrant">Add</button>
            </form>
        </div>

        <!-- Formular pentru actualizare Travellers -->
        <div class="card p-4 mt-4" id="traveller-update-form" style="display: none;">
            <h3 class="text-secondary">Update Traveller</h3>
            <form method="POST">
                <input type="hidden" name="id_travellers" id="traveller-id">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="name" id="traveller-name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col">
                        <input type="text" name="surname" id="traveller-surname" class="form-control" placeholder="Surname" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="cnp" id="traveller-cnp" class="form-control" placeholder="CNP" required>
                    </div>
                    <div class="col">
                        <input type="text" name="phonenumber" id="traveller-phone" class="form-control" placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="city" id="traveller-city" class="form-control" placeholder="City" required>
                    </div>
                </div>
                <button type="submit" name="update_traveller" class="btn btn-warning">Update</button>
            </form>
        </div>
    </div>
    <script>
    function populateTravellerUpdateForm(traveller) {
        // Populează câmpurile formularului de actualizare
        document.getElementById('traveller-id').value = traveller.id_travellers;
        document.getElementById('traveller-name').value = traveller.name;
        document.getElementById('traveller-surname').value = traveller.surname;
        document.getElementById('traveller-cnp').value = traveller.cnp;
        document.getElementById('traveller-phone').value = traveller.phonenumber;
        document.getElementById('traveller-city').value = traveller.city;

        // Afișează formularul de actualizare
        document.getElementById('traveller-update-form').style.display = 'block';

        // Derulează pagina la formularul de actualizare
        document.getElementById('traveller-update-form').scrollIntoView({ behavior: 'smooth' });
    }
</script>

<?php elseif ($page === 'journey'): ?>
    <!-- Interfața Journey -->
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color:rgb(14, 1, 253);">Journey Management</h1>

        <div class="text-center mb-4">
    <a href="index.php" class="btn btn-vibrant">Home</a>
</div>

        
        <!-- Tabelul Journey -->
        <div class="table-responsive">
            <h3 class="text-secondary">Journeys</h3>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Hour</th>
                        <th>Ticket</th>
                        <th>Class</th>
                        <th>Start</th>
                        <th>Destination</th>
                        <th>BranchCFR</th>
                        <th>Traveller</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $journeys = fetchTable($pdo, 'journey');
                    $branches = [];
                    foreach (fetchTable($pdo, 'branchcfr') as $branch) {
                    $branches[$branch['idbranchcfr']] = $branch;
                            }

                            $travellers = [];
                    foreach (fetchTable($pdo, 'travellers') as $traveller) {
                    $travellers[$traveller['id_travellers']] = $traveller;
                    }

                    foreach ($journeys as $journey):
                        $branch = isset($branches[$journey['idbranchcfr']]) ? $branches[$journey['idbranchcfr']] : null;
                        $traveller = isset($travellers[$journey['id_travellers']]) ? $travellers[$journey['id_travellers']] : null;

                    ?>
                        <tr>
                            <td><?= $journey['idjourney'] ?></td>
                            <td><?= $journey['date'] ?></td>
                            <td><?= $journey['hour'] ?></td>
                            <td><?= $journey['ticket'] ?></td>
                            <td><?= $journey['clasa'] ?></td>
                            <td><?= $journey['start'] ?></td>
                            <td><?= $journey['destination'] ?></td>
                            <td><?= $branch['name'] ?></td>
                            <td><?= $traveller['name'] . ' ' . $traveller['surname'] ?></td>
                            <td>
                                <!-- Form pentru ștergere -->
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="idjourney" value="<?= $journey['idjourney'] ?>">
                                    <button type="submit" name="delete_journey" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <!-- Buton pentru actualizare -->
                                <button class="btn btn-warning btn-sm" onclick="populateJourneyUpdateForm(<?= htmlspecialchars(json_encode($journey)) ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formular pentru adăugare Journey -->
        <div class="card">
            <h3 class="text-secondary">Add a new Journey</h3>
            <form method="POST">
                <div class="row mb-3">
                    <div class="col">
                        <input type="date" name="date" class="form-control" placeholder="Date" required>
                    </div>
                    <div class="col">
                        <input type="text" name="hour" class="form-control" placeholder="Hour" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="ticket" class="form-control" placeholder="Ticket" required>
                    </div>
                    <div class="col">
                        <input type="number" name="clasa" class="form-control" placeholder="Class" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="start" class="form-control" placeholder="Start" required>
                    </div>
                    <div class="col">
                        <input type="text" name="destination" class="form-control" placeholder="Destination" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <select name="idbranchcfr" class="form-control" required>
                            <option value="">Select Branch</option>
                            <?php
                            $branches = fetchTable($pdo, 'branchcfr');
                            foreach ($branches as $branch):
                            ?>
                                <option value="<?= $branch['idbranchcfr'] ?>"><?= $branch['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <select name="id_travellers" class="form-control" required>
                            <option value="">Select Traveller</option>
                            <?php
                            $travellers = fetchTable($pdo, 'travellers');
                            foreach ($travellers as $traveller):
                            ?>
                                <option value="<?= $traveller['id_travellers'] ?>"><?= $traveller['name'] . ' ' . $traveller['surname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="add_journey" class="btn btn-vibrant">Add</button>
            </form>
        </div>
    </div>
    <!-- Formular pentru actualizare Journey -->
<div class="card p-4 mt-4" id="journey-update-form" style="display: none;">
    <h3 class="text-secondary">Update Journey</h3>
    <form method="POST">
        <input type="hidden" name="idjourney" id="journey-id">

        <div class="row mb-3">
            <div class="col">
                <input type="date" name="date" id="journey-date" class="form-control" placeholder="Date" required>
            </div>
            <div class="col">
                <input type="number" name="hour" id="journey-hour" class="form-control" placeholder="Hour" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="ticket" id="journey-ticket" class="form-control" placeholder="Ticket" required>
            </div>
            <div class="col">
                <input type="number" name="clasa" id="journey-clasa" class="form-control" placeholder="Class" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="start" id="journey-start" class="form-control" placeholder="Start" required>
            </div>
            <div class="col">
                <input type="text" name="destination" id="journey-destination" class="form-control" placeholder="Destination" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <select name="idbranchcfr" id="journey-branch" class="form-control" required>
                    <option value="">Select BranchCFR</option>
                    <?php
                    foreach ($branches as $branch) {
                        $selected = ($branch['idbranchcfr'] == $journey['idbranchcfr']) ? 'selected' : '';
                        echo "<option value='{$branch['idbranchcfr']}' $selected>{$branch['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <select name="id_travellers" id="journey-traveller" class="form-control" required>
                    <option value="">Select Traveller</option>
                    <?php
                    foreach ($travellers as $traveller) {
                        $selected = ($traveller['id_travellers'] == $journey['id_travellers']) ? 'selected' : '';
                        echo "<option value='{$traveller['id_travellers']}' $selected>{$traveller['name']} {$traveller['surname']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <button type="submit" name="update_journey" class="btn btn-warning">Update</button>
    </form>
</div>

<script>
function populateJourneyUpdateForm(journey) {
    // Populează câmpurile formularului de actualizare
    document.getElementById('journey-id').value = journey.idjourney;
    document.getElementById('journey-date').value = journey.date;
    document.getElementById('journey-hour').value = journey.hour;
    document.getElementById('journey-ticket').value = journey.ticket;
    document.getElementById('journey-clasa').value = journey.clasa;
    document.getElementById('journey-start').value = journey.start;
    document.getElementById('journey-destination').value = journey.destination;
    document.getElementById('journey-branch').value = journey.idbranchcfr;
    document.getElementById('journey-traveller').value = journey.id_travellers;

    // Afișează formularul de actualizare
    document.getElementById('journey-update-form').style.display = 'block';

    // Derulează pagina la formularul de actualizare
    document.getElementById('journey-update-form').scrollIntoView({ behavior: 'smooth' });
}
</script>
                        
<?php endif; ?>
                            
</body>
</html>
                            