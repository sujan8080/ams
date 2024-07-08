<?php
require_once ('../students/StudentManager.php');

$studentManager = new StudentManager();
$response = $studentManager->studentList();
$responseDecode = json_decode($response, true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn.edit {
            background-color: #28a745;
        }

        .btn.delete {
            background-color: #dc3545;
        }


        /* skdjfh;kshjfd;kjl */

        <style>body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .order-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .order-list th,
        .order-list td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            white-space: nowrap;
        }

        .order-list th {
            background-color: #f9f9f9;
        }

        .order-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-list img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .details-link {
            color: #007BFF;
            text-decoration: none;
        }

        .details-link:hover {
            text-decoration: underline;
        }

        .editDeliveryStatus {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: wrap;
        }

        tbody,
        tr,
        td {
            height: 58px;
        }

        .edit-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 5px;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .dropdown {
            display: none;
            margin-left: 10px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .dropdown option {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }

        .dropdown option:hover {
            background-color: #f1f1f1;
        }

        .dropdown.show {
            display: inline-block;
        }

        @media (max-width: 768px) {
            .editDeliveryStatus {
                flex-direction: column;
            }

            .order-list th,
            .order-list td {
                white-space: normal;
            }

            .edit-button {
                margin: 5px 0;
            }
        }
    </style>
    </style>
</head>

<body>
    <?php require_once ('adminNavigation.php'); ?>

    <h1>Students List</h1>
    <table>
        <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($responseDecode) && isset($responseDecode['success']) == true) {
                foreach ($responseDecode['data'] as $student) {
                    ?>
                    <tr>
                        <td><?= $student['student_fullname']; ?></td>
                        <td><?= $student['student_email']; ?></td>
                        <td><?= $student['course_name']; ?></td>

                        <td class="editDeliveryStatus">
                            <?= isset($student['is_admission_verified']) ? $student['is_admission_verified'] : ''; ?>
                            <button class="edit-button" onclick="toggleDropdown(this)">Edit</button>
                            <form action="editStatus.php" method="POST" style="display:inline;">
                                <input type="hidden" name="student_id"
                                    value="<?= isset($student['student_id']) ? $student['student_id'] : ''; ?>">
                                <select class="dropdown" name="is_admission_verified" onchange="this.form.submit()">
                                    <option value="">Select</option>
                                    <option value="pending">Pending</option>
                                    <option value="cancelled" <?= isset($student['is_admission_verified']) && $student['is_admission_verified'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    <option value="approved" <?= isset($student['is_admission_verified']) && $student['is_admission_verified'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                </select>
                            </form>


                        </td>
                        <td>
                            <!-- <a href="editStudent.php?student_id=<?= $student['student_id']; ?>">Edit</a> -->
                            <a href="deleteStudent.php?student_id=<?= $student['student_id']; ?>"
                                onclick="return confirmDelete()">Delete</a>
                        </td>
                        </td>

                    </tr>
                <?php }
            } else {
                echo "No Students";
            } ?>
        </tbody>
    </table>

    <script>
        // function editStudent(id) {
        //     // Redirect to edit page
        //     window.location.href = 'edit.php?id=' + id;
        // }

        // function deleteStudent(id) {
        //     if (confirm('Are you sure you want to delete this record?')) {
        //         window.location.href = 'delete.php?id=' + id;
        //     }
        // }

        function toggleDropdown(button) {
            var dropdown = button.nextElementSibling.querySelector('.dropdown');
            dropdown.classList.toggle("show");
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this student?");
        }

    </script>

</body>

</html>