<!DOCTYPE html>
<html>
<head>
    <title>Task Assigned</title>
</head>
<body>
    <h2>Hello {{ $assignedUser }},</h2>
    <p>You have been assigned a new task.</p>
    <p><strong>Title:</strong> {{ $taskTitle }}</p>
    <p><strong>Description:</strong> {{ $taskDescription }}</p>
    <p><strong>Due Date:</strong> {{ $dueDate }}</p>
</body>
</html>