<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Post a Job - HireHub</title>
  <style>
    body {
      background: #f9fafb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px 15px;
    }

    .container {
      max-width: 600px;
      background: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.1);
      margin: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #f47f4c;
      font-weight: 700;
    }

    label {
      font-weight: 600;
      color: #444;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px 15px;
      margin-top: 6px;
      margin-bottom: 20px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    textarea:focus,
    input[type="file"]:focus {
      outline: none;
      border-color: #f47f4c;
      box-shadow: 0 0 6px #f47f4caa;
    }

    textarea {
      resize: vertical;
    }

    button[type="submit"] {
      background-color: #f47f4c;
      border: none;
      color: white;
      font-weight: 700;
      padding: 12px 0;
      width: 100%;
      border-radius: 10px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
    }

    button[type="submit"]:hover {
      background-color: #d96b2b;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 30px;
      font-weight: 600;
      color: #f47f4c;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Post a New Job</h2>

    <form action="postJobLogic.php" method="POST" enctype="multipart/form-data" novalidate>
      <label for="title">Job Title</label>
      <input type="text" name="title" id="title" required placeholder="e.g. Senior Software Engineer">

      <label for="company">Company Name</label>
      <input type="text" name="company" id="company" required placeholder="Your Company Name">

      <label for="location">Location</label>
      <input type="text" name="location" id="location" required placeholder="City, State or Remote">

      <label for="category">Category</label>
      <input type="text" name="category" id="category" required placeholder="e.g. IT, Marketing, Sales">

      <label for="description">Job Description</label>
      <textarea name="description" id="description" rows="6" required placeholder="Describe the job, responsibilities, requirements..."></textarea>

      <label for="image">Upload Company Logo or Image</label>
      <input type="file" name="image" id="image" accept="image/*">

      <button type="submit">Post Job</button>
    </form>

    <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
  </div>
</body>

</html>
