<?php
include 'db.php'; // Database connection

// Fetch categories from database
$sql = "SELECT * FROM job_categories";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Categories - CV Builder</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eef2f7;
            text-align: center;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        /* Heading */
        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        /* Grid Layout */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        /* Category Box */
        .category-box {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            color: #fff;
            text-align: center;
        }

        .category-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
        }

        /* Category Title */
        .category-box h3 {
            font-size: 1.6rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Description */
        .category-box p {
            font-size: 1rem;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <h1>Select a Job Sector</h1>
    <div class="container">
        <div class="category-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="category-box" onclick="redirectToTemplates('<?php echo $row['category_name']; ?>')">
                    <h3><?php echo $row['category_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function redirectToTemplates(category) {
            window.location.href = "cv_templates.php?category=" + encodeURIComponent(category);
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>