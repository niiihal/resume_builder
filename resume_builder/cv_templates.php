<?php
include 'db.php'; // Database connection

// Get the category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch templates based on the selected category
$sql = "SELECT * FROM cv_templates WHERE category_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $category);
$stmt->execute();
$result = $stmt->get_result();

// Handle the form submission to add a new template
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name']; // The selected category
    $template_name = $_POST['template_name']; // Template name
    $template_content = $_POST['template_content']; // Template content

    // Insert the new template into the database
    $sql_insert = "INSERT INTO cv_templates (category_name, template_name, template_content) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('sss', $category_name, $template_name, $template_content);
    $stmt_insert->execute();
    $stmt_insert->close();

    echo "<script>alert('Template added successfully!');</script>"; // Optional: Alert for success
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Templates - <?php echo htmlspecialchars($category); ?> | CV Builder</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            color: #333;
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
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: #2c3e50;
            text-align: center;
        }

        /* Grid Layout */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        /* Category Box */
        .category-box {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            color: #fff;
            text-align: center;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .category-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .category-box h3 {
            font-size: 1.7rem;
            margin-bottom: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .category-box p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .category-box a button {
            background-color: #fff;
            color: #3498db;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-transform: uppercase;
        }

        .category-box a button:hover {
            background-color: #3498db;
            color: #fff;
        }

        /* Form Styles */
        .form-container {
            margin-top: 60px;
            background-color: #fff;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .form-container h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #34495e;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-container input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 15px;
            border-radius: 6px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .category-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .category-box {
                padding: 20px;
            }

            .category-box h3 {
                font-size: 1.4rem;
            }

            .category-box p {
                font-size: 1rem;
            }

            .form-container {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <h1>Choose a CV Template for <?php echo htmlspecialchars($category); ?></h1>
    <div class="container">
        <!-- Add Template Form -->
        <div class="form-container">
            <h2>Add New Template</h2>
            <form method="POST" action="">
                <input type="hidden" name="category_name" value="<?php echo htmlspecialchars($category); ?>">

                <label for="template_name">Template Name:</label>
                <input type="text" name="template_name" id="template_name" required>

                <label for="template_content">Template Content:</label>
                <textarea name="template_content" id="template_content" rows="6" required></textarea>

                <input type="submit" value="Add Template">
            </form>
        </div>

        <!-- Display Existing Templates -->
        <h2>Existing Templates</h2>
        <div class="category-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="category-box">
                    <h3><?php echo $row['template_name']; ?></h3>
                    <p><?php echo $row['template_content']; ?></p>
                    <a href="template_editor.php?template_id=<?php echo $row['id']; ?>">
                        <button>View Template</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>