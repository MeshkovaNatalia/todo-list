# Todo List Symfony Project

This project is a simple to-do list application built using Symfony framework. You can add new tasks, mark them as completed, and delete them.

## Features

- Adding new tasks.
- Marking tasks as completed.
- Deleting tasks.
- Marking tasks as completed.

## Installation

1. Clone the repository:

```
git clone git@github.com:MeshkovaNatalia/todo-list.git
```

2. Navigate to the project directory:

```
cd todo-list
```

3. Install dependencies:

```
composer install
```

## Usage

1. Run the Symfony server:

```
symfony server:start
```

2. Open your browser and go to `http://localhost`.

3. Add new tasks, mark them as completed, and delete them.

## Routes

- `/tasks` - Display all tasks.
- `POST /tasks` - Add a new task.
- `PATCH /tasks/{id}` - Update a task's completion status.
- `DELETE /tasks/{id}` - Delete a task.
- `GET /tasks/{id}` - Display a single task.
- `POST` /tasks/{id}/mark-as-completed - Mark a task as completed.

### Filtering and Sorting

When retrieving the list of tasks, users can:

- Filter by `status` field.
- Filter by `priority` field.
- Filter by `title` and `description` fields using full-text search.
- Sort by `createdAt`, `completedAt`, and `priority`. Support for sorting by two fields simultaneously is available. For example, `priority desc, createdAt asc`.

## Demo

[Link to demo](http://localhost)

## Contributing

If you have suggestions for improving this project, please create a new branch, make changes, and propose them for merging.

## Author

Author: Meshkova Natalia (@natatia740)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
