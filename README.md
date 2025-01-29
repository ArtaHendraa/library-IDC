# Library IDC API Documentation

This is a library management system built with Laravel. It provides a RESTful API for performing CRUD operations on books. You can add, update, retrieve, and delete books via the API.

---

## Installation

To install and use this API, follow these steps:

1. **Clone the Repository**

    Clone this repository by running the following command:

    ```bash
    git clone https://github.com/ArtaHendraa/library-IDC.git
    ```

2. **Install Dependencies (PHP)**

    Install the necessary PHP dependencies by running:

    ```bash
    composer install
    ```

3. **Set up the Environment File**

    Copy the `.env.example` file to `.env` and update your database and environment settings:

    ```bash
    cp .env.example .env
    ```

    Then, open the `.env` file and configure your database and other necessary variables.

4. **Generate Application Key**

    Generate the application key by running the following command:

    ```bash
    php artisan key:generate
    ```

5. **Migrate the Database**

    Run the migrations to create the necessary database tables:

    ```bash
    php artisan migrate
    ```

6. **Generate Dummy Data (Optional)**

    Generate dummy data using Laravel Factory, run:

    ```bash
    php artisan db:seed
    ```

7. **Install JavaScript Dependencies**

    Instal tailwind css by Using these command:

    ```bash
    npm install
    ```

8. **Build Front-End Assets**

    After installing the dependencies, compile the front-end assets:

    ```bash
    npm run dev
    ```

9. **Start the Laravel Server**

    Finally, start the Laravel server with:

    ```bash
    php artisan serve
    ```

    Your application will be available at `http://127.0.0.1:8000`.

---

## Base URL

```
/api/books
```

---

## Endpoints

### 1. List Books

#### **GET** `/api/books`

Fetch a paginated list of books.

#### Request

No request body is needed.

#### Response

-   **200 OK** – Successfully retrieved the list of books.

```json
{
    "status_code": 200,
    "total_data": 100,
    "data_per_page": 25,
    "last_page": 4,
    "success": true,
    "message": "Success Fetching Books Data",
    "next_page": "http://example.com/api/books?page=2",
    "current_page": 1,
    "prev_page": null,
    "data": [
        {
            "id": 1,
            "title": "Book Title 1",
            "author": "Author Name 1",
            "description": "Book Description 1"
        },
        {
            "id": 2,
            "title": "Book Title 2",
            "author": "Author Name 2",
            "description": "Book Description 2"
        }
    ]
}
```

-   **500 Internal Server Error** – An unexpected error occurred.

```json
{
    "status_code": 500,
    "data": null,
    "success": false,
    "message": "Error Message"
}
```

---

### 2. Create a Book

#### **POST** `/api/books`

Create a new book in the library.

#### Request Body

```json
{
    "title": "Book Title",
    "description": "Book Description",
    "author": "Author Name"
}
```

#### Validation Rules

-   **title**: Required, string, min: 5 characters, max: 255 characters.
-   **description**: Required, string, min: 50 characters.
-   **author**: Required, string, min: 4 characters, max: 255 characters.

#### Response

-   **201 Created** – Successfully created a new book.

```json
{
    "code": 201,
    "success": true,
    "message": "Successfully Added Book Data"
}
```

-   **422 Unprocessable Entity** – Validation error.

```json
{
    "status_code": 422,
    "data": null,
    "success": false,
    "message": "Validation error message"
}
```

---

### 3. Retrieve a Book

#### **GET** `/api/books/{id}`

Fetch a specific book by its ID.

#### Response

-   **200 OK** – Successfully retrieved the book details.

```json
{
    "code": 200,
    "success": true,
    "message": "Success Fetching Book Data",
    "data": {
        "id": 1,
        "title": "Book Title",
        "author": "Author Name",
        "description": "Book Description"
    }
}
```

-   **404 Not Found** – The book with the specified ID was not found.

```json
{
    "status_code": 404,
    "data": null,
    "success": false,
    "message": "Book Not Found"
}
```

---

### 4. Update a Book

#### **PUT** `/api/books/{id}`

Update the details of an existing book by its ID.

#### Request Body

```json
{
    "title": "Updated Book Title",
    "description": "Updated Book Description",
    "author": "Updated Author Name"
}
```

#### Validation Rules

-   **title**: Required, string, min: 5 characters, max: 255 characters.
-   **description**: Required, string, min: 50 characters.
-   **author**: Required, string, min: 4 characters, max: 255 characters.

#### Response

-   **200 OK** – Successfully updated the book details.

```json
{
    "code": 200,
    "success": true,
    "message": "Book Data updated successfully!"
}
```

-   **404 Not Found** – The book with the specified ID was not found.

```json
{
    "status_code": 404,
    "data": null,
    "success": false,
    "message": "Book Not Found"
}
```

-   **500 Internal Server Error** – An unexpected error occurred.

```json
{
    "status_code": 500,
    "data": null,
    "success": false,
    "message": "Error Message"
}
```

---

### 5. Delete a Book

#### **DELETE** `/api/books/{id}`

Delete a specific book by its ID.

#### Response

-   **200 OK** – Successfully deleted the book.

```json
{
    "status_code": 200,
    "success": true,
    "message": "Book deleted successfully",
    "data": null
}
```

-   **404 Not Found** – The book with the specified ID was not found.

```json
{
    "status_code": 404,
    "data": null,
    "success": false,
    "message": "Book Not Found"
}
```

-   **500 Internal Server Error** – An unexpected error occurred.

```json
{
    "status_code": 500,
    "data": null,
    "success": false,
    "message": "Error Message"
}
```

---

## Error Handling

If any error occurs during an API request, the server will return a response with a `status_code`, a message detailing the error, and the `success` key set to `false`.
