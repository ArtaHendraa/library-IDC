<x-app-layout>
    <div class="flex flex-col items-center justify-center gap-5">
        <!-- Display Books -->
        <div id="bookList" class="w-3/4 mt-5">
            <h3 class="text-lg font-bold">Book List</h3>
            <table class="w-full mt-3 table-auto">
                <thead>
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Title</th>
                        <th class="p-2 border">Author</th>
                        <th class="p-2 border">Description</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="bookTableBody">
                    <!-- Dynamic Data will be inserted here -->
                </tbody>
            </table>

            <!-- Pagination Buttons -->
            <div id="pagination" class="flex justify-center gap-4 mt-4">
                <button id="prevPage" class="px-4 py-2 text-white bg-gray-400 rounded-md" disabled>Previous</button>
                <button id="nextPage" class="px-4 py-2 text-white bg-gray-400 rounded-md" disabled>Next</button>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-500 bg-opacity-50">
        <div class="w-1/3 p-6 bg-white rounded-md">
            <h3 class="mb-4 text-lg font-bold">Edit Book</h3>
            <form id="editForm" action="" method="POST" onsubmit="event.preventDefault(); updateBook();">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-4">
                    <label for="editTitle" class="block text-sm font-medium">Title</label>
                    <input id="editTitle" name="title" type="text" class="w-full px-3 py-2 border rounded-md"
                        required>
                </div>
                <div class="mb-4">
                    <label for="editAuthor" class="block text-sm font-medium">Author</label>
                    <input id="editAuthor" name="author" type="text" class="w-full px-3 py-2 border rounded-md"
                        required>
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium">Description</label>
                    <textarea id="editDescription" name="description" class="w-full px-3 py-2 border rounded-md" required></textarea>
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-white bg-gray-400 rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let totalPages = 1;

        // Function to Fetch Books with Pagination
        function fetchBooks(page = 1) {
            fetch(`/api/books?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById("bookTableBody");
                    tableBody.innerHTML = '';

                    if (data && Array.isArray(data.data)) {
                        data.data.forEach(book => {
                            const row = document.createElement("tr");
                            row.innerHTML = `
                              <td class="p-2 border">${book.id}</td>
                              <td class="p-2 border">${book.title}</td>
                              <td class="p-2 border">${book.author}</td>
                              <td class="p-2 border">${book.description}</td>
                              <td class="p-2 border">
                                  <button onclick="openEditModal(${book.id}, '${book.title}', '${book.author}', '${book.description}')" class="px-2 py-1 text-white bg-yellow-500 rounded-md">Edit</button>
                                  <form action="/api/books/${book.id}" method="POST" class="mt-2" onsubmit="event.preventDefault(); deleteBook(${book.id})">
                                      <input type="hidden" name="_method" value="DELETE">
                                      <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded-md">Delete</button>
                                  </form>
                              </td>
                          `;
                            tableBody.appendChild(row);
                        });
                    }

                    totalPages = data.last_page;
                    currentPage = data.current_page;
                    updatePaginationButtons();
                })
                .catch(error => {
                    console.error("Error fetching books:", error);
                });
        }

        // Update Pagination Buttons
        function updatePaginationButtons() {
            const prevButton = document.getElementById("prevPage");
            const nextButton = document.getElementById("nextPage");

            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;
        }

        // Handle Next Page Button Click
        document.getElementById("nextPage").addEventListener("click", () => {
            if (currentPage < totalPages) {
                fetchBooks(currentPage + 1);
            }
        });

        // Handle Previous Page Button Click
        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) {
                fetchBooks(currentPage - 1);
            }
        });

        // Delete Book and Refresh Page
        function deleteBook(bookId) {
            fetch(`/api/books/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    }),
                })
                .then(response => {
                    if (response.ok) {
                        fetchBooks(currentPage); // Refresh books after deletion
                    } else {
                        console.error("Failed to delete the book");
                    }
                })
                .catch(error => {
                    console.error("Error deleting book:", error);
                });
        }

        // Update Book
        function updateBook() {
            const form = document.getElementById("editForm");
            const formData = new FormData(form);
            const bookId = form.action.split('/').pop();

            fetch(`/api/books/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        title: formData.get('title'),
                        author: formData.get('author'),
                        description: formData.get('description')
                    })
                })
                .then(response => {
                    if (response.ok) {
                        closeEditModal();
                        fetchBooks(currentPage); // Refresh books after edit
                    } else {
                        console.error("Failed to update the book");
                    }
                })
                .catch(error => {
                    console.error("Error updating book:", error);
                });
        }

        // Open Edit Modal
        function openEditModal(id, title, author, description) {
            document.getElementById("editForm").action = `/api/books/${id}`;
            document.getElementById("editTitle").value = title;
            document.getElementById("editAuthor").value = author;
            document.getElementById("editDescription").value = description;
            document.getElementById("editModal").classList.remove("hidden");
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
        }

        // Load Books on Page Load
        window.onload = fetchBooks;
    </script>
</x-app-layout>
