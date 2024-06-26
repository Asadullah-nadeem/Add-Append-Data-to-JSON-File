<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Append Data to JSON File</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.3/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
      body {
        font-family: 'Open Sans', sans-serif;
      }
      .success-message {
        display: none;
        background-color: #e6fffa;
        color: #38a169;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
      }
    </style>
</head>
<body>

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-8">Add/Append Data to JSON File</h1>
  
    <div class="flex flex-col md:flex-row md:space-x-8 mb-8">
        <!-- Form to enter data -->
        <div class="w-full md:w-1/2">
            <form method="post" action="">
                <div class="mb-4">
                    <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                    <input type="text" id="id" name="id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="firstname" class="block text-sm font-medium text-gray-700">Firstname</label>
                    <input type="text" id="firstname" name="firstname" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Lastname</label>
                    <input type="text" id="lastname" name="lastname" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="address" name="address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-6">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <input type="text" id="gender" name="gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" name="add-button" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline">Add</button>
            </form>
        </div>
        <!-- Table to show data -->
        <div class="w-full md:w-1/2">
            <table class="table-auto w-full text-left border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Firstname</th>
                        <th class="border border-gray-300 px-4 py-2">Lastname</th>
                        <th class="border border-gray-300 px-4 py-2">Address</th>
                        <th class="border border-gray-300 px-4 py-2">Gender</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    <!-- Data will be appended here -->
                </tbody>
            </table>
        </div>
    </div>
  
    <!-- Success message box -->
    <div class="success-message" id="success-message">
        Data successfully appended
    </div>

</div>

<?php
// This will hold our table data
$tableData = json_decode(file_get_contents('tableData.json'), true) ?: [];

// Function to update the table
function updateTable($tableData) {
    $dataTable = '';
    foreach ($tableData as $rowData) {
        $dataTable .= '<tr>';
        $dataTable .= '<td class="border border-gray-300 px-4 py-2">' . $rowData['id'] . '</td>';
        $dataTable .= '<td class="border border-gray-300 px-4 py-2">' . $rowData['firstname'] . '</td>';
        $dataTable .= '<td class="border border-gray-300 px-4 py-2">' . $rowData['lastname'] . '</td>';
        $dataTable .= '<td class="border border-gray-300 px-4 py-2">' . $rowData['address'] . '</td>';
        $dataTable .= '<td class="border border-gray-300 px-4 py-2">' . $rowData['gender'] . '</td>';
        $dataTable .= '</tr>';
    }
    return $dataTable;
}

// Initial table update
echo updateTable($tableData);

// Function to add data to table and local storage
function addData() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-button'])) {
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];

        if ($id && $firstname && $lastname && $address && $gender) {
            $newData = ['id' => $id, 'firstname' => $firstname, 'lastname' => $lastname, 'address' => $address, 'gender' => $gender];
            $tableData = json_decode(file_get_contents('tableData.json'), true) ?: [];
            $tableData[] = $newData;
            file_put_contents('tableData.json', json_encode($tableData));
            echo updateTable($tableData);
            // Show success message
            echo '<script>document.getElementById("success-message").style.display = "block"; setTimeout(() => { document.getElementById("success-message").style.display = "none"; }, 3000);</script>';
        }
    }
}

// Add data
addData();
?>

</body>
</html>
