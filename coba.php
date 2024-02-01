<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        button {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            /* height: 100%; */
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 150px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            /* width: 50%; */
            box-sizing: border-box;
        }

        .close {
            color: #333;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        button[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Form</h1>
    <button id="add-button">Add Data</button>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Data</h2>
            <form id="add-form">
                <label for="column1">Column 1:</label>
                <input type="text" id="column1" name="column1" required>
                <br>
                <label for="column2">Column 2:</label>
                <input type="text" id="column2" name="column2" required>
                <br>
                <label for="column3">Column 3:</label>
                <input type="text" id="column3" name="column3" required>
                <br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <script>
        // Get the add button, modal, and form elements
        const addButton = document.getElementById('add-button');
        const modal = document.getElementById('modal');
        const addForm = document.getElementById('add-form');

        // Set up an event listener for the add button
        addButton.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        // Set up an event listener for the close button
        const closeButton = document.querySelector('.modal .close');
        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Set up an event listener for the form submit event
        addForm.addEventListener('submit', (event) => {
            event.preventDefault();

            // Get the form data
            const formData = new FormData(addForm);
            const column1 = formData.get('column1');
            const column2 = formData.get('column2');
            const column3 = formData.get('column3');

            // Add the form data to the table
            const tableBody = document.getElementById('table-body');
            const row = tableBody.insertRow();
            const cell1 = row.insertCell();
            const cell2 = row.insertCell();
            const cell3 = row.insertCell();
            cell1.textContent = column1;
            cell2.textContent = column2;
            cell3.textContent = column3;

            // Reset the form
            addForm.reset();

            // Hide the modal
            modal.style.display = 'none';
        });
    </script>
</body>

</html>