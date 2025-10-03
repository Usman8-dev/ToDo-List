{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        li{
            list-style-type: none
        }
    </style>
</head>
<body>
    <h1>Todo List</h1>

    <form action="/tasks" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Enter Title">
        <input type="text" name="description" placeholder="Enter description" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        @foreach ($tasks as $task)
        @if (!$task->completed)  <!-- Show only incomplete tasks -->
            <li>
                <input type="checkbox" onclick="markAsCompleted({{ $task->id }})">
                <span>Title: </span>{{ $task->title }} <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Description: </span>{{ $task->description }}
                
                <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
        
                 <button type="button" onclick="openEditModal({{ $task->id }}, '{{ $task->title }}', '{{ $task->description }}')">Edit</button>
                
            </li>
            @endif
        @endforeach
    </ul>

        <!-- Completed Tasks Section (Foldable) -->
            <h2 onclick="toggleCompletedTab()" style="cursor: pointer;">
                Completed <span id="toggleIcon">🔽</span>
            </h2>
            <ul id="completedList" style="display: none;">
                @foreach ($tasks as $task)
                    @if ($task->completed)  <!-- Show only completed tasks -->
                        <li>
                            <input type="checkbox" checked onclick="toggleTaskCompletion({{ $task->id }}, false)">
                            <span>Title: </span>{{ $task->title }} <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Description: </span>{{ $task->description }}
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Edit Modal -->
                <div id="editModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                background: white; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0,0,0,0.2);">

                <h3>Edit Task</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="taskId">
                    <input type="text" id="editTitle" name="title">
                    <input type="text" id="editDescription" name="description" required>
                    <button type="submit">Update Task</button>
                    <button type="button" onclick="closeEditModal()">Cancel</button>
                </form>
                </div>

            <script>
                function openEditModal(id, title, description) {
                    document.getElementById("taskId").value = id;
                    document.getElementById("editTitle").value = title;
                    document.getElementById("editDescription").value = description;
                    document.getElementById("editForm").action = "/tasks/" + id;
                    document.getElementById("editModal").style.display = "block";
                }
            
                function closeEditModal() {
                    document.getElementById("editModal").style.display = "none";
                }
            </script>
<script>
    function markAsCompleted(taskId) {
        fetch('/tasks/' + taskId + '/complete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        }).then(response => location.reload());
    }
</script>

<script>
    // Toggle Completed Section Visibility
    function toggleCompletedTab() {
        let completedList = document.getElementById("completedList");
        let toggleIcon = document.getElementById("toggleIcon");

        if (completedList.style.display === "none") {
            completedList.style.display = "block";
            toggleIcon.innerHTML = "🔼"; // Arrow up
        } else {
            completedList.style.display = "none";
            toggleIcon.innerHTML = "🔽"; // Arrow down
        }
    }

    // Toggle Task Completion (Mark Completed or Move Back)
    function toggleTaskCompletion(taskId, isCompleted) {
        fetch('/tasks/' + taskId + '/toggle', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ completed: isCompleted })
        }).then(response => location.reload());
    }
</script>


            
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            /* background-color:rgb(31, 23, 23);  */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background-color: #007bff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-size: 18px;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            margin: 0 10px;
        }

        /* Main Content */
        .container { 
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            margin-top: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #007bff;
        }

        /* Form */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Task List */
        ul {
            padding: 0;
        }

        li {
            list-style: none;
            background: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Footer */
        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .navbar {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <span>Todo List</span>
        <nav>
            <a href="#">Home</a>
            <a href="#">Tasks</a>
            <a href="#">About</a>
        </nav>
    </div>

    <!-- Main Container -->
    <div class="container">
        <h1>Todo List</h1>

        <!-- Task Form -->
        <form action="/tasks" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Enter Title">
            <input type="text" name="description" placeholder="Enter Description" required>
            <button type="submit">Add Task</button>
        </form>

        <!-- Incomplete Tasks -->
        <ul>
            @foreach ($tasks as $task)
                @if (!$task->completed)
                    <li>
                        <div>
                            <input type="checkbox" onclick="markAsCompleted({{ $task->id }})">
                            <strong>{{ $task->title }}</strong> - {{ $task->description }}
                        </div>
                        <div>
                            <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                            <button type="button" onclick="openEditModal({{ $task->id }}, '{{ $task->title }}', '{{ $task->description }}')">Edit</button>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>

        <!-- Completed Tasks Section -->
        <h2 onclick="toggleCompletedTab()" style="cursor: pointer;">
            Completed <span id="toggleIcon">🔽</span>
        </h2>
        <ul id="completedList" style="display: none;">
            @foreach ($tasks as $task)
                @if ($task->completed)
                    <li>
                        <input type="checkbox" checked onclick="toggleTaskCompletion({{ $task->id }}, false)">
                        <strong>{{ $task->title }}</strong> - {{ $task->description }}
                        
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: white; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0,0,0,0.2);">
        <h3>Edit Task</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="taskId">
            <input type="text" id="editTitle" name="title">
            <input type="text" id="editDescription" name="description" required>
            <button type="submit">Update Task</button>
            <button type="button" onclick="closeEditModal()">Cancel and press</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 Todo List. All rights reserved.
    </div>

    <!-- Scripts -->
    <script>
        function openEditModal(id, title, description) {
            document.getElementById("taskId").value = id;
            document.getElementById("editTitle").value = title;
            document.getElementById("editDescription").value = description;
            document.getElementById("editForm").action = "/tasks/" + id;
            document.getElementById("editModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }

        function markAsCompleted(taskId) {
            fetch('/tasks/' + taskId + '/complete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(response => location.reload());
        }

        function toggleCompletedTab() {
            let completedList = document.getElementById("completedList");
            let toggleIcon = document.getElementById("toggleIcon");

            if (completedList.style.display === "none") {
                completedList.style.display = "block";
                toggleIcon.innerHTML = "🔼";
            } else {
                completedList.style.display = "none";
                toggleIcon.innerHTML = "🔽";
            }
        }

        function toggleTaskCompletion(taskId, isCompleted) {
            fetch('/tasks/' + taskId + '/toggle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ completed: isCompleted })
            }).then(response => location.reload());
        }
    </script>

</body>
</html>
