<?php
// Include database connection
require_once 'db_connection.php';

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get current user ID
$current_user_id = $_SESSION['user_id'];

// Query to retrieve followers of the current user
$query = "SELECT u.user_id, u.username, u.email
          FROM users u
          JOIN follows f ON u.user_id = f.follower_id
          WHERE f.followed_user_id = $current_user_id";

$result = mysqli_query($conn, $query);

// Check if any followers found
if (mysqli_num_rows($result) > 0) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Followers</title>
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="img/fav.png" />
        <!-- Author Meta -->
        <meta name="author" content="colorlib" />
        <!-- Meta Description -->
        <meta name="description" content="" />
        <!-- Meta Keyword -->
        <meta name="keywords" content="" />
        <!-- meta character set -->
        <meta charset="UTF-8" />
        <!-- Site Title -->
        <title>Contacts</title>


        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
        <!-- CSS -->
        <link rel="stylesheet" href="css/linearicons.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/magnific-popup.css" />
        <link rel="stylesheet" href="css/owl.carousel.css" />
        <link rel="stylesheet" href="css/nice-select.css">
        <link rel="stylesheet" href="css/hexagons.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
        <link rel="stylesheet" href="css/main.css" />
        <!-- Add your CSS links here -->
        <style>
            table {
                width: 100%;
                /* Adjust the width of the table here */
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>

        <section class="banner-area">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-12 banner-right">
                        <h1 class="text-white">My Followers</h1>
                        <p class="mx-auto text-white mt-20 mb-40">Here you can manage your notes.</p>
                        <div class="link-nav">
                            <span class="box">
                                <a href="dashboard.php">Home </a>
                                <i class="lnr lnr-arrow-right"></i>
                                <a href="manage_notes.php">Manage Notes</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-page-area section-gap">
            <div class="container">
                <h1>Your Followers</h1>
                <br>
                <div style="margin: 0 auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Visit Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td><a href='user_profile.php?user_id=" . $row['user_id'] . "'>Visit Profile</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <?php include('footer.php'); ?>
    </body>

    </html>
<?php
} else {
    // No followers found
    echo "You don't have any followers.";
}
?>