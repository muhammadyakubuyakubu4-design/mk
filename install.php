<?php
// ADUHMS Database Installation Script
require_once 'config.php';

// Check if database exists, if not create it
try {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    }
    
    // Create database if it doesn't exist
    $create_db_sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if ($connection->query($create_db_sql) === TRUE) {
        echo "Database " . DB_NAME . " created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating database: " . $connection->error);
    }
    
    $connection->select_db(DB_NAME);
    
    // Read the SQL schema file
    $sql_schema = file_get_contents('database_schema.sql');
    
    // Remove the CREATE DATABASE and USE statements since we're already connected to the database
    $sql_schema = str_replace([
        "CREATE DATABASE IF NOT EXISTS aduhms;",
        "USE aduhms;"
    ], "", $sql_schema);
    
    // Split the SQL into individual statements
    $statements = array_filter(array_map('trim', explode(";\n", $sql_schema)));
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            if ($connection->query($statement) === TRUE) {
                $success_count++;
            } else {
                echo "Error executing statement: " . $connection->error . "<br>";
                echo "Statement: " . htmlspecialchars($statement) . "<br><br>";
                $error_count++;
            }
        }
    }
    
    if ($error_count == 0) {
        echo "<h3>Installation completed successfully!</h3>";
        echo "<p>Created $success_count database objects.</p>";
        echo "<p><a href='login.php' class='btn btn-success'>Go to Login Page</a></p>";
    } else {
        echo "<h3>Installation completed with $error_count errors.</h3>";
        echo "<p>Created $success_count database objects.</p>";
        echo "<p>Please check the errors above and try again.</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADUHMS Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">ADUHMS Installation</h4>
                    </div>
                    <div class="card-body">
                        <p class="alert alert-info">
                            <strong>Note:</strong> This installation script will create the database schema for ADUHMS.
                            Make sure your database credentials in <code>config.php</code> are correct.
                        </p>
                        
                        <div class="alert alert-warning">
                            <strong>Warning:</strong> This will create all necessary tables. If tables already exist, 
                            this may cause conflicts. Only run this once during initial setup.
                        </div>
                        
                        <h5>Default Credentials:</h5>
                        <ul>
                            <li><strong>Username:</strong> superadmin</li>
                            <li><strong>Password:</strong> password</li>
                            <li><strong>Role:</strong> Super Admin</li>
                        </ul>
                        
                        <p class="mt-3">
                            After installation, please change the default password immediately for security.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>