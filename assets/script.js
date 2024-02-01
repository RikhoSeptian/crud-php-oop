// Get the search box and table body elements
const searchBox = document.getElementById('search-box');
const tableBody = document.getElementById('table-body');

// Set up an event listener for the search box input
searchBox.addEventListener('input', () => {
    // Get the search query from the input field
    const searchQuery = searchBox.value.trim().toLowerCase();

    // Loop through the table rows and hide/show them based on the search query
    for (const row of tableBody.rows) {
        const cells = row.cells;
        const showRow = cells[0].textContent.toLowerCase().includes(searchQuery) || cells[1].textContent.toLowerCase().includes(searchQuery) || cells[2].textContent.toLowerCase().includes(searchQuery);
        row.style.display = showRow ? '' : 'none';
    }
});

// Generate some sample data for the table
const data = [];

// Insert the table data into the table body
for (const rowData of data) {
    const row = tableBody.insertRow();
    for (const cellData of rowData) {
        const cell = row.insertCell();
        cell.textContent = cellData;
    }
}

// modal
// Get the add button, modal, and form elements
const addButton = document.getElementById('add-button');
const modal = document.getElementById('modal');

// Set up an event listener for the add button
addButton.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Set up an event listener for the close button
const closeButton = document.querySelector('.modal .close');
closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});
